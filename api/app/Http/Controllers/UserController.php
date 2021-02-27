<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select(['id', 'name', 'email'])->get();

        return response()->json($users, Response::HTTP_OK);
    }
}
