@extends('layouts.app', ['pageSlug' => 'user'])

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
                            <h4 class="card-title">User List</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('um.user.user_create')}}" class="btn btn-sm btn-primary">{{__('Add User')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th>Creadted By</th>
                                    <th>Updated By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>
                                        <span class="badge {{$user->status == 1 ? 'badge-success' : 'badge-warning'}}">
                                            {{$user->status == 1 ? 'Active' : 'Disabled'}}
                                        </span>
                                    </td>
                                    <td>{{date('d M, Y', strtotime($user->created_at))}}</td>
                                    <td>{{$user->createdBy->name ?? "System Generated"}}</td>
                                    <td>{{$user->updatedBy->name ?? "System Generated"}}</td>
                                    <td>
                                        @include('backend.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$user->id],
                                                    'label' => 'View',
                                                    'className' => 'view',
                                                ],
                                                [
                                                    'routeName' => 'um.user.status.user_edit',
                                                    'params' => [$user->id],
                                                    'label' => $user->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' => 'um.user.user_edit',
                                                    'params' => [$user->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'um.user.user_delete',
                                                    'params' => [$user->id],
                                                    'label' => 'Delete',
                                                    'delete' => true,
                                                ],
                                            ],
                                        ])
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
