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
    public function store(Request $request)
    {
        $this->postService->storePost($request);

        return response()->json([
            "message" => "Post record created successfully.",
        ], 201);
    }

    //corrigir all nullable false positive
    public function update(Request $request, $id) {

        $result = $this->isAdmin() ?
            $this->postService->updatePost($request, $id) :
            $this->postService->updateUserPost($request, $id);

        if ($result) {
            return response()->json([
                "message" => "Post record updated sucessfully."
            ], 200);
        } else {
            return response()->json([
                "message" => "Post record not found."
            ], 404);
        }
    }

    public function destroy($id) {
        $result = $this->isAdmin() ?
            $this->postService->deletePost($id) :
            $this->postService->deleteUserPost($id);

        if ($result) {
            return response()->json([
                "message" => "Post record deleted successfully."
            ], 200);
        } else {
            return response()->json([
                "message" => "Post record not found."
            ], 404);
        }
    }

    private function isAdmin() {
        $role = auth()->user()->is_admin;
        if ($role) { return true; }
    }
}
