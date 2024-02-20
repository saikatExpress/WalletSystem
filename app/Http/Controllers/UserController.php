<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::all();

        return view('admin.user.index')->with($data);
    }


    public function create()
    {
        $users = User::where('status', '1')->latest()->get();

        return view('admin.user.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name'         => ['required'],
                'email'        => ['required', 'unique:users'],
                'phone_number' => ['required','unique:users'],
                'password'     => ['required','min:6'],
                'status'       => ['required'],
                'role'         => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $userObj = new User;

            $userObj->name         = $request->input('name');
            $userObj->email        = $request->input('email');
            $userObj->phone_number = $request->input('phone_number');
            $userObj->password     = Hash::make($request->input('password'));
            $userObj->status       = $request->input('status');
            $userObj->role         = $request->input('role');

            $res = $userObj->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'User Create Successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function userDetails($id)
    {
        $user = User::find($id);

        return view('admin.user.profile', compact('user'));
    }
}