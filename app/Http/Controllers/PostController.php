<?php

namespace App\Http\Controllers;

use app\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::get();
        return response()->json($posts, 200);
    }

    public function show($id) {
        if (Post::where('id', $id)->exists()) {
            $post = Post::where('id', $id)->get();
            return response()->json($post, 200);
        } else {
            return response()->json([
                "message" => "Post not found."
            ], 404);
        }
    }

    public function store(Request $request) {
        $post = new Post;
        $post->name = $request->name;
        $post->course = $request->course;
        $post->save(); // add Try catch

        return response()->json([
            "message" => "post record created successfully."
        ], 201);
    }

    //corrigir all nullable false positive
    public function update(Request $request, $id) {
        if(Post::where('id', $id)->exists()) {
            $post = Post::find($id);
            $post->name = is_null($request->name) ? $post->name : $request->name; // Verifica nulidade para atualizar parâmetros únicos.
            $post->course = is_null($request->course) ? $post->course : $request->course;
            $post->save();

            return response()->json([
                "message" => "records updated successfully."
            ], 200);
        } else {
            return response()->json([
                "message" => "Post not found."
            ], 404);
        }
    }

    public function destroy($id) {
        if(Post::where('id', $id)->exists()) {
            $post = Post::find($id);
            $post->delete();

            return response()->json([
                "message" => "records deleted successfully."
            ], 202);
        } else {
            return response()->json([
                "message" => "Post not found."
            ], 404);
        }
    }
}
