@extends('backend.layouts.master', ['pageSlug' => 'class'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit Class')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partials.button', ['routeName' => 'setup.class.class_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('setup.class.class_edit',$class->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{_('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter class name" value="{{$class->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                      <label>{{_('Number')}}</label>
                      <input type="numaric" name="number" class="form-control" placeholder="Enter class number" value="{{$class->number}}">
                      @include('alerts.feedback', ['field' => 'number'])
                    </div>

                    <button type="submit" class="btn btn-primary">{{_('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
