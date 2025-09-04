<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){

        $users = User::with('roles')->get();

        return view('dashboard.partials.main', compact('users'));
    }
}
