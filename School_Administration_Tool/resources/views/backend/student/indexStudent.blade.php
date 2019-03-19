@extends('staff.layout.auth')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box row" style="overflow:hidden; word-wrap:break-word">
                <div class="box-header row">
                    <h3 class="box-title col-md-6 col-sm-6 col-xs-12">Student Details</h3>
                    <span class="col-md-5 col-sm-5 col-xs-5"></span>
                    <div class="col-md-1 col-sm-1 col-xs-1" >
                        <a href="{{route('student.create')}}" class="btn btn-sm btn-primary" style="margin:3px"><i
                                    class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add</a>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <table id="guardianTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
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
        $('#guardianTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'studentTableData',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection
