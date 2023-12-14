<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function getAllPosts()
    {
        return Post::all();
    }

    public function getUserPosts($user_id) {
        return Post::where('user_id', $user_id)->get();
    }

    public function getPostById($id) {
        return Post::where('id', $id)->get();
    }

    public function getUserPostById($id) {
        $post = Post::where('id', $id)->where('user_id', '=', auth()->user()->id)->exists();

        if ($post) {
            return Post::where('id', $id)->where('user_id', '=', auth()->user()->id)->get();
        } else {
            return false;
        }

    }

    public function storePost($request) {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);

        return auth()->user()->posts()->create($request->only(['title', 'text']));
    }

    public function updateUserPost($request, $id) {

        $user = auth()->user();
        $post = $user->posts()->find($id);

        if ($post) {
            $post->update([
                'title' => $request->title,
                'text' => $request->text,
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function updatePost($request, $id) {

        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);

        $post = Post::where('id', $id)->get();

        if ($post->exists()) {
            $post->title = $request->title;
            $post->text = $request->text;

            return true;
        } else {
            return false;
        }
    }

    public function deletePost($id) {
        $post = Post::where('id', $id)->get();

        if ($post->exists()) {
            $post->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteUserPost($id) {

        $post = auth()->user()->posts()->find($id);

        if ($post) {
            $post->delete();
            return true;
        } else {
            return false;
        }
    }

}

?>
