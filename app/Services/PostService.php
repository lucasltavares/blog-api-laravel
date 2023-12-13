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
}

?>
