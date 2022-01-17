<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;

class PostController extends Controller
{

    public function __construct(){
        
    }
    public function index()
    {
        echo "on"; die;
        $posts = Post::all();
        return $posts;
    }
}