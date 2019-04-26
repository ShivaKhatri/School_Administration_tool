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
                    {!! $dataTable->table() !!}

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- from dataTables push-->
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
{{--    <script src="{!! asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')!!}"></script>--}}
    <script src="{{asset('vendor/datatables/buttons.server-side.js')}}"></script>
    {!! $dataTable->scripts() !!}
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
                window.location.replace('/staff/student');
            });
        });
    </script>
@endsection
