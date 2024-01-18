@extends('backend.layouts.master', ['pageSlug' => 'bloodgroup'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit Bloodgroup')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partials.button', ['routeName' => 'setup.bloodgroup.bloodgroup_list', 'className' => 'btn-primary', 'label' => 'Back'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('setup.bloodgroup.bloodgroup_edit',$bloodgroup->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label>{{_('Name')}}</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter academic division name" value="{{$bloodgroup->name}}">
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>

                    <button type="submit" class="btn btn-primary">{{_('Update')}}</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection
