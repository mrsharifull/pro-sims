<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(){
        $s['users'] = User::with(['role','createdBy','updatedBy'])->where('deleted_at',null)->get();
        return view('backend.user.index',$s);
    }
    public function create(){
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user.create',$s);
    }
    public function store(UserRequest $req){
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->role_id = $req->role;
        $user->password = Hash::make($req->password);
        $user->created_by = auth()->user()->id;
        $user->save();
        return redirect()->route('um.user.index')->with('success',"$user->name created successfully");     
    }
    public function edit($id){
        $s['user'] = User::with('role')->first();
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user.edit',$s);
    }
    public function update(UserRequest $req, $id){
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->role_id = $req->role;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
        $user->updated_by = auth()->user()->id;
        $user->update();
        return redirect()->route('um.user.index')->with('success',"$user->name updated successfully");     
    }
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.index')->with('error',"$user->name deleted successfully");   

    }

    public function status($id){
        $user = User::findOrFail($id);
        $this->changeStatus($user);
        return redirect()->route('um.user.index')->with('success',"$user->name status change successfully");   

    }
}
