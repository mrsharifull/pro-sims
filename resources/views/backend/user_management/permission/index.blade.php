@extends('layouts.app', ['pageSlug' => 'permission'])

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
                            <h4 class="card-title">Permission List</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('export.permissions')}}" class="btn btn-sm btn-primary">{{__('Expoert Permissions')}}</a>
                            <a href="{{route('um.permission.permission_create')}}" class="btn btn-sm btn-primary">{{__('Add Permission')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Prefix</th>
                                    <th>Permisson</th>
                                    <th>Creation Date</th>
                                    <th>Creadted By</th>
                                    <th>Updated By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key=>$permission)
                                <tr>
                                    <td>{{$permission->prefix}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{date('d M, Y', strtotime($permission->created_at))}}</td>
                                    <td>{{$permission->createdBy->name ?? "System Generated"}}</td>
                                    <td>{{$permission->updatedBy->name ?? "System Generated"}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                                x-placement="top-end"
                                                style="position: absolute; transform: translate3d(-57px, -60px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item" href="{{route('um.permission.permission_edit',$permission->id)}}">Update</a>
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
