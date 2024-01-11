<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicDivisionRequest;
use App\Models\AcademicDivision;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AcademicDivisionController extends Controller
{
    public function index(){
        $s['ads'] = AcademicDivision::where('deleted_at',null)->get();
        return view('backend.setup.academic_division.index',$s);
    }
    public function details($id): JsonResponse
    {
        $ad = AcademicDivision::where('id',$id)->where('deleted_at',null)->first();
        $ad['created_date'] = date('d M, Y', strtotime($ad->created_at));
        $ad['updated_date'] = ($ad->updated_at != $ad->created_at) ? (date('d M, Y', strtotime($ad->updated_at))) : 'N/A';
        $ad['created_user'] = $ad->created_by ? $ad->createdBy->name : 'System';
        $ad['updated_user'] = $ad->updated_by ? $ad->updatedBy->name : 'N/A';
        $s['ad'] = $ad;
        return response()->json($s);
    }
    public function create(){
        return view('backend.setup.academic_division.create');
    }

    public function store(AcademicDivisionRequest $req): RedirectResponse
    {
        $ad =new AcademicDivision();
        $ad->name = $req->name;
        $ad->created_by = auth()->user()->id;
        $ad->save();
        return redirect()->route('setup.academic_division.academic_division_list')->withStatus(__("Academic division $ad->name created successfully"));     
    }
    public function edit($id): View
    {
        $s['ad'] = AcademicDivision::findOrFail($id);
        return view('backend.setup.academic_division.edit',$s);
    }
    public function update(AcademicDivisionRequest $req, $id): RedirectResponse
    {
        $ad = AcademicDivision::findOrFail($id);
        $ad->name = $req->name;
        $ad->updated_by = auth()->user()->id;
        $ad->update();
        return redirect()->route('setup.academic_division.academic_division_list')->withStatus(__("Academic division $ad->name updated successfully"));     
    }
    public function delete($id): RedirectResponse
    {
        $ad = AcademicDivision::findOrFail($id);
        $ad->delete();
        return redirect()->route('setup.academic_division.academic_division_list')->withStatus(__('Academic division '.$ad->name.' deleted successfully.'));

    }
}
