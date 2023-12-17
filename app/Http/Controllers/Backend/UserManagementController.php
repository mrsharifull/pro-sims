<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{

    public function __construct() {
        return $this->middleware('auth');
    }

    // User Methods 
    public function index(){
        $s['users'] = User::with(['role','createdBy','updatedBy'])->where('deleted_at',null)->get();
        return view('backend.user_management.user.index',$s);
    }
    public function create(){
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.create',$s);
    }
    public function store(UserRequest $req){
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->role_id = $req->role;
        $user->password = Hash::make($req->password);
        $user->created_by = auth()->user()->id;
        $user->save();
        $user->assignRole($user->role->name);
        return redirect()->route('um.user.user_list')->with('success',"$user->name created successfully");     
    }
    public function edit($id){
        $s['user'] = User::with('role')->first();
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.edit',$s);
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
        $user->assignRole($user->role->name);
        return redirect()->route('um.user.user_list')->with('success',"$user->name updated successfully");     
    }
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.user_list')->with('error',"$user->name deleted successfully");   

    }

    public function status($id){
        $user = User::findOrFail($id);
        $this->changeStatus($user);
        return redirect()->route('um.user.user_list')->with('success',"$user->name status change successfully");   

    }



    // Permission Methods PermissionRequest
    public function p_index(){
        $s['permissions'] = Permission::orderBy('prefix')->get();
        return view('backend.user_management.permission.index',$s);
    }
    public function p_create(){
        return view('backend.user_management.permission.create');
    }

    public function p_store(PermissionRequest $req){
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->created_by = auth()->user()->id;
        $permission->save();
        return redirect()->route('um.permission.permission_list')->with('success',"$permission->name permission created successfully");     
    }
    public function p_edit($id){
        $s['permission'] = Permission::findOrFail($id);
        return view('backend.user_management.permission.edit',$s);
    }
    public function p_update(PermissionRequest $req, $id){
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->updated_by = auth()->user()->id;
        $permission->update();
        return redirect()->route('um.permission.permission_list')->with('success',"$permission->name permission updated successfully");     
    }



    // Role Methods 
    public function r_index(){
        $s['roles'] = Role::where('deleted_at', null)->with('permissions')->latest()->get()
        ->map(function($role){
            $permissionNames = $role->permissions->pluck('name')->implode(' | ');
            $role->permissionNames = $permissionNames;
            return $role;
        });
        return view('backend.user_management.role.index', $s);
    }
    public function r_create(){
        $permissions = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.user_management.role.create',$s);
    }
    public function r_store(RoleRequest $req){
        $role = new Role();
        $role->name = $req->name;
        $role->created_by = auth()->user()->id;
        $role->save();
        
        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
        return redirect()->route('um.role.role_list')->with('success',"$role->name role created successfully");   


    }
    public function r_edit($id){
        $s['role'] = Role::findOrFail($id);
        $permissions = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.user_management.role.edit',$s);
    }
    public function r_update(RoleRequest $req, $id){
        $role = Role::findOrFail($id);
        $role->name = $req->name;
        $role->updated_by = auth()->user()->id;
        $role->update();
        
        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);
        return redirect()->route('um.role.role_list')->with('success',"$role->name role updated successfully");        
    }
    public function r_delete($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('um.role.role_list')->with('error',"$role->name deleted successfully");   

    }

}
