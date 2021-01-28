<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:posts-administrator');
    }

    public function index(){
        $posts = Post::all();
        return view('posts.index',compact('posts'));
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
           'title' => ['required','string','max:255'],
           'message' => ['required','string','max:255'],
        ]);

        Post::create($validatedData);

        return redirect('/posts')->with('success','Post erfolgreich erstellt!');
    }
}
