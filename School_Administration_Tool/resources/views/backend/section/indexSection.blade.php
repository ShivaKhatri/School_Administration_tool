@extends('staff.layout.auth')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box row" style="overflow:hidden; word-wrap:break-word">
                <div class="box-header row">
                    <h3 class="box-title col-md-6 col-sm-6 col-xs-12">Hover Data Table</h3>
                    <span class="col-md-5 col-sm-5 col-xs-5"></span>
                    <div class="col-md-1 col-sm-1 col-xs-1" >
                        <a href="{{route('section.create')}}" class="btn btn-sm btn-primary" style="margin:3px"><i
                                    class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add</a>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body" style="overflow:hidden; word-wrap:break-word" >
                    {!! $dataTable->table([], true) !!}
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
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">--}}
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('vendor/datatables/buttons.server-side.js')}}"></script>
    {!! $dataTable->scripts() !!}
    @endsection
