@extends('layouts.app', ['pageSlug' => 'permission'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Create Permission')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('um.permission.permission_list')}}" class="btn btn-sm btn-primary">{{__('Back')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('um.permission.permission_create')}}">
                    @csrf
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter permission name" value="{{old('name')}}">
                      @error('name')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Prefix</label>
                      <input type="text" name="prefix" class="form-control" placeholder="Enter permission prefix" value="{{old('prefix')}}">
                      @error('prefix')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
