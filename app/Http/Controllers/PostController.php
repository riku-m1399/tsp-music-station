<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        // Validation
        $request->validate([
            'category' => 'required|array|between:1,3',
            'name' => 'required|max:50',
            'artist' => 'required|max:50',
            'description' => 'max:1000',
            'url' => 'url|nullable',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        // recieve all data from form
        $this->post->user_id = Auth::user()->id; // store the id of the user who created the post
        $this->post->name = $request->name;
        $this->post->artist = $request->artist;
        $this->post->description = $request->description;
        $this->post->url = $request->url;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->save();

        // save categories
        foreach ($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $this->post->categoryPost()->createMany($category_post);

        // go back to homepage
        return redirect()->route('index');
    }

    public function show($id){
        $post = $this->post->findOrFail($id);
        $artist_youtubes = $this->getArtistInfoOnYoutube($id);
        return view('users.posts.show')->with('post', $post)->with('artist_youtubes', $artist_youtubes);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);

        // If AUTH user is not the owner of the post, redirect to home
        if(Auth::user()->id != $post->user_id){
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();
        
        $selected_categories = [];
        foreach($post->categoryPost as $category_post){
            $selected_categories[] = $category_post->category_id;
        }
        

        return view('users.posts.edit')->with('all_categories', $all_categories)->with('post', $post)->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){
        // Validation
        $request->validate([
            'category' => 'required|array|between:1,3',
            'name' => 'required|max:50',
            'artist' => 'required|max:50',
            'description' => 'max:1000',
            'url' => 'url|nullable',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        $post = $this->post->findOrFail($id);

        // recieve all data from form
        $post->name = $request->name;
        $post->artist = $request->artist;
        $post->description = $request->description;
        $post->url = $request->url;
        if($request->image){
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }
        $post->save();

        // delete all the records from categoryPost related to the post
        $post->categoryPost()->delete();

        // save the new categories
        foreach ($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        $this->post->destroy($id);
        return redirect()->route('index');
    }

    public function getArtistInfoOnYoutube($id){
        $post = $this->post->findOrFail($id);
        $artist = $post->artist;
        $artist_info = $this->searchArtistOnYoutube($artist);

        return $artist_info;
    }

    public function searchArtistOnYoutube($artist){
        define('YOUTUBE_API_KEY', 'AIzaSyBVXUoy58DpGFEr46gy1W0fKsujX9NxIEc'); // API key

        $url = "https://www.googleapis.com/youtube/v3/search";
        $part = array(
        'snippet',
        );

        $query = array(
            'key' => YOUTUBE_API_KEY,
            'q' => $artist, // the word you want to search for
            'part' => implode(",",$part),
            'order' => 'relevance',
            'maxResults' => 3,
            'type' => 'video',
        );

        $results = $this->curl($url, $query);
        $results_array = json_decode($results, true);

        $items = [];
        for($i = 0; $i <= 2; $i++){
            $items[] = $results_array["items"][$i];
        }

        return $items;
    }

    function curl($url, $query){
        $param = http_build_query($query, '', '&');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url."?".$param);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
