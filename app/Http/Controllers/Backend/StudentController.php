<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\AcademicDivision;
use App\Models\Bloodgroups;
use App\Models\Class_;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
    //      $student = User::with('role')->where('id',$id)->where('deleted_at',null)->first();
    //      $student['created_date'] = date('d M, Y', strtotime($student->created_at));
    //      $student['updated_date'] = ($student->updated_at != $student->created_at) ? (date('d M, Y', strtotime($student->updated_at))) : 'N/A';
    //      $student['created_user'] = $student->created_by ? $student->createdBy->name : 'System';
    //      $student['updated_user'] = $student->updated_by ? $student->updatedBy->name : 'N/A';
    //      $s['user'] = $student;
    //      return response()->json($s);
    //  }
     public function create(): View
     {
         $s['classes'] = Class_::where('deleted_at',null)->latest()->get();
         $s['ads'] = AcademicDivision::where('deleted_at',null)->latest()->get();
         $s['bgs'] = Bloodgroups::where('deleted_at',null)->latest()->get();
         return view('backend.student.create',$s);
     }
     public function store(StudentRequest $req): RedirectResponse
     {
         $student = new Student();

         if ($req->hasFile('image')) {
            $image = $req->file('image');
            $path = $image->store('students', 'public');
            $student->image = $path;
        }
         $student->name = $req->name;
         $student->father_name = $req->father_name;
         $student->mother_name = $req->mother_name;
         $student->roll = $req->roll;
         $student->registration = $req->registration;
         $student->class_id = $req->class_id;
         $student->section_id = $req->section_id;
         $student->ad_id = $req->ad_id;
         $student->bg_id = $req->bg_id;
         $student->address = $req->address;
         $student->date_of_birth = $req->date_of_birth;
         $student->number = $req->number;
         $student->parents_number = $req->parents_number;
         $student->age = $req->age;
         $student->gender = $req->gender;
         $student->created_by = auth()->user()->id;
         $student->save();
 
         return redirect()->route('student.student_list')->withStatus(__('Student '.$student->name.' created successfully.'));
     }

     public function classSection($class_id){
        $s['sections'] = Section::where('deleted_at',null)->where('class_id',$class_id)->orderBy('name')->get();
        return response()->json($s);
     }
     public function edit($id): View
     {
         $s['student'] = Student::findOrFail($id);
         $s['classes'] = Class_::where('deleted_at',null)->latest()->get();
         $s['sections'] = Section::where('deleted_at',null)->latest()->get();
         $s['ads'] = AcademicDivision::where('deleted_at',null)->latest()->get();
         $s['bgs'] = Bloodgroups::where('deleted_at',null)->latest()->get();
         return view('backend.student.edit',$s);
     }
     public function update(StudentRequest $req, $id): RedirectResponse
     {
         $student = Student::findOrFail($id);

        



         if ($req->hasFile('image')) {
            $image = $req->file('image');
            $path = $image->store('students', 'public');
            $this->fileDelete($student->image);
            $student->image = $path;
        }
        $student->name = $req->name;
        $student->father_name = $req->father_name;
        $student->mother_name = $req->mother_name;
        $student->roll = $req->roll;
        $student->registration = $req->registration;
        $student->class_id = $req->class_id;
        $student->section_id = $req->section_id;
        $student->ad_id = $req->ad_id;
        $student->bg_id = $req->bg_id;
        $student->address = $req->address;
        $student->date_of_birth = $req->date_of_birth;
        $student->number = $req->number;
        $student->parents_number = $req->parents_number;
        $student->age = $req->age;
        $student->gender = $req->gender;
        $student->updated_by = auth()->user()->id;
        $student->update();

         
         return redirect()->route('student.student_list')->withStatus(__('Student '.$student->name.' updated successfully.'));
     }
    //  public function status($id): RedirectResponse
    //  {
    //      $student = user::findOrFail($id);
    //      $this->statusChange($student);
    //      return redirect()->route('um.user.user_list')->withStatus(__('User '.$student->name.' status updated successfully.'));
    //  }
    //  public function delete($id): RedirectResponse
    //  {
    //      $student = User::findOrFail($id);
    //      $student->delete();
    //      return redirect()->route('um.user.user_list')->withStatus(__('User '.$student->name.' deleted successfully.'));
 
    //  }
 
}
