<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function detail(User $user){
        $users = DB::select('Select * from users');
        dd($users);
        return view('user_detail',['user' => $user] );
    }
}
