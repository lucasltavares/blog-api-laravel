<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{

    private $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }
    public function index() {

        $result = $this->isAdmin() ?
            $this->postService->getAllPosts() :
            $this->postService->getUserPosts(auth()->user()->id);

        return response()->json($result, 200);
    }

    public function show($id) {

        $post = $this->isAdmin() ?
            $this->postService->getPostById($id) :
            $this->postService->getUserPostById($id);

        if ($post) {
            return response()->json($post, 200);
        } else {
            return response()->json([
                "message" => "Post record not found."
            ], 404);
        }
    }

    public function store(Request $request) {
        $post = new Post;
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = auth()->user()->id;
        $post->save(); // add Try catch

        return response()->json([
            "message" => "post record created successfully."
        ], 201);
    }

    //corrigir all nullable false positive
    public function update(Request $request, $id) {
        $user_id = auth()->user()->id;

        if ($this->isAdmin()) {
            if(Post::where('id', $id)->exists()) {
                $post = Post::find($id);
                $post->title = is_null($request->title) ? $post->title : $request->title; // Verifica nulidade para atualizar parâmetros únicos.
                $post->text = is_null($request->text) ? $post->text : $request->text;
                $post->save();

                return response()->json([
                    "message" => "records updated successfully."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Post not found."
                ], 404);
            }
        } else {
          if (Post::where('id', $id)->where('user_id', '=', $user_id)->exists()) {
              $post = Post::find($id);
              $post->title = is_null($request->title) ? $post->title : $request->title; // Verifica nulidade para atualizar parâmetros únicos.
              $post->text = is_null($request->text) ? $post->text : $request->text;
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


    }

    public function destroy($id) {
        $user_id = auth()->user()->id;

        if ($this->isAdmin()) {
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
        } else {
            if (Post::where('id', $id)->where('user_id', '=', $user_id)->exists()) {
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

    private function isAdmin() {
        $role = auth()->user()->is_admin;
        if ($role) { return true; }
    }
}
