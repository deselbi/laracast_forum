<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $threads = $user->threads()->paginate(30);
        return view('profiles.show', compact('user', 'threads'));
    }
}
