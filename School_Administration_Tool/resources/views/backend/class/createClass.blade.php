@extends('staff.layout.auth')

@section('content')
    {!! Form::open(['url' => 'staff/class','class'=>'form-horizontal']) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <div class="box-body">
            <div class="form-group">

                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{ Form::textarea('description',null, array('class' => 'form-control col-md-7 col-xs-12')) }}
                </div>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection