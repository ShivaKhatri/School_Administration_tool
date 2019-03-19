@extends('staff.layout.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{route('student.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="item form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
                                        <label class="control-label"> First Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            {{Form::text('fname', null, array('class' => 'form-control', 'placeholder'=>"Enter First Name",
                                            'required' => ''))}}
                                            @if ($errors->has('fname'))
                                                <span class="help-block">
                            <strong>{{ $errors->first('fname') }}</strong>
                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="item form-group {{ $errors->has('lname') ? ' has-error' : '' }}">
                                        <label class="control-label"> Last Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            {{Form::text('lname', null, array('class' => 'form-control', 'placeholder'=>"Enter Last Name",
                                            'required' => ''))}}
                                            @if ($errors->has('lname'))
                                                <span class="help-block">
                            <strong>{{ $errors->first('lname') }}</strong>
                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label class="control-label"> Gender
                                            <span class="required">*</span></label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            {!! Form::select('gender', array('M' => 'Male', 'F' => 'Female'), null, ["class" => "select2_single form-control" ,
                                                       "kl_virtual_keyboard_secure_input" => "on", 'required' => '',  "placeholder" => 'Select Gender',]) !!}
                                            @if ($errors->has('gender'))
                                                <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                                        <label class="control-label"> Date of Birth
                                            <span class="required">*</span></label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            <div class='input-group nepaliDatePicker' id='nepaliDate5'>
                                                {!! Form::text('dob', null, array('class' => 'form-control', "placeholder" => 'Enter Date of Birth',
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
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="item form-group {{ $errors->has('address') ? ' has-error' : '' }}">
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
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class=" form-group {{ $errors->has('mobile_no') ? ' has-error' : '' }}">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class=" form-group {{ $errors->has('phone_no') ? ' has-error' : '' }}">
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
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                                        <label class="control-label"> Picture
                                        </label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            {{--                            {{Form::file('pic', ["kl_virtual_keyboard_secure_input" => 'on', 'class'=>'col-md-7 col-xs-12', 'name' => 'pic'] )}}--}}
                                            {{Form::file('picture', ['class'=>'', 'id' => 'picture', 'name' => 'picture']) }}
                                            @if ($errors->has('picture'))
                                                <span class="help-block">
                                   <strong>{{ $errors->first('picture') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="x_title">
                                <h2><strong> Academic Info </strong></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                {{--@if(Auth::user()->utype == 'ADMIN')--}}
                                    {{--<div class="col-md-4 col-sm-4 col-xs-12">--}}
                                        {{--<div class="item form-group {{ $errors->has('academic_id') ? ' has-error' : '' }}">--}}
                                            {{--<label class="control-label"> Academy Name--}}
                                                {{--<span class="required">*</span> </label>--}}
                                            {{--<div class="input-group col-md-11 col-sm-11 col-xs-12">--}}
                                                {{--{!! Form::select('academic_id', [''=>'Select Academy']+$data['academic_id'], null, ["class" => "select2_single form-control" ,--}}
                                                    {{--"kl_virtual_keyboard_secure_input" => "on", 'required' => '', 'id' => 'academic_id',]) !!}--}}
                                                {{--@if ($errors->has('academic_id'))--}}
                                                    {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('academic_id') }}</strong>--}}
                            {{--</span>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group ">
                                        <label for="session"> Session
                                            <span class="required">*</span></label>
                                        <div class="input-group nepaliDatePicker" id='nepaliDate5'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span></span>
                                            {!! Form::text('session', null,
                                           ["class" => "form-control datepicker2" , 'required' => '', 'id' => 'session' ]) !!}
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-md-4 col-sm-4 col-xs-12">--}}
                                    {{--<div class="form-group {{ $errors->has('class_room_id') ? ' has-error' : '' }}">--}}
                                        {{--<label class="control-label"> Class--}}
                                            {{--<span class="required">*</span></label>--}}
                                        {{--<div class="input-group col-md-11 col-sm-11 col-xs-12">--}}
                                            {{--@if(Auth::user()->utype == 'A')--}}
                                                {{--{!! Form::select('class_room_id', [''=> 'Select Class']+$data['class_room'], null, ["class" => "select2_single form-control" ,--}}
                                             {{--"kl_virtual_keyboard_secure_input" => "on", 'required' => '', 'id' => 'class_room_id', ]) !!}--}}
                                            {{--@else--}}
                                                {{--{!! Form::select('class_room_id', [''=> 'Select Class'], null, ["class" => "select2_single form-control" ,--}}
                                        {{--"kl_virtual_keyboard_secure_input" => "on", 'required' => '', 'id' => 'class_room_id', ]) !!}--}}
                                            {{--@endif--}}
                                            {{--@if ($errors->has('class_room_id'))--}}
                                                {{--<span class="help-block"> <strong>{{ $errors->first('class_room_id') }}</strong>--}}
                        {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-4 col-sm-4 col-xs-12">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label class="control-label"> Section--}}
                                        {{--</label>--}}
                                        {{--<div class="input-group col-md-11 col-sm-11 col-xs-12">--}}
                                            {{--@if(Auth::user()->utype == 'A')--}}
                                                {{--{!! Form::select('section_id', [''=> 'Select Section']+$data['section'], null, ["class" => "select2_single form-control" ,--}}
                                                   {{--"kl_virtual_keyboard_secure_input" => "on", 'id' => 'section_id', ]) !!}--}}
                                            {{--@else--}}
                                                {{--{!! Form::select('section_id', [''=> 'Select Section'], null, ["class" => "select2_single form-control" ,--}}
                                             {{--"kl_virtual_keyboard_secure_input" => "on", 'id' => 'section_id', ]) !!}--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="item form-group {{ $errors->has('roll_no') ? ' has-error' : '' }}">
                                        <label class="control-label"> Roll No.
                                            <span class="required">*</span></label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            {{Form::number('roll_no', null, array('class' => 'form-control', 'placeholder'=> 'Enter Roll No.', 'required'=> ''))}}
                                            @if ($errors->has('roll_no'))
                                                <span class="help-block">
                                <strong>{{ $errors->first('roll_no') }}</strong>
                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="item form-group {{ $errors->has('remarks') ? ' has-error' : '' }}">
                                        <label class="control-label"> About Student
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
                                </div>
                                {{--<div class="col-md-4 col-sm-4 col-xs-12">--}}
                                    {{--<div class="item form-group">--}}
                                        {{--<label class="control-label"> Vehicle--}}
                                        {{--</label>--}}
                                        {{--<div class="input-group col-md-11 col-sm-11 col-xs-12">--}}
                                            {{--@if(Auth::user()->utype == 'ADMIN')--}}
                                                {{--{!! Form::select('vehicle_id', [' '=>'Select Vehicle'], null, ["class" => "select2_single form-control" ,--}}
                                                {{--"kl_virtual_keyboard_secure_input" => "on", 'id' => 'vehicle_id',--}}
                                                {{--'onchange'=>"showMe(this);"]) !!}--}}
                                            {{--@endif--}}
                                            {{--@if(Auth::user()->utype == 'A')--}}
                                                {{--{!! Form::select('vehicle_id', $data['vehicle'], null, ["class" => "select2_single form-control" ,--}}
                                                {{--"kl_virtual_keyboard_secure_input" => "on", 'id' => 'vehicle_id', 'placeholder'=> 'Select Vehicle',--}}
                                                {{--'onchange'=>"showMe(this);"]) !!}--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="item form-group {{ $errors->has('remarks') ? ' has-error' : '' }}" id="idShowMe"
                                         style="display: none">
                                        <label class="control-label"> Vehicle Station
                                        </label>
                                        <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                            {{Form::text('vehicle_station', null, array('class' => 'form-control', 'id' => 'vehicle_station',
                                            'name' => 'vehicle_station', 'placeholder'=> 'Enter Student Vehicle Station'))}}
                                            @if ($errors->has('remarks'))
                                                <span class="help-block">
                                 <strong>{{ $errors->first('remarks') }}</strong>
                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
