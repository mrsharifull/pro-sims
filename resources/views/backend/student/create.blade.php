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
            <h4 class="card-title">{{__('Create Student')}}</h4>
          </div>
          <div class="col-4 text-right">
            @include('backend.partials.button', ['routeName' => 'student.student_list', 'className' => 'btn-primary', 'label' => 'Back'])
          </div>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('student.student_create')}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="form-group col-md-6">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{old('name')}}">
              @include('alerts.feedback', ['field' => 'name'])
            </div>
            <div class="form-group col-md-6">
              <label>Number</label>
              <input type="text" name="number" class="form-control" placeholder="Enter your phone number" value="{{old('number')}}">
              @include('alerts.feedback', ['field' => 'number'])
            </div>
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" accept="image/*" name="image" class="form-control">
            @include('alerts.feedback', ['field' => 'image'])
          </div>
          <div class="form-group">
            <label>Thumbnail Image</label>
            <input type="file" accept="image/*" name="thumbnail_image" class="form-control   image-upload">
          </div>


          <div class="row">
            <div class="form-group col-md-6">
              <label>Father Name</label>
              <input type="text" name="father_name" class="form-control" placeholder="Enter father name" value="{{old('father_name')}}">
              @include('alerts.feedback', ['field' => 'father_name'])
            </div>
            <div class="form-group col-md-6">
              <label>Mother Name</label>
              <input type="text" name="mother_name" class="form-control" placeholder="Enter mother name" value="{{old('mother_name')}}">
              @include('alerts.feedback', ['field' => 'mother_name'])
            </div>
            <div class="form-group col-md-6">
              <label>Class</label>
              <select name="class_id" class="form-control class">
                <option selected hidden>Select Class</option>
                @foreach($classes as $class)
                <option value="{{$class->id}}">{{$class->name}}</option>
                @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'class_id'])
            </div>
            <div class="form-group col-md-6">
              <label>Section</label>
              <select name="section_id" class="form-control section">
                <option selected hidden>Select Section</option>
              </select>
              @include('alerts.feedback', ['field' => 'section_id'])
            </div>
            <div class="form-group col-md-6">
              <label>Academic Division</label>
              <select name="ad_id" class="form-control">
                <option selected hidden>Select Academic Division</option>
                @foreach($ads as $ad)
                <option value="{{$ad->id}}">{{$ad->name}}</option>
                @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'ad_id'])
            </div>
            <div class="form-group col-md-6">
              <label>Blood Group</label>
              <select name="bg_id" class="form-control">
                <option selected hidden>Select Blood Group</option>
                @foreach($bgs as $bg)
                <option value="{{$bg->id}}">{{$bg->name}}</option>
                @endforeach
              </select>
              @include('alerts.feedback', ['field' => 'bg_id'])
            </div>

            <div class="form-group col-md-6">
              <label>Roll</label>
              <input type="text" name="roll" class="form-control" placeholder="Enter roll" value="{{old('roll')}}">
              @include('alerts.feedback', ['field' => 'roll'])
            </div>
            <div class="form-group col-md-6">
              <label>Registration</label>
              <input type="text" name="registration" class="form-control" placeholder="Enter registration" value="{{old('registration')}}">
              @include('alerts.feedback', ['field' => 'registration'])
            </div>
            <div class="form-group col-md-6">
              <label>Date</label>
              <input type="date" name="date_of_birth" class="form-control" placeholder="Enter registration" value="{{old('date_of_birth')}}">
              @include('alerts.feedback', ['field' => 'date_of_birth'])
            </div>
            <div class="form-group col-md-6">
              <label>Date</label>
              <input type="date" name="date_of_birth" class="form-control" placeholder="Enter registration" value="{{old('date_of_birth')}}">
              @include('alerts.feedback', ['field' => 'date_of_birth'])
            </div>
            <div class="form-group col-md-6">
              <label>Age</label>
              <input type="text" name="age" class="form-control" placeholder="Enter registration" value="{{old('age')}}">
              @include('alerts.feedback', ['field' => 'age'])
            </div>
            <div class="form-group col-md-6">
              <label>Gender</label>
              <select name="gender" class="form-control">
                <option selected hidden> Select Gender</option>
                <option value="male"> Male</option>
                <option value="female"> Female</option>
                <option value="other"> Other</option>
              </select>
              @include('alerts.feedback', ['field' => 'age'])
            </div>
            <div class="form-group col-md-12">
              <label>Address</label>
              <textarea name="address" class="form-control">{{old('address')}}</textarea>
              @include('alerts.feedback', ['field' => 'address'])
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection