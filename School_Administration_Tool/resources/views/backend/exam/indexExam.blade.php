@extends('staff.layout.auth')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box row" style="overflow:hidden; word-wrap:break-word">
            <div class="box-header row">
                <h3 class="box-title col-md-6 col-sm-6 col-xs-12">Exam Details</h3>
                <span class="col-md-5 col-sm-5 col-xs-5"></span>
                <div class="col-md-1 col-sm-1 col-xs-1" >
                    <a href="{{route('exam.create')}}" class="btn btn-sm btn-primary" style="margin:3px"><i
                                class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add</a>
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <table id="examTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Session</th>
                        <th>Description</th>
                        <th>Exam start</th>
                        <th>Exam end</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script src="{!! asset('bower_components/datatables.net/js/jquery.dataTables.min.js')!!}"></script>
    <script src="{!! asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')!!}"></script>

    <script>
        $('#examTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'examTableData',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'class', name: 'class'},
                {data: 'subject', name: 'subject'},
                {data: 'session_year', name: 'session_year'},
                {data: 'description', name: 'description'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '#delete', function(e) {
            e.preventDefault(); // does not go through with the link.

            var $this = $(this);

            $.post({
                type: "DELETE",
                url: $this.attr('href')
            }).done(function (data) {
                window.location.replace('/staff/exam');
            });
        });
    </script>
@endsection
