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
        {!! Form::model($attendance, [
                  'route' => ['attendance.update', $attendance->id],
                  'class' =>"form-horizontal form-label-left",
                  'method' => 'PUT',
                  'id' => 'attendanceForm',
                  'enctype' => "multipart/form-data",
              ])
              !!}
        <div class="box-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>{{$errors->first()}}
                </div>
            @endif
            <label for="attendance_date" class="control-label col-md-2 col-sm-2 col-sm-2">Attendance Date</label>
            {{Form::date('attendance_date',$attendance->date,['min'=>"2015-01-01", "max"=>date('Y-m-d'),'style'=>'margin-bottom:5px'])}}
            <div>
                <p>Attendance Type:</p>
                @if($attendance->exam_id!=null)
                    <div class="col-md-4 col-sm-4 col-sm-6">
                        <label for="type" class="control-label" style="margin-right: 5px;">Regular</label><input type="radio"  name="typeExam" value="regular"  onclick="regular()">
                    </div>
                    <div class="col-md-4 col-sm-4 col-sm-6">
                        <label for="typeExam" class="control-label" style="margin-right: 5px;">Exam</label><input type="radio"  name="typeExam" value="exam"  onclick="examThis()" checked>
                    </div>
                @else
                    <div class="col-md-4 col-sm-4 col-sm-6">
                        <label for="type" class="control-label" style="margin-right: 5px;">Regular</label><input type="radio"  name="typeExam" value="regular" onclick="regular()" checked>
                    </div>
                    <div class="col-md-4 col-sm-4 col-sm-6">
                        <label for="typeExam" class="control-label" style="margin-right: 5px;">Exam</label><input type="radio"  name="typeExam" value="exam" onclick="examThis()">
                    </div>
                @endif

            </div>
            <div id="examGet" class="col-md-5 col-sm-5 col-sm-6">
                <label for="type" class="control-label" style="margin-right: 5px;">Exam</label>
                <select class="form-control examID" name="exam">
                    @php $i=0;@endphp
                    @foreach($arrayExam as $get)
                        @if($i==0)
                            <option value="">Select Exam</option>
                        @else

                            @if($attendance->exam_id!=null)
                                @if($attendance->exam_id==$get->id)
                                    <option value="{{$get->id}}" selected>{{$get->name}}</option>
                                @else
                                    <option value="{{$get->id}}">{{$get->name}}</option>
                                @endif

                            @else
                                <option value="{{$get->id}}">{{$get->name}}</option>

                            @endif
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
                    <label for="type" class="control-label" style="margin-right: 5px;">If all students present mark this:</label>
                    @if($all)
                        <input type="checkbox"  name="present" value="all" id="type" checked="checked">

                    @else
                        <input type="checkbox"  name="present" value="all" id="type">

                    @endif
                </div>
                <div id="student">
                    <br>
                    <hr>
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <p>Students:</p>
                        @php $j=0; @endphp
                        @foreach($arrayStudent as $getStudent)
                            {{--                            {{dd($arrayStudent)}}--}}
                            @if($j!=0)
                                @php $check=0;@endphp
                                @php $k=0; @endphp
                                @foreach($present as $getstatus)
                                    {{--{{dd($getstatus)}}--}}
                                    @if($k!=0)
                                        @if($getStudent->id==$getstatus->student_id)

                                            @if($getstatus->present==1)
                                                @php $check=$check+1;@endphp
                                                <div class="col-md-4 col-sm-4 col-sm-6">
                                                    <label for="type" class="control-label" style="margin-right: 5px;">ID: {{$getStudent->id}} Name: {{$getStudent->firstName}} @if($getStudent->middleName){{$getStudent->middleName}}@endif {{$getStudent->LastName}}</label><input type="checkbox" class="flat-red" name="student{{$getStudent->id}}" value="{{$getStudent->id}}" id="type" checked>
                                                </div>
                                            @else
                                                @php $check=$check+1;@endphp
                                                <div class="col-md-4 col-sm-4 col-sm-6">
                                                    <label for="type" class="control-label" style="margin-right: 5px;">ID: {{$getStudent->id}} Name: {{$getStudent->firstName}} @if($getStudent->middleName){{$getStudent->middleName}}@endif {{$getStudent->LastName}}</label><input type="checkbox" class="flat-red" name="student{{$getStudent->id}}" value="{{$getStudent->id}}" id="type">
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    @php $k=$k+1;@endphp
                                @endforeach
                                @if($check==0)
                                    <div class="col-md-4 col-sm-4 col-sm-6">
                                        <label for="type" class="control-label" style="margin-right: 5px;">ID: {{$getStudent->id}} Name: {{$getStudent->firstName}} @if($getStudent->middleName){{$getStudent->middleName}}@endif {{$getStudent->LastName}}</label><input type="checkbox" class="flat-red" name="student{{$getStudent->id}}" value="{{$getStudent->id}}" id="type">
                                    </div>
                                @endif
                            @endif
                            @php $j=$j+1;@endphp
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" form="attendanceForm" class="btn btn-primary">Submit</button>
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
            if ($('input[name=typeExam]').is(":checked")) {
                var value=$('input[name=typeExam]:checked').val();
                if(value=='regular'){
                    $("#examGet").hide();
                    $("#examGet :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $("#regular").show();
                    $("#regular :input").attr('disabled', false);//to add required property of shown divs

                }
                if(value=='exam'){
                    $("#examGet").show();
                    $("#examGet :input").prop('required', true).attr('disabled', false);//to add required property of shown divs
                    $("#regular").show();
                    $("#regular :input").attr('disabled', false);//to add required property of shown divs

                }
            }
            if ($("#type").is(":checked")) {
                $("#student").hide();
                $("#student :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
            }
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