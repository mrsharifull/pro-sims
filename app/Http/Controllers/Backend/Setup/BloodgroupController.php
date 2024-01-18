<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\BloodgroupsRequest;
use App\Models\Bloodgroups;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BloodgroupController extends Controller
{
    
    public function index(){
        $s['bloodgroups'] = Bloodgroups::where('deleted_at',null)->get();
        return view('backend.setup.bloodgroup.index',$s);
    }
    public function details($id): JsonResponse
    {
        $bloodgroup = Bloodgroups::where('id',$id)->where('deleted_at',null)->first();
        $bloodgroup['created_date'] = date('d M, Y', strtotime($bloodgroup->created_at));
        $bloodgroup['updated_date'] = ($bloodgroup->updated_at != $bloodgroup->created_at) ? (date('d M, Y', strtotime($bloodgroup->updated_at))) : 'N/A';
        $bloodgroup['created_user'] = $bloodgroup->created_by ? $bloodgroup->createdBy->name : 'System';
        $bloodgroup['updated_user'] = $bloodgroup->updated_by ? $bloodgroup->updatedBy->name : 'N/A';
        $s['bloodgroup'] = $bloodgroup;
        return response()->json($s);
    }
    public function create(){
        return view('backend.setup.bloodgroup.create');
    }

    public function store(BloodgroupsRequest $req): RedirectResponse
    {
        $bloodgroup =new Bloodgroups();
        $bloodgroup->name = $req->name;
        $bloodgroup->created_by = auth()->user()->id;
        $bloodgroup->save();
        return redirect()->route('setup.bloodgroup.bloodgroup_list')->withStatus(__("Bloodgroup $bloodgroup->name created successfully"));     
    }
    public function edit($id): View
    {
        $s['bloodgroup'] = Bloodgroups::findOrFail($id);
        return view('backend.setup.bloodgroup.edit',$s);
    }
    public function update(BloodgroupsRequest $req, $id): RedirectResponse
    {
        $bloodgroup = Bloodgroups::findOrFail($id);
        $bloodgroup->name = $req->name;
        $bloodgroup->updated_by = auth()->user()->id;
        $bloodgroup->update();
        return redirect()->route('setup.bloodgroup.bloodgroup_list')->withStatus(__("Bloodgroup $bloodgroup->name updated successfully"));     
    }
    public function delete($id): RedirectResponse
    {
        $bloodgroup = Bloodgroups::findOrFail($id);
        $bloodgroup->delete();
        return redirect()->route('setup.bloodgroup.bloodgroup_list')->withStatus(__('Bloodgroup '.$bloodgroup->name.' deleted successfully.'));

    }
}

