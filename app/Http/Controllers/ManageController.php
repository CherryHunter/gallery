<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;
use App\User;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
      if (auth()->user()->admin == 1){
      $users = User::where('admin', '0')->get();
      return view('manage')->with('users', $users);
    } else return redirect()->route('index');
    }

    public function getDeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('manage');
    }

}
