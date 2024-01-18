<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AcademicDivision;
use App\Models\Bloodgroups;
use App\Models\Class_;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentController extends Controller
{
     public function index(): View
     {
         $s['students'] = Student::with(['class','section','ad','bg','createdBy'])->where('deleted_at',null)->get();
         return view('backend.student.index',$s);
     }
    //  public function details($id): JsonResponse
    //  {
    //      $user = User::with('role')->where('id',$id)->where('deleted_at',null)->first();
    //      $user['created_date'] = date('d M, Y', strtotime($user->created_at));
    //      $user['updated_date'] = ($user->updated_at != $user->created_at) ? (date('d M, Y', strtotime($user->updated_at))) : 'N/A';
    //      $user['created_user'] = $user->created_by ? $user->createdBy->name : 'System';
    //      $user['updated_user'] = $user->updated_by ? $user->updatedBy->name : 'N/A';
    //      $s['user'] = $user;
    //      return response()->json($s);
    //  }
     public function create(): View
     {
         $s['classes'] = Class_::where('deleted_at',null)->latest()->get();
         $s['ads'] = AcademicDivision::where('deleted_at',null)->latest()->get();
         $s['bgs'] = Bloodgroups::where('deleted_at',null)->latest()->get();
         return view('backend.student.create',$s);
     }
    //  public function store(UserRequest $req): RedirectResponse
    //  {
    //      $user = new User();
    //      $user->name = $req->name;
    //      $user->email = $req->email;
    //      $user->role_id = $req->role;
    //      $user->password = Hash::make($req->password);
    //      $user->created_by = auth()->user()->id;
    //      $user->save();
 
    //      $user->assignRole($user->role->name);
 
    //      return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' created successfully.'));
    //  }
    //  public function edit($id): View
    //  {
    //      $s['user'] = User::findOrFail($id);
    //      $s['roles'] = Role::where('deleted_at',null)->latest()->get();
    //      return view('backend.user_management.user.edit',$s);
    //  }
    //  public function update(UserRequest $req, $id): RedirectResponse
    //  {
    //      $user = User::findOrFail($id);
    //      $user->name = $req->name;
    //      $user->email = $req->email;
    //      $user->role_id = $req->role;
    //      if($req->password){
    //          $user->password = Hash::make($req->password);
    //      }
    //      $user->updated_by = auth()->user()->id;
    //      $user->update();
 
    //      $user->assignRole($user->role->name);
         
    //      return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' updated successfully.'));
    //  }
    //  public function status($id): RedirectResponse
    //  {
    //      $user = user::findOrFail($id);
    //      $this->statusChange($user);
    //      return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' status updated successfully.'));
    //  }
    //  public function delete($id): RedirectResponse
    //  {
    //      $user = User::findOrFail($id);
    //      $user->delete();
    //      return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' deleted successfully.'));
 
    //  }
 
}
