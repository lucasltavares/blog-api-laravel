<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if ($this->isAdmin() ) { //Admin
            $user = User::get();

            return response()->json($user, 200);
        } else {
            $id = auth()->user()->id;
            $user = User::where('id', $id)->get();

            return response()->json($user, 200);
        }

    }
    public function store(Request $request)
    {

        if ($this->isAdmin() ) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            $user->save();

            return response()->json([
                "message" => "user record created successfully."
            ], 201);
        } else {
            return response()->json([
                "message" => "Invalid permissions."
            ], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        if ($this->isAdmin()) {
            $id = auth()->user()->id;
            $user = User::where('id', $id)->get();

            return response()->json($user, 200);
        } else {
            return response()->json([
                "message" => "Invalid permissions."
            ], 401);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        if ($this->isAdmin()) {
            $user = User::find($id);

            if ($user->exists()) {

                $user->name = is_null($request->name) ? $user->name : $request->name;
                $user->email = is_null($request->email) ? $user->email : $request->email;
                $user->is_admin = is_null($request->is_admin) ? $user->is_admin : $request->is_admin;

                $user->save();

                return response()->json([
                    "message:" => "User record successfully updated."
                ], 200);
            } else {
                return response()->json([
                    "message:" => "Record not found."
                ], 204);
            }
        } else {
            return response()->json([
                "message" => "Invalid permissions."
            ], 401);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->isAdmin()) {
            $user = User::find($id);

            if ($user->exists()) {
                $user->delete();
                return response()->json([
                    "message:" => "User record successfully deleted."
                ], 202);
            } else {
                return response()->json([
                    "message" => "User record not found."
                ], 404);
            }
        } else {
            return response()->json([
                "message" => "Invalid permissions."
            ], 401);
        }

    }

    private function isAdmin() {
        $role = auth()->user()->is_admin;
        if ($role) { return true; } else { return false; }
    }
}
