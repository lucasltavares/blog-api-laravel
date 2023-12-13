<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        if ($this->isAdmin()) {
            $result = Post::get();

            return response()->json($result, 200);
        } else {
            $user_id = auth()->user()->id;
            $result = Post::where('user_id', $user_id)->get();

            return response()->json($result, 200);
        }

    }

    public function show($id) {

        $user_id = auth()->user()->id;

        if ($this->isAdmin()) {
            $post = Post::where('id', $id)->get();
            return response()->json($post, 200);
        }

        if (Post::where('id', $id)->where('user_id', '=', $user_id)->exists()) {
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

    public function isAdmin() {
        $role = auth()->user()->is_admin;
        if ($role) { return true; }
    }
}
