@extends('staff.layout.auth')
@section('headcss')
    <link rel="stylesheet" href="{!! asset('plugins/iCheck/all.css')!!}">
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">
@endsection
@section('content')
    {!! Form::open(['url' => 'staff/result','class'=>'form-horizontal','id'=>'examForm']) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Publish Result</h3>
        </div>
        <div class="box-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>{{$errors->first()}}
                </div>
            @endif
            @if($class->isEmpty())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>No Publishable result
                </div>
                @else
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Session
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                            {{ Form::selectYear('session_year',date('Y')-3, date('Y')+1,date('Y'),['class'=>'year form-control ','required'=>'']) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                        {{Form::select('class_id',$class,null,['class'=>'form-control examID required','placeholder'=>'Select Class','required'=>''])}}
                    </div>
                </div>
            </div>

            <div id="section">

            </div>
            <div id="exam">

            </div>
        </div>
        <div id="forFooter">
            <div class="box-footer">
                <button type="submit" form="examForm" id="submit" class="btn btn-primary">Generate Result</button>
            </div>
        </div>
    </div>
        @endif
    {!! Form::close() !!}
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="class_id"]').on('change', function() {
                var classId = $(this).val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'section/'+classId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#section').html(data);
                        }
                    });
                }else{
                    $('#sectionDetails').detach();
                    $('#examDetails').detach();$('#forFooter').hide();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#forFooter').hide();
            $('select[name="class_id"]').on('change', function() {
                var classId = $(this).val();
                var session = $('select[name="session_year"]').val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'exam/'+classId+'/'+session,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#exam').html(data);
                            $('#forFooter').show();
                        }
                    });
                }else{
                    $('#forFooter').hide();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="session_year"]').on('change', function() {
                var session = $(this).val();
                var classId = $('select[name="class_id"]').val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'exam/'+classId+'/'+session,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#exam').html(data);
                            $('#forFooter').show();
                        }
                    });
                }else{
                    $('#sectionDetails').detach();
                    $('#examDetails').detach();
                    $('#forFooter').hide();

                }
            });
        });
    </script>
@endsection