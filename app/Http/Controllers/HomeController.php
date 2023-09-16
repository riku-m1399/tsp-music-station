<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;
    private $category;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user, Category $category)
    {
        $this->post = $post;
        $this->user = $user;
        $this->category = $category;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_posts = $this->getHomePosts();
        $all_categories = $this->category->all();

        return view('users.home')->with('home_posts', $home_posts)->with('all_categories', $all_categories);
    }

    public function getHomePosts(){
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id || $post->user->role_id === 1){
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    public function search(Request $request){
        $users = $this->user->where('name', 'like', '%'.$request->search.'%')->get();
        $categories = $this->category->where('name', 'like', '%'.$request->search.'%')->get();
        return view('users.search')->with('users', $users)->with('categories', $categories)->with('search', $request->search);
    }

}
