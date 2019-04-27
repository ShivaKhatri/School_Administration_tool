@extends('staff.layout.auth')

@section('content')
    {!! Form::open(['url' => 'staff/bill','class'=>'form-horizontal','id'=>'examForm']) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Publish Bills</h3>
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
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>No Bills to generate
                </div>
            @else
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 ">
                            {{Form::select('class_id',$class,null,['class'=>'form-control required','placeholder'=>'Select Class','required'=>''])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Issue Date<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 ">
                            {{Form::date('issue_date',null,['class'=>'form-control required','min'=>date('Y-m-d'), "max"=>'2019-05-30','required'=>''])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Due Date<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 ">
                            {{Form::date('due_date',null,['class'=>'form-control required','min'=>'2019-05-01', "max"=>'2019-07-31','required'=>''])}}
                        </div>
                    </div>
                </div>
        </div>
        <div id="forFooter">
            <div class="box-footer">
                <button type="submit" form="examForm" id="submit" class="btn btn-primary">Publish Bill</button>
            </div>
        </div>
    </div>
    @endif
    {!! Form::close() !!}
@endsection