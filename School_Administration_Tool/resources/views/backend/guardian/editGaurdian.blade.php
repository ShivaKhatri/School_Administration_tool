@extends('staff.layout.auth')
@section('content')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Guardians Details</h3>
            </div>
            {!! Form::model($guardian, [
                  'route' => ['guardian.update', $guardian->id],
                  'class' =>"form-horizontal form-label-left",
                  'method' => 'PUT',
                  'id' => 'sectionForm',
                  'enctype' => "multipart/form-data",
              ])
              !!}
            <div class="box-body">
    <div class="col-md-4 col-sm-4 col-xs-12 form-group {{ $errors->has('ga_Fname') ? ' has-error' : '' }}">
        <label class="control-label"> Guardians First Name
            <span class="required">*</span></label>
        <div class="input-group col-md-11 col-sm-11 col-xs-12">

            {!! Form::text('ga_Fname', $guardian->firstName, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

            {!! Form::text('ga_Mname', $guardian->middleName, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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

            {!! Form::text('ga_Lname', $guardian->LastName, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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
            {{Form::number('ga_phone_no', $guardian->phone_no, array('class' => 'form-control', 'placeholder'=>"Enter Phone Number"))}}
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
            {{Form::number('ga_mobile_no', $guardian->mobile_no, array('class' => 'form-control', 'placeholder'=>"Enter Mobile Number"))}}
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
            {{Form::text('ga_address', $guardian->address, array('class' => 'form-control required', 'placeholder'=>"Enter Address",
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

            {!! Form::text('occupation', $guardian->occupation, array('class' => 'required form-control ', 'required' => '','maxlength'=>10,
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

            {!! Form::text('relation', $guardian->relation, array('class' => 'form-control required', 'required' => '','maxlength'=>10,
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
            {{Form::email('ga_email', $guardian->email, array('class' => 'form-control required', 'placeholder'=>"Enter guardians email address",
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
                <div class="box-footer">
                    <button type="submit" form="sectionForm" class="btn btn-primary">Submit</button>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
@endsection
@section('scripts')

<script>
    $('#ga_password, #ga_password_confirmation').on('keyup', function () {
        if ($('#ga_password').val() === $('#ga_password_confirmation').val()) {
            $('#ga_message').html('Matching').css('color', 'green');
        } else
            $('#ga_message').html('Not Matching').css('color', 'red');
    });
</script>
    @endsection