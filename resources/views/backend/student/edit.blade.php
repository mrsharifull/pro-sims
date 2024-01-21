@extends('backend.layouts.master', ['pageSlug' => 'student'])

@push('css')
  <style>
      .form-group input[type=file] {
        opacity: 1 !important;
        position: unset !important;
      }
  </style>
@endpush

@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-8">
            <h4 class="card-title">{{__('Edit Student')}}</h4>
          </div>
          <div class="col-4 text-right">
            @include('backend.partials.button', ['routeName' => 'student.student_list', 'className' => 'btn-primary', 'label' => 'Back'])
          </div>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('student.student_edit',$student->id)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="form-group col-md-6">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$student->name}}">
              @include('alerts.feedback', ['field' => 'name'])
            </div>
            <div class="form-group col-md-6">
              <label>Number</label>
              <input type="text" name="number" class="form-control" placeholder="Enter your phone number" value="{{$student->number}}">
              @include('alerts.feedback', ['field' => 'number'])
            </div>
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" accept="image/*" name="image" class="form-control">
            @include('alerts.feedback', ['field' => 'image'])
            @if(!empty($student->image))
            <img height="100px" width="100px" src="{{storage_url($student->image)}}" alt="{{$student->name}}">
            @endif
          </div>


          <div class="row">
            <div class="form-group col-md-6">
              <label>Father Name</label>
              <input type="text" name="father_name" class="form-control" placeholder="Enter father name" value="{{$student->father_name}}">
              @include('alerts.feedback', ['field' => 'father_name'])
            </div>
            <div class="form-group col-md-6">
              <label>Mother Name</label>
              <input type="text" name="mother_name" class="form-control" placeholder="Enter mother name" value="{{$student->mother_name}}">
              @include('alerts.feedback', ['field' => 'mother_name'])
            </div>
            <div class="form-group col-md-6">
              <label>Class</label>
              <select name="class_id" class="form-control class">
                @foreach($classes as $class)
                <option value="{{$class->id}}" {{($student->class_id == $class->id) ? 'selected' : ''}}>{{$class->name}}</option>
                @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'class_id'])
            </div>
            <div class="form-group col-md-6">
              <label>Section</label>
              <select name="section_id" class="form-control section">
                  @foreach($sections as $section)
                    <option value="{{$section->id}}" {{($student->section_id == $section->id) ? 'selected' : ''}}>{{$section->name}}</option>
                  @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'section_id'])
            </div>
            <div class="form-group col-md-6">
              <label>Academic Division</label>
              <select name="ad_id" class="form-control">
                @foreach($ads as $ad)
                <option value="{{$ad->id}}" {{($student->ad_id == $ad->id) ? 'selected' : ''}}>{{$ad->name}}</option>
                @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'ad_id'])
            </div>
            <div class="form-group col-md-6">
              <label>Blood Group</label>
              <select name="bg_id" class="form-control">
                @foreach($bgs as $bg)
                <option value="{{$bg->id}}" {{($student->bg_id == $bg->id) ? 'selected' : ''}}>{{$bg->name}}</option>
                @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'bg_id'])
            </div>

            <div class="form-group col-md-6">
              <label>Roll</label>
              <input type="text" name="roll" class="form-control" placeholder="Enter roll" value="{{$student->roll}}">
              @include('alerts.feedback', ['field' => 'roll'])
            </div>
            <div class="form-group col-md-6">
              <label>Registration</label>
              <input type="text" name="registration" class="form-control" placeholder="Enter registration" value="{{$student->registration}}">
              @include('alerts.feedback', ['field' => 'registration'])
            </div>
            <div class="form-group col-md-6">
              <label>Birthdate</label>
              <input type="date" name="date_of_birth" class="form-control" placeholder="Enter registration" value="{{$student->date_of_birth}}">
              @include('alerts.feedback', ['field' => 'date_of_birth'])
            </div>
            <div class="form-group col-md-6">
              <label>Age</label>
              <input type="text" name="age" class="form-control" placeholder="Enter registration" value="{{$student->age}}">
              @include('alerts.feedback', ['field' => 'age'])
            </div>
            <div class="form-group col-md-6">
              <label>Gender</label>
              <select name="gender" class="form-control">
                <option selected hidden> Select Gender</option>
                <option value="male" {{($student->gender == 'male') ? 'selected' : ''}}> Male</option>
                <option value="female" {{($student->gender == 'female') ? 'selected' : ''}}> Female</option>
                <option value="other" {{($student->gender == 'other') ? 'selected' : ''}}> Other</option>
              </select>
              @include('alerts.feedback', ['field' => 'gender'])
            </div>
            <div class="form-group col-md-6">
              <label>Parents Number</label>
              <input type="text" name="parents_number" class="form-control" placeholder="Enter parents phone number" value="{{$student->parents_number}}">
              @include('alerts.feedback', ['field' => 'parents_number'])
            </div>
            <div class="form-group col-md-12">
              <label>Address</label>
              <textarea name="address" class="form-control">{{$student->address}}</textarea>
              @include('alerts.feedback', ['field' => 'address'])
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')

<script>

$(document).ready(function() {
    $('.class').on('change', function(){
      $('.section').prop('disabled',true);
      if($(this).val() !== ''){
        var id = $(this).val();
        let _url = ("{{ route('student.class.section.student_create', ['class_id']) }}");
        let __url = _url.replace('class_id', id);
            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    var result = '<option selected hidden>Select Section</option>';

                    data.sections.forEach(function(section) {
                      result +=`
                              <option value='${section.id}'>${section.name}</option>
                      `;
                    });
                    $('.section').html(result);
                    $('.section').prop('disabled',false);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching member data:', error);
                }
            });
      }
    });
});

      
</script>



@endpush