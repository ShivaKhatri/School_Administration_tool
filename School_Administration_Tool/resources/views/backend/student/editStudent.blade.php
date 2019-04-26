@extends('staff.layout.auth')
@section('content')
    <div class="row">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Student Details</h3>
            </div>
            {!! Form::model($student, [
                  'route' => ['student.update', $student->id],
                  'class' =>"form-horizontal form-label-left",
                  'method' => 'PUT',
                  'id' => 'sectionForm',
                  'enctype' => "multipart/form-data",
              ])
              !!}
            <div class="box-body">
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label"> Email Address
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::email('email', $student->email, array('class' => 'form-control', 'placeholder'=>"Enter your email address",
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
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                    <label class="control-label"> First Name
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('firstName', $student->firstName, array('class' => 'form-control', 'placeholder'=>"Enter First Name",
                        'required' => '','maxlength'=>10))}}
                        @if ($errors->has('firstName'))
                            <span class="help-block">
                            <strong>{{ $errors->first('firstName') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('middleName') ? ' has-error' : '' }}">
                    <label class="control-label"> Middle Name
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('middleName', $student->middleName, array('class' => 'form-control', 'placeholder'=>"Enter First Name",
                        'required' => '','maxlength'=>10))}}
                        @if ($errors->has('middleName'))
                            <span class="help-block">
                            <strong>{{ $errors->first('middleName') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group {{ $errors->has('lastName') ? ' has-error' : '' }}">
                    <label class="control-label"> Last Name
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('lastName', $student->LastName, array('class' => 'form-control', 'placeholder'=>"Enter Last Name",
                        'required' => '','maxlength'=>10))}}
                        @if ($errors->has('lastName'))
                            <span class="help-block">
                            <strong>{{ $errors->first('lastName') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                    <label class="control-label"> Gender
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {!! Form::select('gender', array('M' => 'Male', 'F' => 'Female', 'O'=>'Other'), $student->gender, ["class" => "select2_single form-control" ,
                                   'required' => '',  "placeholder" => 'Select Gender',]) !!}
                        @if ($errors->has('gender'))
                            <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                    <label class="control-label"> Date of Birth
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <div class='input-group ' >
                            {!! Form::date('dob', $student->dob, array('class' => 'form-control', "placeholder" => 'Enter Date of Birth',
                                                             'required' => '', 'id'=>'dob')) !!}
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                            @if ($errors->has('dob'))
                                <span class="help-block">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('address') ? ' has-error' : '' }} ">
                    <label class="control-label"> Address
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('address', $student->address, array('class' => 'form-control', 'placeholder'=>"Enter Address",
                        'required' => ''))}}
                        @if ($errors->has('address'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Mobile No.
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('mobile_no', null, array('class' => 'form-control',
                        'placeholder'=>"Enter Mobile Number ( For SMS Service)", 'required' => ''))}}
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
                        {{Form::number('phone_no', $student->phone_no, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
                        @if ($errors->has('phone_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone_no') }}</strong>
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
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('remarks') ? ' has-error' : '' }}">
                    <label class="control-label"> Remark
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('remarks', $student->remark, array('class' => 'form-control', 'placeholder'=> 'Student Description (Optional)'))}}
                        @if ($errors->has('remarks'))
                            <span class="help-block">
                                 <strong>{{ $errors->first('remarks') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                {{--</div>--}}
                <div class="x_title col-md-12 col-sm-12 col-xs-12">
                    <h2> Assign student to a class </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('class_room_id') ? ' has-error' : '' }}">
                    <label class="control-label"> Class
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::select('classRoom', $class, null, ["class" => "form-control" ,'required' => '', 'id' => 'classRoom','placeholder'=>"Select Class "]) !!}

                        @if ($errors->has('classRoom'))
                            <span class="help-block"> <strong>{{ $errors->first('classRoom') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('section') ? ' has-error' : '' }}">
                    <label class="control-label"> Section
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <select name="section" class="form-control" ></select>
                        @if ($errors->has('section'))
                            <span class="help-block"> <strong>{{ $errors->first('section') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label " >Session Year<span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                    {{ Form::selectYear('session_year',date('Y')-20, date('Y')+1,date('Y'),['class'=>'form-control year','required'=>'']) }}

                        {{--                    {{ Form::date('to', \Carbon\Carbon::createFromFormat('d-m-Y', $to->to)->format('Y') )}}--}}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" form="sectionForm" class="btn btn-primary">Submit</button>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="classRoom"]').on('change', function() {
                var classId = $(this).val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'ajaxEdit/'+classId,
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
        });
    </script>
@endsection