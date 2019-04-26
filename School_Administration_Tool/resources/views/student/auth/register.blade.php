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
@section('content')
    {{--<div class="row">--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Student</h3>
        </div>
        <div class="box-body">
            {{--<form class="form-horizontal" id="studentForm" role="form" method="POST" action="{{route('student.store') }}">--}}
                {!! Form::open(['url' => 'staff/student','class'=>'form-horizontal','id'=>'studentForm','files'=>'true']) !!}

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
                    </label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('middleName', null, array('class' => 'form-control', 'placeholder'=>"Enter Middle Name",
                        'maxlength'=>10))}}
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
                        <div class='input-group ' >
                            @php

                                    @endphp
                            {!! Form::date('dob', null, array('class' => 'form-control', "placeholder" => 'Enter Date of Birth',
                                                             'required' => '', 'id'=>'dob','min'=>"1940-01-01", "max"=>"2017-12-31")) !!}
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
                    <label class="control-label"> Mobile No.</label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">
                        {{Form::text('mobile_no', null, array('class' => 'form-control',
                        'placeholder'=>"Enter Mobile Number ( For SMS Service)",'id'=>'Mob_number','maxlength'=>10))}}
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
                        {{Form::text('phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number",'id'=>'Ph_number','maxlength'=>10))}}
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

{{--                        {!! Form::select('section', , null, ["class" => "form-control" ,'id' => 'section', ]) !!}--}}
                        <select name="section" class="form-control" ></select>
                        @if ($errors->has('section'))
                            <span class="help-block"> <strong>{{ $errors->first('section') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-4">
                <label class="control-label" >Session Year<span class="required">*</span>
                </label>
                <div class="input-group col-md-11 col-sm-11 col-xs-12">

                {{ Form::selectYear('session_year',date('Y')-3, date('Y')+1,date('Y'),['class'=>'form-control year','required'=>'']) }}

                    {{--                    {{ Form::date('to', \Carbon\Carbon::createFromFormat('d-m-Y', $to->to)->format('Y') )}}--}}
                </div>
            </div>
                <div class="x_title col-md-12 col-sm-12 col-xs-12">
                    <h2> Information About Parents And Guardian </h2>
                    <div class="clearfix"></div>
                </div>
            <div class="row col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <label class="control-label"> Is The Information About Parents And Guardian Already In The System? </label>
                        <div class="input-group col-md-3 col-sm-3 col-xs-5">

                            {!! Form::select('exist', ['yes'=>'Yes','no'=>'No'], 'no', ["class" => "form-control" ,'required' => '']) !!}
                        </div>
                </div>
            </div>
                <div class="x_title col-md-12 col-sm-12 col-xs-12" id="no1">
                    <h2> Choose whose information is to be collected </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="row col-md-12 col-sm-12 col-xs-12" id="no2">
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                        <label class="control-label"> Mother</label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                                        {{Form::checkbox('guardian[]', "Mother",null,array( 'id'=>'mom'))}}&ensp;&ensp;
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                        <label class="control-label"> Father</label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                                        {{Form::checkbox('guardian[]', "Father",null,array('id'=>'dad'))}}&ensp;&ensp;

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                        <label class="control-label"> Guardian</label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                                        {{Form::checkbox('guardian[]', "Guardian",null,array('id'=>'guard'))}}&ensp;&ensp;

                        </div>
                    </div>
                </div>
            <div id="true1">

            </div>
            <span class="help-block" id="valid1"> </span>
            <div id="true2">

            </div>
            <span class="help-block" id="valid2"> </span>

            <div id="true3">

            </div>

            <div id="mother">
                    <div class="x_title col-md-12 col-sm-12 col-xs-12">
                        <h2> Mothers Information </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_Fname') ? ' has-error' : '' }}">
                        <label class="control-label"> Mothers First Name
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('ma_Fname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

                            {!! Form::text('ma_Mname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

                            {!! Form::text('ma_Lname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
                        'placeholder'=> 'Enter Mothers Last Name'))!!}

                            @if ($errors->has('ma_Lname'))
                                <span class="help-block"> <strong>{{ $errors->first('ma_Lname') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_mobile_no') ? ' has-error' : '' }}">
                        <label class="control-label"> Mobile
                            No.
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('ma_mobile_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Mobile Number",'id'=>'Mo_number','maxlength'=>10,'required'=>''))}}
                            @if ($errors->has('ma_mobile_no'))
                                <span class="help-block">
                                <strong>{{ $errors->first('ma_mobile_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_phone_no') ? ' has-error' : '' }}">
                        <label class="control-label"> Phone
                            No.
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('ma_phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number",'id'=>'Ma_number','maxlength'=>10))}}
                            @if ($errors->has('ma_phone_no'))
                                <span class="help-block">
                                <strong>{{ $errors->first('ma_phone_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_address') ? ' has-error' : '' }} ">
                        <label class="control-label"> Address
                            <span class="required">*</span>
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('ma_address', null, array('class' => 'form-control required', 'placeholder'=>"Enter Address",
                            'required' => ''))}}
                            @if ($errors->has('ma_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ma_address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ma_occupation') ? ' has-error' : '' }}">
                        <label class="control-label"> Mothers Occupation
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('ma_occupation', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
                        'placeholder'=> 'Enter Mothers Occupation'))!!}

                            @if ($errors->has('ma_occupation'))
                                <span class="help-block"> <strong>{{ $errors->first('ma_occupation') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group{{ $errors->has('ma_profilePic') ? ' has-error' : '' }}">
                        <label class="control-label"> Profile picture
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::file('ma_profilePic', ['class'=>'form-control required', 'id' => 'ma_profilePic']) }}
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
                            {{Form::email('ma_email', null, array('class' => 'form-control required', 'placeholder'=>"Enter mothers email address",
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
                            <input id="ma_password" type="password" class="form-control required" name="ma_password" required="">
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
                            <input id="ma_password_confirmation" type="password" class="form-control required" name="ma_password_confirmation" required="">
                            @if ($errors->has('ma_password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ma_password_confirmation') }}</strong>
                                    </span>
                            @endif
                            <span class="help-block">
                                        <strong id="ma_message"></strong>
                                </span>
                        </div>
                    </div>
                </div>
                <div id="father">
                    <div class="x_title col-md-12 col-sm-12 col-xs-12">
                        <h2> Fathers Information </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_Fname') ? ' has-error' : '' }}">
                        <label class="control-label"> Fathers First Name
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('fa_Fname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

                            {!! Form::text('fa_Mname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

                            {!! Form::text('fa_Lname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
                        'placeholder'=> 'Enter Fathers Last Name'))!!}

                            @if ($errors->has('fa_Lname'))
                                <span class="help-block"> <strong>{{ $errors->first('fa_Lname') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_mobile_no') ? ' has-error' : '' }}">
                        <label class="control-label"> Mobile
                            No.
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('fa_mobile_no', null, array('class' => 'form-control required', 'placeholder'=>"Enter Phone Number",'id'=>'Da_number','maxlength'=>10))}}
                            @if ($errors->has('fa_mobile_no'))
                                <span class="help-block">
                                <strong>{{ $errors->first('fa_mobile_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_phone_no') ? ' has-error' : '' }}">
                        <label class="control-label"> Phone
                            No.
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('fa_phone_no', null, array('class' => 'form-control required', 'placeholder'=>"Enter Phone Number",'id'=>'Fa_number','maxlength'=>10))}}
                            @if ($errors->has('fa_phone_no'))
                                <span class="help-block">
                                <strong>{{ $errors->first('fa_phone_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_address') ? ' has-error' : '' }} ">
                        <label class="control-label"> Address
                            <span class="required">*</span>
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('fa_address', null, array('class' => 'form-control required', 'placeholder'=>"Enter Address",
                            'required' => ''))}}
                            @if ($errors->has('fa_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fa_address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('fa_occupation') ? ' has-error' : '' }}">
                        <label class="control-label"> Fathers Occupation
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('fa_occupation', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
                        'placeholder'=> 'Enter Mothers Occupation'))!!}

                            @if ($errors->has('fa_occupation'))
                                <span class="help-block"> <strong>{{ $errors->first('fa_occupation') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group{{ $errors->has('fa_profilePic') ? ' has-error' : '' }}">
                        <label class="control-label"> Profile picture
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::file('fa_profilePic', ['class'=>'form-control required', 'id' => 'fa_profilePic']) }}
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
                            {{Form::email('fa_email', null, array('class' => 'form-control required', 'placeholder'=>"Enter fathers email address",
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
                            <input id="fa_password" type="password" class="form-control required" name="fa_password" required="">
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
                            <input id="fa_password_confirmation" type="password" class="form-control required" name="fa_password_confirmation" required="">
                            @if ($errors->has('fa_password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('fa_password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <span class="help-block">
                                        <strong id="fa_message"></strong>
                                </span>
                    </div>
                </div>
                <div id="guardian">

                    <div class="x_title col-md-12 col-sm-12 col-xs-12">
                        <h2> Gaurdians Information </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_Fname') ? ' has-error' : '' }}">
                        <label class="control-label"> Guardians First Name
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('ga_Fname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

                            {!! Form::text('ga_Mname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

                            {!! Form::text('ga_Lname', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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
                            {{Form::text('ga_phone_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number",'id'=>'Go_number','maxlength'=>10))}}
                            @if ($errors->has('ga_phone_no'))
                                <span class="help-block">
                                <strong>{{ $errors->first('ga_phone_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_mobile_no') ? ' has-error' : '' }}">
                        <label class="control-label"> Mobile
                            No.
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('ga_mobile_no', null, array('class' => 'form-control', 'placeholder'=>"Enter Mobile Number",'id'=>'Ga_number','maxlength'=>10))}}
                            @if ($errors->has('ga_mobile_no'))
                                <span class="help-block">
                                <strong>{{ $errors->first('ga_mobile_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_address') ? ' has-error' : '' }} ">
                        <label class="control-label"> Address
                            <span class="required">*</span>
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::text('ga_address', null, array('class' => 'form-control required', 'placeholder'=>"Enter Address",
                            'required' => ''))}}
                            @if ($errors->has('ga_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ga_address') }}</strong>
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
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('occupation') ? ' has-error' : '' }}">
                        <label class="control-label"> Guardians Occupation
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('ga_occupation', null, array('class' => 'required form-control ', 'required' => '','maxlength'=>10,
                        'placeholder'=> 'Enter Guardians Occupation'))!!}

                            @if ($errors->has('occupation'))
                                <span class="help-block"> <strong>{{ $errors->first('occupation') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('relation') ? ' has-error' : '' }}">
                        <label class="control-label"> Guardians Relation With Student
                            <span class="required">*</span></label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">

                            {!! Form::text('relation', null, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
                        'placeholder'=> 'Guardians Relation with student'))!!}

                            @if ($errors->has('relation'))
                                <span class="help-block"> <strong>{{ $errors->first('relation') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12  form-group{{ $errors->has('ga_email') ? ' has-error' : '' }}">
                        <label class="control-label"> Email Address
                            <span class="required">*</span>
                        </label>
                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                            {{Form::email('ga_email', null, array('class' => 'form-control required', 'placeholder'=>"Enter guardians email address",
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
                            <input id="ga_password" type="password" class="form-control required" name="ga_password" required="">
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
                            <input id="ga_password_confirmation" type="password" class="form-control  required" name="ga_password_confirmation" required="">
                            @if ($errors->has('ga_password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ga_password_confirmation') }}</strong>
                                    </span>
                            @endif
                            <span class="help-block">
                                        <strong id="ga_message"></strong>
                                </span>
                        </div>
                    </div>
                </div>
            </form>


            <div class="col-md-12 col-sm-12 col-xs-12" style="display: flex; justify-content: center">
                <button type="submit" class="btn btn-primary" id="submit"  form="studentForm" >
                    Register
                </button>
            </div>

        </div>
    </div>
@endsection
@section('scripts')


    <script>
        $('#password, #password_confirmation').on('keyup', function () {
            if ($('#password').val() === $('#password_confirmation').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });
    </script>
    <script>
        $('#fa_password, #fa_password_confirmation').on('keyup', function () {
            if ($('#fa_password').val() === $('#fa_password_confirmation').val()) {
                $('#fa_message').html('Matching').css('color', 'green');
            } else
                $('#fa_message').html('Not Matching').css('color', 'red');
        });
    </script>
    <script>
        $('#ma_password, #ma_password_confirmation').on('keyup', function () {
            if ($('#ma_password').val() === $('#ma_password_confirmation').val()) {
                $('#ma_message').html('Matching').css('color', 'green');
            } else
                $('#ma_message').html('Not Matching').css('color', 'red');
        });
    </script>
    <script>
        $('#ga_password, #ga_password_confirmation').on('keyup', function () {
            if ($('#ga_password').val() === $('#ga_password_confirmation').val()) {
                $('#ga_message').html('Matching').css('color', 'green');
            } else
                $('#ga_message').html('Not Matching').css('color', 'red');
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#mother").hide();
            $("#father").hide();
            $("#guardian").hide();
            $("#mother :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
            $("#father :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
            $("#guardian :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs

            $("#mom").click(function () {
                if ($(this).is(":checked") && $('select[name="exist"]').val()=="no") {
                    $("#mother").show();
                    $("#mother :input").prop('required',true).attr('disabled',false);//to add required property of shown divs
                    $('#yes1').detach();

                } else if($(this).is(":checked") && $('select[name="exist"]').val()=="yes") {
                    $("#mother").hide();
                    $("#mother :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $('#true1').html(  ' <div class="col-md-6 col-sm-6 col-xs-12 form-group" id="yes1">' +
                        '<label class="control-label"> Enter Mothers Id</label>'+
                        '<div class="input-group col-md-11 col-sm-11 col-xs-12">'+
                        '<input type="number" name="yesMother" class="col-md-3 col-sm-3 col-xs-6" required/><span class="col-md-1 col-sm-1 col-xs-1"></span>'+
                        '<button type="button" id="yesMom" class=" btn-sm btn-primary  col-md-2 col-sm-4 col-xs-6">Validate</button>'+
                        '</div><div class="help-box" id="valid1"> </div>'+
                        '</div>');
                }
                else{
                    $("#mother").hide();
                    $("#mother :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $('#yes1').detach();

                }
            });
            $("#dad").click(function () {
                if ($(this).is(":checked") && $('select[name="exist"]').val()=="no") {
                    $("#father").show();
                    $("#father :input").prop('required',true).attr('disabled',false);//to add required property of shown divs
                    $('#yes2').detach();

                } else if($(this).is(":checked") && $('select[name="exist"]').val()=="yes") {
                    $("#father").hide();
                    $("#father :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $('#true2').html(  ' <div class="col-md-6 col-sm-6 col-xs-12 form-group" id="yes2">' +
                        '<label class="control-label"> Enter Fathers Id</label>'+
                        '<div class="input-group col-md-11 col-sm-11 col-xs-12">'+
                        '<input type="number" name="yesFather" class="col-md-3 col-sm-3 col-xs-6" required/><span class="col-md-1 col-sm-1 col-xs-1"></span>'+
                        '<button type="button" id="yesDad" class=" btn-sm btn-primary  col-md-2 col-sm-4 col-xs-5">Validate</button>'+
                        '</div><div class="help-box" id="valid2"> </div>'+
                        '</div>');
                }
                else{
                    $("#father").hide();
                    $("#father :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $('#yes2').detach();

                }
            });
            $("#guard").click(function () {
                if ($(this).is(":checked") && $('select[name="exist"]').val()=="no") {
                    $("#guardian").show();
                    $("#guardian :input").prop('required',true).attr('disabled',false);//to add required property of shown divs
                    $('#yes3').detach();
                } else if($(this).is(":checked") && $('select[name="exist"]').val()=="yes") {
                    $("#guardian").hide();
                    $("#guardian :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $('#true3').html(  ' <div class="col-md-6 col-sm-6 col-xs-12 form-group" id="yes3">' +
                        '<label class="control-label"> Enter Guardian Id</label>'+
                        '<div class="input-group col-md-11 col-sm-11 col-xs-12">'+
                        '<input type="number" name="yesGuardian" class="col-md-3 col-sm-4 col-xs-6" required/><span class="col-md-1 col-sm-1 col-xs-1"></span>'+
                        '<button type="button" id="yesGuard" class=" btn-sm btn-primary  col-md-2 col-sm-4 col-xs-6">Validate</button>'+
                        '</div><div class="help-box" id="valid3"> </div>'+
                        '</div>');
                }
                else{
                    $("#guardian").hide();
                    $("#guardian :input").prop('required',null).attr('disabled',true);//to remove required property of hidden divs
                    $('#yes3').detach();

                }
            });
        });
    </script>
    <script>


        $(document).ready(function () {//executes when the html file is fully loaded
            $('#submit').click(function() {//when the submit button is clicked this function will execute
                // classCheck = $("input[name='guardian[]':checked").length;  //checks the number of checked box. updates every time we check or uncheck
                //console.log(classCheck)//  to see the number of clicked check boxes
//
                if(!$('input[name="guardian[]"]:checked').length > 0) {// $('input[name="class[]"]:checked').length gets the number of checked boxes. if the length of checked boxes is not less than or equal to zero
                    alert("You must fill at least one guardians information.");//alerts user to select at least one class
                    return false;
                }
            });
        });
    </script>
    <script>
        // Restricts input for each element in the set of matched elements to the given inputFilter.
        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    }
                });
            };
        }(jQuery));
        $("#Ph_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Mob_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Fa_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Da_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Ma_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Mo_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Ga_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
        $("#Go_number").inputFilter(function(value) {
            return /^\d*$/.test(value); });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="classRoom"]').on('change', function() {
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
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", "#yesGuard", function(){
            // $('#yesGuard').click(function() {
                var classId = $('input[name="yesGuardian"]').val();
                var relation = 'guardian';

                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'validate/'+classId+'/'+relation,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#valid3').html('<span class="label label-success">Valid</span>')

                            }
                else {
                                $('input[name="yesGuardian"]').val('');
                                $('#valid3').html('<span class="label label-danger">Not Valid</span>')
                            }
                        }
                    });
                }
            });
        });
    </script>

 <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", "#yesDad", function(){
            // $('#yesGuard').click(function() {
                var classId = $('input[name="yesFather"]').val();
                var relation = 'Father';

                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'validate/'+classId+'/'+relation,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#valid2').html('<span class="label label-success">Valid</span>')

                            }
                else {
                                $('input[name="yesFather"]').val('');
                                $('#valid2').html('<span class="label label-danger">Not Valid</span>')
                            }
                        }
                    });
                }
            });
        });
    </script>

 <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", "#yesMom", function(){
            // $('#yesGuard').click(function() {
                var classId = $('input[name="yesMother"]').val();
                var relation = 'Mother';
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'validate/'+classId+'/'+relation,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#valid1').html('<span class="label label-success">Valid</span>')

                            }
                else {
                                $('input[name="yesMother"]').val('');
                                $('#valid1').html('<span class="label label-danger">Not Valid</span>')
                            }
                        }
                    });
                }
            });
        });
    </script>


@endsection