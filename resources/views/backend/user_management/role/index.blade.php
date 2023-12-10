@extends('layouts.app', ['pageSlug' => 'role'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <span class="alert alert-success d-block">{{session('success')}}</span>
            @endif
            @if(session('error'))
                <span class="alert alert-danger d-block">{{session('error')}}</span>
            @endif
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Role List</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('um.role.role_create')}}" class="btn btn-sm btn-primary">{{__('Add Role')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Permission</th>
                                    <th>Creation Date</th>
                                    <th>Creadted By</th>
                                    <th>Updated By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->permissionNames}}</td>
                                    <td>{{date('d M, Y', strtotime($role->created_at))}}</td>
                                    <td>{{$role->createdBy->name ?? "System Generated"}}</td>
                                    <td>{{$role->updatedBy->name ?? "System Generated"}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                                x-placement="top-end"
                                                style="position: absolute; transform: translate3d(-57px, -60px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item" href="{{route('um.role.role_edit',$role->id)}}">Update</a>
                                                <a class="dropdown-item" onclick="alert('Are you sure?')" href="{{route('um.role.role_delete',$role->id)}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
