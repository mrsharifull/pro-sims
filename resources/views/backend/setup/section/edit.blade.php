@extends('backend.layouts.master', ['pageSlug' => 'section'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit Section')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partials.button', ['routeName' => 'setup.section.section_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('setup.section.section_edit',$section->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{_('Class')}}</label>
                      <select name="class_id" class="form-control">
                          @foreach ($classes as $class)
                            <option value="{{$class->id}}" {{($class->id == $section->class_id) ? 'selected' : ''}}>{{$class->name}}</option>
                          @endforeach
                      </select>
                      @include('alerts.feedback', ['field' => 'class_id'])
                    </div>
                    <div class="form-group">
                      <label>{{_('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter class name" value="{{$section->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <button type="submit" class="btn btn-primary">{{_('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection