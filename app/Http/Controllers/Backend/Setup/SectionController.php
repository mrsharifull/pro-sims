<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Class_;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $s['sections'] = Section::with('class_')->where('deleted_at',null)->get();
        return view('backend.setup.section.index',$s);
    }
    public function details($id): JsonResponse
    {
        $section = Section::with('class_')->where('id',$id)->where('deleted_at',null)->first();
        $section['created_date'] = date('d M, Y', strtotime($section->created_at));
        $section['updated_date'] = ($section->updated_at != $section->created_at) ? (date('d M, Y', strtotime($section->updated_at))) : 'N/A';
        $section['created_user'] = $section->created_by ? $section->createdBy->name : 'System';
        $section['updated_user'] = $section->updated_by ? $section->updatedBy->name : 'N/A';
        $s['section'] = $section;
        return response()->json($s);
    }
    public function create(){
        $s['classes'] = Class_::where('deleted_at',null)->orderBy('number')->get();
        return view('backend.setup.section.create',$s);
    }

    public function store(SectionRequest $req): RedirectResponse
    {
        $section =new Section();
        $section->name = $req->name;
        $section->class_id = $req->class_id;
        $section->created_by = auth()->user()->id;
        $section->save();
        return redirect()->route('setup.section.section_list')->withStatus(__("Section $section->name created successfully"));     
    }
    public function edit($id): View
    {
        $s['section'] = Section::findOrFail($id);
        $s['classes'] = Class_::where('deleted_at',null)->orderBy('number')->get();
        return view('backend.setup.section.edit',$s);
    }
    public function update(SectionRequest $req, $id): RedirectResponse
    {
        $section = Section::findOrFail($id);
        $section->name = $req->name;
        $section->class_id = $req->class_id;
        $section->updated_by = auth()->user()->id;
        $section->update();
        return redirect()->route('setup.section.section_list')->withStatus(__("Section $section->name updated successfully"));     
    }
    public function delete($id): RedirectResponse
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return redirect()->route('setup.section.section_list')->withStatus(__('Section '.$section->name.' deleted successfully.'));

    }
}
