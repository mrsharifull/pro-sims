@extends('backend.layouts.master', ['pageSlug' => 'class'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Create Class')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partials.button', ['routeName' => 'setup.class.class_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('setup.class.class_create')}}">
                    @csrf
                    <div class="form-group">
                      <label>{{_('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter class name" value="{{old('name')}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>{{_('Number')}}</label>
                      <input type="numaric" name="number" class="form-control" placeholder="Enter class number" value="{{old('number')}}">
                      @include('alerts.feedback', ['field' => 'number'])
                    </div>

                    <button type="submit" class="btn btn-primary">{{_('Create')}}</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
