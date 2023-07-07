<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $request) {
        $infos = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $infos['title'] = strip_tags($infos['title']);
        $infos['body'] = strip_tags($infos['body']);
        $infos['user_id'] = auth()->id();
        Post::create($infos);
        return redirect('/');
    }
}
