<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    public function store($following_id){
        $this->follow->follower_id = Auth::user()->id;
        $this->follow->following_id = $following_id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($following_id){
        $this->follow->where('following_id', $following_id)->where('follower_id', Auth::user()->id)->delete();
        return redirect()->back();
    }
}
