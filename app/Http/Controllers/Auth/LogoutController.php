<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Auth::logout();
        return redirect()->route('todo')->with('success', 'berhasil logout');
    }
}
