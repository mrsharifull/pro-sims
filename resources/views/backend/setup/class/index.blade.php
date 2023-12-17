@extends('backend.layouts.master', ['pageSlug' => 'class'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="card-title">{{_('Class List')}}</h4>
                        </div>
                        <div class="col-md-5 text-right">
                            @include('backend.partials.button', ['routeName' => 'setup.class.class_create', 'className' => 'btn-primary', 'label' => 'Add Class'])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="">
                        <table class="table tablesorter datatable">
                            <thead class=" text-primary">
                                <tr>
                                    <th>{{_('Name')}}</th>
                                    <th>{{_('Number')}}</th>
                                    <th>{{_('Creation Date')}}</th>
                                    <th>{{_('Creadted By')}}</th>
                                    <th class="text-center">{{_('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $key=>$class)
                                <tr>
                                    <td>{{$class->name}}</td>
                                    <td class="text-center">{{$class->number}}</td>
                                    <td>{{date('d M, Y', strtotime($class->created_at))}}</td>
                                    <td>{{$class->createdBy->name ?? "System Generated"}}</td>
                                    <td>
                                        @include('backend.partials.action_buttons', [
                                                'menuItems' => [
                                                    [
                                                        'routeName' => 'javascript:void(0)',
                                                        'params' => [$class->id],
                                                        'label' => 'View',
                                                        'className' => 'view',
                                                    ],
                                                    [
                                                        'routeName' => 'setup.class.class_edit',
                                                        'params' => [$class->id],
                                                        'label' => 'Update',
                                                    ],
                                                    [
                                                        'routeName' => 'setup.class.class_delete',
                                                        'params' => [$class->id],
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
@include('backend.partials.datatable', ['columns_to_show' => [0,1,2]])

{{-- class Details Modal  --}}
<div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ _('Class Details') }}</h5>
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
@push('js')
<script>
$(document).ready(function() {
    $('.view').on('click', function() {
        let id = $(this).data('id');
        let url = ("{{ route('setup.class.details.class_list', ['id']) }}");
        let _url = url.replace('id', id);
        $.ajax({
            url: _url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var result = `
                        <table class="table tablesorter">
                            <tr>
                                <th class="text-nowrap">Name</th>
                                <th>:</th>
                                <td>${data.class.name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Number</th>
                                <th>:</th>
                                <td>${data.class.number}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created By</th>
                                <th>:</th>
                                <td>${data.class.created_user}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated By</th>
                                <th>:</th>
                                <td>${data.class.updated_user}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created At</th>
                                <th>:</th>
                                <td>${data.class.created_date}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated At</th>
                                <th>:</th>
                                <td>${data.class.updated_date}</td>
                            </tr>
                        </table>
                        `;
                $('.modal_data').html(result);
                $('.view_modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
            }
        });
    });
});
</script>
@endpush
