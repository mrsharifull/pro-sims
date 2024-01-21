@extends('backend.layouts.master', ['pageSlug' => 'student'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Student List</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('backend.partials.button', [
                                'routeName' => 'student.student_create',
                                'className' => 'btn-primary',
                                'label' => 'Add Student',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="">
                        <table class="table tablesorter datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>{{ _('Name') }}</th>
                                    <th>{{ _('Image') }}</th>
                                    <th>{{ _('Class') }}</th>
                                    <th>{{ _('Section') }}</th>
                                    <th>{{ _('Division') }}</th>
                                    <th>{{ _('Roll') }}</th>
                                    <th>{{ _('Phone') }}</th>
                                    <th>{{ _('Status') }}</th>
                                    <th>{{ _('Creation date') }}</th>
                                    <th>{{ _('Created by') }}</th>
                                    <th>{{ _('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td> {{ $student->name }} </td>
                                        <td> 
                                            <img height="50px" width="50px" src="{{storage_url($student->image)}}" alt="">
                                        </td>
                                        <td> {{ $student->class->name }} </td>
                                        <td> {{ $student->section->name }} </td>
                                        <td> {{ $student->ad->name }} </td>
                                        <td> {{ $student->roll }} </td>
                                        <td> {{ $student->number }} </td>

                                        <td>
                                            <span
                                                class="badge {{ $student->status == 1 ? 'badge-success' : 'badge-warning' }}">{{ $student->status == 1 ? 'Active' : 'Disabled' }}</span>
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($student->created_at)) }}</td>

                                        <td> {{ $student->createdBy->name ?? 'system' }} </td>
                                        <td>
                                            @include('backend.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'javascript:void(0)',
                                                        'params' => [$student->id],
                                                        'label' => 'View',
                                                        'className' => 'view',
                                                    ],
                                                    [
                                                        'routeName' => 'student.status.student_edit',
                                                        'params' => [$student->id],
                                                        'label' => $student->getBtnStatus(),
                                                    ],
                                                    [
                                                        'routeName' => 'student.student_edit',
                                                        'params' => [$student->id],
                                                        'label' => 'Update',
                                                    ],
                                                    [
                                                        'routeName' => 'student.student_delete',
                                                        'params' => [$student->id],
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

    {{-- User Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _('Student Details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

      
@endsection
@include('backend.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = ("{{ route('student.details.student_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.student.status = 1 ? 'Active' : 'Deactive';
                        let statusClass = data.student.status = 1 ? 'badge-success' :
                            'badge-warning';
                        var result = `
                                <table class="table tablesorter">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.student.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Email</th>
                                        <th>:</th>
                                        <td>${data.user.email}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Role</th>
                                        <th>:</th>
                                        <td>${data.user.role.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.user.created_user}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.user.updated_user}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.user.created_date}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
                                        <th>:</th>
                                        <td>${data.user.updated_date}</td>
                                    </tr>
                                </table>
                                `;
                        $('.modal_data').html(result);
                        $('.view_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching student data:', error);
                    }
                });
            });
        });
    </script>
@endpush
