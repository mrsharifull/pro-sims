<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRequest;
use App\Models\Class_;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassController extends Controller
{
    public function index(){
        $s['classes'] = Class_::where('deleted_at',null)->latest()->get();
        return view('backend.setup.class.index',$s);
    }
    public function details($id): JsonResponse
    {
        $class = Class_::where('id',$id)->where('deleted_at',null)->first();
        $class['created_date'] = date('d M, Y', strtotime($class->created_at));
        $class['updated_date'] = ($class->updated_at != $class->created_at) ? (date('d M, Y', strtotime($class->updated_at))) : 'N/A';
        $class['created_user'] = $class->created_by ? $class->createdBy->name : 'System';
        $class['updated_user'] = $class->updated_by ? $class->updatedBy->name : 'N/A';
        $s['class'] = $class;
        return response()->json($s);
    }
    public function create(){
        return view('backend.setup.class.create');
    }

    public function store(ClassRequest $req): RedirectResponse
    {
        $class =new Class_();
        $class->name = $req->name;
        $class->number = $req->number;
        $class->created_by = auth()->user()->id;
        $class->save();
        return redirect()->route('setup.class.class_list')->withStatus(__("Class $class->name created successfully"));     
    }
    public function edit($id): View
    {
        $s['class'] = Class_::findOrFail($id);
        return view('backend.setup.class.edit',$s);
    }
    public function update(ClassRequest $req, $id): RedirectResponse
    {
        $class = Class_::findOrFail($id);
        $class->name = $req->name;
        $class->number = $req->number;
        $class->updated_by = auth()->user()->id;
        $class->update();
        return redirect()->route('setup.class.class_list')->withStatus(__("Class $class->name updated successfully"));     
    }
    public function delete($id): RedirectResponse
    {
        $class = Class_::findOrFail($id);
        $class->delete();
        return redirect()->route('setup.class.class_list')->withStatus(__('Class '.$class->name.' deleted successfully.'));

    }
}
