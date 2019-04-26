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
    <link rel="stylesheet" href="{!! asset('plugins/iCheck/all.css')!!}">
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        {!! Form::open(['url' => 'staff/staff','class'=>'form-horizontal','id'=>'staffForm','files'=>'true']) !!}

                        {{ csrf_field() }}

                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('firstName') ? ' has-error' : '' }}">
                            <label class="control-label"> First Name
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">

                                {!! Form::text('firstName', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                            'placeholder'=> 'Enter First Name'))!!}

                                @if ($errors->has('firstName'))
                                    <span class="help-block"> <strong>{{ $errors->first('firstName') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('middleName') ? ' has-error' : '' }}">
                            <label class="control-label"> Middle Name
                                </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">

                                {!! Form::text('middleName', null, array('class' => 'form-control','maxlength'=>10,
                            'placeholder'=> 'Enter Middle Name'))!!}

                                @if ($errors->has('middleName'))
                                    <span class="help-block"> <strong>{{ $errors->first('middleName') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('lastName') ? ' has-error' : '' }}">
                            <label class="control-label">  Last Name
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">

                                {!! Form::text('lastName', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                            'placeholder'=> 'Enter Last Name'))!!}

                                @if ($errors->has('lastName'))
                                    <span class="help-block"> <strong>{{ $errors->first('lastName') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                            <label class="control-label"> Mobile
                                No.
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {{Form::number('mobile_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
                                @if ($errors->has('mobile_no'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('mobile_no') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('phone_no') ? ' has-error' : '' }}">
                            <label class="control-label"> Phone
                                No.
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {{Form::number('phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Office Number"))}}
                                @if ($errors->has('phone_no'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('phone_no') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label class="control-label"> Date of Birth
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {!! Form::date('dob', null, array('class' => 'form-control', "placeholder" => 'Enter Date of Birth',
                                                                 'required' => '', 'id'=>'dob','min'=>"1940-01-01", "max"=>"2010-01-01")) !!}
                                @if ($errors->has('dob'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('address') ? ' has-error' : '' }} ">
                            <label class="control-label"> Address
                                <span class="required">*</span>
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {{Form::text('address', null, array('class' => 'form-control', 'placeholder'=>"Enter Address",
                                'required' => ''))}}
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group{{ $errors->has('profilePic') ? ' has-error' : '' }}">
                            <label class="control-label"> Profile picture
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {{Form::file('profilePic', ['class'=>'form-control', 'id' => 'profilePic']) }}
                                @if ($errors->has('profilePic'))
                                    <span class="help-block">
                                   <strong>{{ $errors->first('profilePic') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                            <label class="control-label">Role
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">

                                {!! Form::select('role', ['Admin'=>'Administrator','Teacher'=>'Teacher','ClassTeacher'=>'Class Teacher','Accountant'=>'Accountant'], null, array('class' => 'role form-control', 'required' => '',
                            'placeholder'=> 'Select Role'))!!}

                                @if ($errors->has('role'))
                                    <span class="help-block"> <strong>{{ $errors->first('role') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label class="control-label">Gender
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">

                                {!! Form::select('gender', ['M'=>'Male','F'=>'Female','O'=>'Other'], null, array('class' => 'form-control', 'required' => '',
                            'placeholder'=> 'Select Gender'))!!}

                                @if ($errors->has('gender'))
                                    <span class="help-block"> <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('remark') ? ' has-error' : '' }}">
                            <label class="control-label"> Remark
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {{Form::text('remark', null, array('class' => 'form-control', 'placeholder'=> 'Staff Description (Optional)'))}}
                                @if ($errors->has('remark'))
                                    <span class="help-block">
                                 <strong>{{ $errors->first('remark') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label"> Email Address
                                <span class="required">*</span>
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                {{Form::email('email', null, array('class' => 'form-control', 'placeholder'=>"Enter email address",
                                'required' => ''))}}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label"> New Password
                                <span class="required">*</span>
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                <input id="password" type="password" class="form-control" name="password" required="">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="control-label"> Confirm Password
                                <span class="required">*</span>
                            </label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required="">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">
                                        <strong id="message"></strong>
                                </span>
                            </div>
                        </div>





                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>{{$errors->first()}}
                            </div>
                        @endif
                        <div id="roleItem">

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" form="staffForm" id="submit" class="btn btn-primary">Register</button>

                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{!! asset('plugins/iCheck/icheck.min.js')!!}"></script>

    <script>
        $('#password, #password_confirmation').on('keyup', function () {
            if ($('#password').val() === $('#password_confirmation').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });
    </script>
    <script type="text/javascript">
        $(document).on('change', '.role', function(){
            var roleName = $(this).val();

            console.log(roleName);
            if (roleName=='Teacher'||roleName=='ClassTeacher') {
                $.ajax({
                    url: 'role/' + roleName,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        $('#roleItem').html(data);


                    }

                });
            }
            else{
                $('#roleTeacher').detach();

            }
        });

    </script>
    <script>
        $(function () {
            $('input[type="checkbox"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
            })
        });
    </script>
    <script type="text/javascript">
        $(document).on('change', '.classRoom', function(){
                var classId = $(this).val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'ajax/'+classId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {


                            $('select[name="section"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="section"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });


                        }
                    });
                }else{
                    $('select[name="section"]').empty();
                }

        });
    </script>
@endsection