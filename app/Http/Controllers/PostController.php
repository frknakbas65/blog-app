<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function deletePost(Post $post){
        if(auth()->user()->id == $post['user_id']){
            $post->delete();
        }
        return redirect('/');
    }
    public function actuallyUpdatePost(Post $post, Request $request){
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }

        $infos = $request->validate([
            'title' => 'required',
            'body' => 'required'

        ]);

        $infos['title'] = strip_tags($infos['title']);
        $infos['body'] = strip_tags($infos['body']);

        $post->update($infos);
        return redirect('/');
    }
 
    public function showEditScreen(Post $post){
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }
        
        return view('edit-post',['post' => $post]);

    }

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
