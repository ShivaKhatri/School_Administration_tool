@extends('staff.layout.auth')
@section('headcss')
    <style>
        input[type='checkbox'] {
            /*for height of checkbox*/
            height:21px;
            /*for width of checkbox*/
            width:21px;
        }

    </style>
@endsection
@section('headScripts')
    <link rel="stylesheet" href="{!! asset('plugins/iCheck/all.css')!!}">
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Take Attendance</h3>
        </div>
        {!! Form::open(['url' => 'staff/attendance','class'=>'form-horizontal','id'=>'createClass']) !!}
        <div class="box-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>{{$errors->first()}}
                </div>
            @endif
                <label for="attendance_date" class="control-label col-md-2 col-sm-2 col-sm-2">Attendance Date</label>
                {{Form::date('attendance_date',date('Y-m-d'),['min'=>"2015-01-01", "max"=>date('Y-m-d'),'style'=>'margin-bottom:10px'])}}
            <div>
                <p>Attendance Type:</p>
                <div class="col-md-4 col-sm-4 col-sm-6">
                    <label for="type" class="control-label" style="margin-right: 10px;">Regular</label><input type="radio"  name="typeExam" value="regular" onclick="regular()" required>
                </div>
                <div class="col-md-4 col-sm-4 col-sm-6">
                    <label for="typeExam" class="control-label" style="margin-right: 10px;">Exam</label><input type="radio"  name="typeExam" value="exam" onclick="examThis()" required>
                </div>
            </div>
            <div id="examGet" class="col-md-5 col-sm-5 col-sm-6">
                <label for="type" class="control-label" style="margin-right: 10px;">Exam</label>
                <select class="form-control examID" name="exam" required>
                    @php $i=0;@endphp
                    @foreach($arrayExam as $get)
                        @if($i==0)
                            <option value="">Select Exam</option>
                        @else
                            <option value="{{$get->id}}">{{$get->name}}</option>
                        @endif
                            @php $i=$i+1;@endphp

                        @endforeach
                </select>
            </div>
                <div id="subjects">

                </div>
            <div id="regular" class="col-md-12 col-sm-12 col-xs-12 ">
                <br>
                <hr>
                <div>
                    <label for="type" class="control-label" style="margin-right: 10px;">If all students present mark this:</label>
                    <input type="checkbox"  name="present" value="all" id="type">
                </div>
                <div id="student">
                    <br>
                    <hr>
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <p>Students:</p>
                        @php $j=0;@endphp
                        @foreach($arrayStudent as $getStudent)
                            @if($j!=0)
                                <div class="col-md-4 col-sm-4 col-sm-6">
                                    <label for="type" class="control-label" style="margin-right: 10px;">ID: {{$getStudent->id}} Name: {{$getStudent->firstName}} @if($getStudent->middleName){{$getStudent->middleName}}@endif {{$getStudent->LastName}}</label><input type="checkbox" class="flat-red" name="student{{$getStudent->id}}" value="{{$getStudent->id}}" id="type">
                                </div>
                            @endif
                                @php $j=$j+1;@endphp
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" form="createClass" class="btn btn-primary">Submit</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('scripts')
    <script src="{!! asset('plugins/iCheck/icheck.min.js')!!}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')!!}"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
        })
    </script>
    <script>
        $(function () {
            $('input[type="checkbox"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
            })
        });
    </script>
    <script type="text/javascript">
        $(document).on('change', '.examID', function(){
            var categoryId = $(this).val();

            console.log(categoryId);
            if (categoryId!='') {
                $.ajax({
                    url: 'subject/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#subjects').html(data);
                        $("#attendanceGet :input").prop('required', true);
                        // $('#attendanceGet :input').each(function() {
                        //     $(this).rules('add', {
                        //         'required': true
                        //     });
                        // });


                    }

                });
            }
            else{
                $("#attendanceGet").detach();

            }
        });

    </script>
    <script>

        $(document).ready(function () {
            $("#examGet").hide();
            $("#examGet :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
            $("#regular").hide();
            $("#regular :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
            $("#type").click(function () {
                if ($(this).is(":checked")) {

                    $("#student").hide();
                    $("#student :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs

                 }
                else{
                    $("#student").show();
                    $("#student :input").attr('disabled', false);//to add required property of shown divs

                }
            });
        });

        function regular() {
            $("#regular").show();
            $("#regular :input").attr('disabled', false);//to add required property of shown divs
            $("#examGet").hide();
            $("#examGet :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs

        }
        function examThis() {
            $("#examGet").show();
            $("#examGet :input").prop('required', true).attr('disabled', false);//to add required property of shown divs
            $("#regular").show();
            $("#regular :input").attr('disabled', false);//to add required property of shown divs

        }

    </script>

@endsection