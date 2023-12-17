@extends('layouts.app', ['pageSlug' => 'role'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Edit Role')}}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('um.role.role_list')}}" class="btn btn-sm btn-primary">{{__('Back')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  <form  method="POST" action="{{route('um.role.role_edit',$role->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter role name" value="{{$role->name}}">
                      @error('name')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>

                    <div class="row">
                      @foreach ($groupedPermissions->chunk(2) as $chunks)
                          <div class="col-md-6">
                              @foreach ($chunks as $prefix => $permissions)
                              <h3>
                                  <input type="checkbox" class="prefix-checkbox" id="prefix-checkbox-{{ $prefix }}" data-prefix="{{ $prefix }}">
                                  <label for="prefix-checkbox-{{ $prefix }}">{{ $prefix }}</label>
                              </h3>
                              <ul>
                                  @foreach($permissions as $permission)
                                      <li style="list-style: none">
                                          <input type="checkbox" name="permissions[]" id="permission-checkbox-{{ $permission->id }}" value="{{ $permission->id }}" @if($role->hasPermissionTo($permission->name)) @checked(true) @endif class="permission-checkbox">
                                          <label for="permission-checkbox-{{ $permission->id }}">{{ $permission->name }}</label>
                                      </li>
                                  @endforeach
                              </ul>
                              @endforeach
                          </div>
                      @endforeach
                  </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.prefix-checkbox').on('click', function() {
            var prefix = $(this).data('prefix');
            var permissionCheckboxes = $(this).closest('h3').next('ul').find('.permission-checkbox');
            var isChecked = $(this).prop('checked');

            permissionCheckboxes.prop('checked', isChecked);
        });

        $('.permission-checkbox').on('click', function() {
            var checkboxId = $(this).attr('id');
            var prefix = $(this).closest('ul').prev('h3').find('.prefix-checkbox');
            var permissionCheckboxes = $(this).closest('ul').find('.permission-checkbox');
            var isAllChecked = permissionCheckboxes.length === permissionCheckboxes.filter(':checked').length;

            prefix.prop('checked', isAllChecked);
        });

        // Handle click event on text elements
        $('label[for^="permission-checkbox-"]').on('click', function() {
            var checkboxId = $(this).attr('for');
            $('#' + checkboxId).prop('checked'); // Trigger the associated checkbox click event
        });
        $('label[for^="permission-checkbox-"]').on('click', function() {
            var checkboxId = $(this).attr('for');
            $('#' + checkboxId).prop('checked'); // Trigger the associated checkbox click event
        });
    });
</script>
@endpush
