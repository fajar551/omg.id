<?php

namespace App\Http\Controllers\Client\Creator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CreatorStoreController extends Controller
{
    public function show($username)
    {
        $creator = User::where('username', $username)->where('role', 'creator')->firstOrFail();
        $products = $creator->products;
        return view('creator.store', compact('creator', 'products'));
    }
} 