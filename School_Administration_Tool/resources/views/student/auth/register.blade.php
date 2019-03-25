@extends('staff.layout.auth')

@section('content')
    {{--<div class="row">--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Student</h3>
        </div>
        <div class="box-body">
            <form class="form-horizontal" role="form" method="POST" action="{{route('student.store') }}">
                {{ csrf_field() }}

                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label"> Email Address
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::email('email', null, array('class' => 'form-control', 'placeholder'=>"Enter your email address",
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
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                    <label class="control-label"> First Name
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('firstName', null, array('class' => 'form-control', 'placeholder'=>"Enter First Name",
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
                        {{Form::text('middleName', null, array('class' => 'form-control', 'placeholder'=>"Enter First Name",
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
                        {{Form::text('lastName', null, array('class' => 'form-control', 'placeholder'=>"Enter Last Name",
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
                        {!! Form::select('gender', array('M' => 'Male', 'F' => 'Female', 'O'=>'Other'), null, ["class" => "select2_single form-control" ,
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
                        <div class='input-group nepaliDatePicker' id='nepaliDate5'>
                            {!! Form::date('dob', null, array('class' => 'form-control', "placeholder" => 'Enter Date of Birth',
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
                        {{Form::text('address', null, array('class' => 'form-control', 'placeholder'=>"Enter Address",
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
                        {{Form::number('phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
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
                <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                    <label for="session"> Session
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{ Form::selectYear('session_year',date('Y')-20, date('Y')+1,date('Y'),['class'=>'form-control','required'=>'']) }}

                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('remarks') ? ' has-error' : '' }}">
                    <label class="control-label"> Remark
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('remarks', null, array('class' => 'form-control', 'placeholder'=> 'Student Description (Optional)'))}}
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

                        {!! Form::select('classRoom', [''=> 'Select Class'], null, ["class" => "form-control" ,'required' => '', 'id' => 'classRoom', ]) !!}

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

                        {!! Form::select('section', [''=> 'Select Class'], null, ["class" => "form-control" ,'id' => 'section', ]) !!}
                        @if ($errors->has('section'))
                            <span class="help-block"> <strong>{{ $errors->first('section') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="x_title col-md-12 col-sm-12 col-xs-12">
                    <h2> Fathers Information </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_Fname') ? ' has-error' : '' }}">
                    <label class="control-label"> Fathers First Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('fa_Fname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Fathers First Name'))!!}

                        @if ($errors->has('fa_Fname'))
                            <span class="help-block"> <strong>{{ $errors->first('fa_Fname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_Mname') ? ' has-error' : '' }}">
                    <label class="control-label"> Fathers Middle Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('fa_Mname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Fathers Middle Name'))!!}

                        @if ($errors->has('fa_Mname'))
                            <span class="help-block"> <strong>{{ $errors->first('fa_Mname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_Lname') ? ' has-error' : '' }}">
                    <label class="control-label"> Fathers Last Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('fa_Lname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Fathers Last Name'))!!}

                        @if ($errors->has('fa_Lname'))
                            <span class="help-block"> <strong>{{ $errors->first('fa_Lname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_phone_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Phone
                        No.
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('fa_phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
                        @if ($errors->has('fa_phone_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fa_phone_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_office_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Office
                        No.
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('fa_office_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Office Number"))}}
                        @if ($errors->has('fa_office_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fa_office_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group{{ $errors->has('fa_profilePic') ? ' has-error' : '' }}">
                    <label class="control-label"> Profile picture
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::file('fa_profilePic', ['class'=>'form-control', 'id' => 'fa_profilePic']) }}
                        @if ($errors->has('fa_profilePic'))
                            <span class="help-block">
                                   <strong>{{ $errors->first('fa_profilePic') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('fa_email') ? ' has-error' : '' }}">
                    <label class="control-label"> Email Address
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::email('fa_email', null, array('class' => 'form-control', 'placeholder'=>"Enter fathers email address",
                        'required' => ''))}}
                        @if ($errors->has('fa_email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('fa_email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('fa_password') ? ' has-error' : '' }}">
                    <label class="control-label"> New Password
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <input id="fa_password" type="password" class="form-control" name="fa_password" required="">
                        @if ($errors->has('fa_password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('fa_password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('fa_password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label"> Confirm Password
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <input id="fa_password_confirmation" type="password" class="form-control" name="fa_password_confirmation" required="">
                        @if ($errors->has('fa_password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('fa_password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="x_title col-md-12 col-sm-12 col-xs-12">
                    <h2> Mothers Information </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_Fname') ? ' has-error' : '' }}">
                    <label class="control-label"> Mothers First Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('ma_Fname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Mothers First Name'))!!}

                        @if ($errors->has('ma_Fname'))
                            <span class="help-block"> <strong>{{ $errors->first('ma_Fname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_Mname') ? ' has-error' : '' }}">
                    <label class="control-label"> Mothers Middle Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('ma_Mname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Mothers Middle Name'))!!}

                        @if ($errors->has('ma_Mname'))
                            <span class="help-block"> <strong>{{ $errors->first('ma_Mname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_Lname') ? ' has-error' : '' }}">
                    <label class="control-label"> Mothers Last Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('ma_Lname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Mothers Last Name'))!!}

                        @if ($errors->has('ma_Lname'))
                            <span class="help-block"> <strong>{{ $errors->first('ma_Lname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_phone_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Phone
                        No.
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('ma_phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
                        @if ($errors->has('ma_phone_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ma_phone_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_office_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Office
                        No.
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('ma_office_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Office Number"))}}
                        @if ($errors->has('ma_office_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ma_office_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group{{ $errors->has('ma_profilePic') ? ' has-error' : '' }}">
                    <label class="control-label"> Profile picture
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::file('ma_profilePic', ['class'=>'form-control', 'id' => 'fa_profilePic']) }}
                        @if ($errors->has('ma_profilePic'))
                            <span class="help-block">
                                   <strong>{{ $errors->first('ma_profilePic') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ma_email') ? ' has-error' : '' }}">
                    <label class="control-label"> Email Address
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::email('ma_email', null, array('class' => 'form-control', 'placeholder'=>"Enter mothers email address",
                        'required' => ''))}}
                        @if ($errors->has('ma_email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('ma_email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ma_password') ? ' has-error' : '' }}">
                    <label class="control-label"> New Password
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <input id="ma_password" type="password" class="form-control" name="ma_password" required="">
                        @if ($errors->has('ma_password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('ma_password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ma_password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label"> Confirm Password
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <input id="ma_password_confirmation" type="password" class="form-control" name="ma_password_confirmation" required="">
                        @if ($errors->has('ma_password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('ma_password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="x_title col-md-12 col-sm-12 col-xs-12">
                    <h2> Gaurdians Information </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_Fname') ? ' has-error' : '' }}">
                    <label class="control-label"> Guardians First Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('ga_Fname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Guardians First Name'))!!}

                        @if ($errors->has('ga_Fname'))
                            <span class="help-block"> <strong>{{ $errors->first('ga_Fname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_Mname') ? ' has-error' : '' }}">
                    <label class="control-label"> Guardians Middle Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('ga_Mname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Guardians Middle Name'))!!}

                        @if ($errors->has('ga_Mname'))
                            <span class="help-block"> <strong>{{ $errors->first('ga_Mname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_Lname') ? ' has-error' : '' }}">
                    <label class="control-label"> Guardians Last Name
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::text('ga_Lname', null, array('class' => 'form-control', 'required' => '','maxlength'=>10,
                    'placeholder'=> 'Enter Guardians Last Name'))!!}

                        @if ($errors->has('ga_Lname'))
                            <span class="help-block"> <strong>{{ $errors->first('ga_Lname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_phone_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Phone
                        No.
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('ga_phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
                        @if ($errors->has('ga_phone_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ga_phone_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_office_no') ? ' has-error' : '' }}">
                    <label class="control-label"> Office
                        No.
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::number('ga_office_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Office Number"))}}
                        @if ($errors->has('ga_office_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ga_office_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 form-group{{ $errors->has('ga_profilePic') ? ' has-error' : '' }}">
                    <label class="control-label"> Profile picture
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::file('ga_profilePic', ['class'=>'form-control', 'id' => 'ga_profilePic']) }}
                        @if ($errors->has('ga_profilePic'))
                            <span class="help-block">
                                   <strong>{{ $errors->first('ga_profilePic') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ga_email') ? ' has-error' : '' }}">
                    <label class="control-label"> Email Address
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::email('ga_email', null, array('class' => 'form-control', 'placeholder'=>"Enter guardians email address",
                        'required' => ''))}}
                        @if ($errors->has('ga_email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('ga_email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ga_password') ? ' has-error' : '' }}">
                    <label class="control-label"> New Password
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <input id="ga_password" type="password" class="form-control" name="ga_password" required="">
                        @if ($errors->has('ga_password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('ga_password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ga_password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label"> Confirm Password
                        <span class="required">*</span>
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        <input id="ga_password_confirmation" type="password" class="form-control" name="ga_password_confirmation" required="">
                        @if ($errors->has('ga_password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('ga_password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
            </form>


            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>

        </div>
    </div>
@endsection
