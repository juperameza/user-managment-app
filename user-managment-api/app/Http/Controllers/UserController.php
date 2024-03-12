<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $userName = $user->name;
        $user->delete();
        return response()->json(["message"=>"User $userName deleted"] , 200);
    }

    public function index()
    {
        return response()->json(User::all());
    }

    public function show(User $user)
    {
        return response()->json($user);
    }
}
