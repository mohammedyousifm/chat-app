<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {

        $users = User::all();

        return view('dashboard', compact('users'));
    }
}
