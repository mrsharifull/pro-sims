<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(){
        $s['users'] = User::all();
        return view('backend.user.index',$s);
    }
    public function create(){
        return view('backend.user.create');
    }
    public function store(UserRequest $req){
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();
        return redirect()->route('um.user.index')->with('success',"$user->name created successfully");     
    }
    public function edit($id){
        $s['user'] = User::findOrFail($id);
        return view('backend.user.edit',$s);
    }
    public function update(UserRequest $req, $id){
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->email = $req->email;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
        $user->update();
        return redirect()->route('um.user.index')->with('success',"$user->name updated successfully");     
    }
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.index')->with('error',"$user->name deleted successfully");   

    }
}
