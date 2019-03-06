@extends('staff.layout.auth')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Hover Data Table</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="section">
                        <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created_At</th>
                        <th>Updated_At</th>
                        <th>Action</th>
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
    <script>
        $('#section').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'tableData',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
    @endsection
