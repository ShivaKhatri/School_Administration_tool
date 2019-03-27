@extends('staff.layout.auth')
@section('headcss')
    <link rel="stylesheet" href="{!! asset('plugins/iCheck/all.css')!!}">
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">
@endsection
@section('content')
    {!! Form::open(['url' => 'staff/exam','class'=>'form-horizontal','id'=>'examForm']) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Exam</h3>
        </div>
        <div class="box-body">
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">

                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Exam Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'', 'maxlength'=>25)) }}
                </div>
            </div>
            @if ($errors->has('name'))
                <span class="col-md-2 col-sm-2 col-xs-2"></span>
                <div class="alert alert-danger alert-dismissible col-md-8 col-sm-8 col-xs-8">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    {{ $errors->first('name') }}
                </div>
                <span class="col-md-2 col-sm-2 col-xs-2"></span>

                {{--<span class="help-block col-md-12 col-sm-12 col-xs-12">--}}
                {{--<strong>{{ $errors->first('name') }}</strong>--}}
                {{--</span>--}}
            @endif
            <div class="col-md-12 col-sm-12 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">
                <span class="col-md-2 col-sm-2 col-xs-2"></span>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Start date<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::date('from',null,['class'=>'date','required'=>''])}}
                    </div>
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >End date<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::date('to',null,['class'=>'date','required'=>''])}}

                        {{--                    {{ Form::date('to', \Carbon\Carbon::createFromFormat('d-m-Y', $to->to)->format('Y') )}}--}}
                    </div>
                </div>
                <span class="col-md-2 col-sm-2 col-xs-2"></span>

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">
                <span class="col-md-2 col-sm-2 col-xs-2"></span>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Result date<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::date('resultDay',null,['class'=>'date','required'=>''])}}
                    </div>
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Session Year<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::selectYear('session_year',date('Y')-20, date('Y')+1,date('Y'),['class'=>'year','required'=>'']) }}

                        {{--                    {{ Form::date('to', \Carbon\Carbon::createFromFormat('d-m-Y', $to->to)->format('Y') )}}--}}
                    </div>
                </div>
                <span class="col-md-2 col-sm-2 col-xs-2"></span>

            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">
                {{--@php--}}
                {{--$i=1;--}}
                {{--$diff=0;--}}
                {{--@endphp--}}
                @foreach($class as $data)
                    <span class="col-md-2 col-sm-2 col-xs-2"></span>
                    <div class="col-md-8 col-sm-8 col-xs-8 row" style="margin:3px; border-style: groove; border-color:#3c8dbc; ">
                        <span class="col-md-4 col-sm-4 col-xs-4"></span>

                        <div class="col-md-4 col-sm-4 col-xs-4 {{isset($message) ? ' has-error' : ''}}">
                            <label >Class {{$data->name}}
                            </label>
                            {{Form::checkbox('classRoom[]', $data->id,null,array('class'=>'green-checkbox'))}}&ensp;&ensp;

                        </div>
                        <span class="col-md-4 col-sm-4 col-xs-4"></span>
                        {{--                       {{dd(isset($message))}}--}}
                        {{--{{dd(Session::get('message'))}}--}}
                        @if (Session::get('message')!==null)

                            <span class="col-md-2 col-sm-2 col-xs-2"></span>
                            <div class="alert alert-danger alert-dismissible col-md-8 col-sm-8 col-xs-8">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                {{ Session::get('message') }}
                            </div>
                            <span class="col-md-2 col-sm-2 col-xs-2"></span>

                            {{--<span class="help-block col-md-12 col-sm-12 col-xs-12">--}}
                            {{--<strong>{{ $errors->first('name') }}</strong>--}}
                            {{--</span>--}}
                        @endif
                        <div class="col-md-12 col-sm-12 col-xs-12"  style="display: flex; flex-wrap: wrap; align-content: stretch; margin:5px;">

                            <span class="col-md-5 col-sm-5 col-xs-5"></span>
                            <label class="col-md-2 col-sm-2 col-xs-2" >Subject
                            </label>
                            <span class="col-md-5 col-sm-5 col-xs-5"></span>
                        </div>
                        @php
                            $subject=\App\Model\ClassRoom::find($data->id)->subject()->get();
                        @endphp

                        <div class="col-md-12 col-sm-12 col-xs-12 row">
                            @foreach($subject as $row)
                                @php
                                    $diff=$data->id.$row->id;//to create a unique name for the input fields of the subjects marks, by attaching two variables together
                                @endphp

                                <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 10px 10px 10px 10px;">
                                    <div class="col-md-4 col-sm-4 col-xs-4" style="padding: 15px 15px 15px 15px;">
                                        {{Form::checkbox('subject'.$data->id.'[]', $row->id,null,array('class'=>'green-checkbox'))}}&ensp;&ensp;
                                        <label>{{$row->name}}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4" >
                                        <label>Full Marks</label>
                                        {{Form::number('full_marks'.$diff,null,array('min' => 2,'max'=>100,'class'=> 'form-control col-md-7 col-xs-12'))}}
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Pass Marks</label>
                                        {{Form::number('pass_marks'.$diff,null,array('min' => 1,'max'=>99,'class'=> 'form-control col-md-7 col-xs-12'))}}
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Exam Day</label>
                                        {{Form::date('examDate'.$diff,null,array('class'=> 'form-control col-md-7 col-xs-12'))}}
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Time From</label>
                                        {{Form::time('time_from'.$diff,null,array('class'=> 'form-control col-md-7 col-xs-12'))}}
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Time To</label>
                                        {{Form::time('time_to'.$diff,null,array('class'=> 'form-control col-md-7 col-xs-12'))}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <form>
                <textarea class="textarea" placeholder="Place some text here" name="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </form>
                </div>
            </div>
            <div class="form-group {{--{{ $errors->has('status') ? ' has-error' : '' }}--}}">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Status
                    <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <label>
                        <span class="lbl"> Publish </span>

                        {!! Form::radio('status', 1, true, [
                             'class' => 'green-radio'
                             ]) !!}
                    </label>&ensp;&ensp;
                    <label>
                        <span class="lbl">  Archive  </span>

                        {!! Form::radio('status', 0, false, [
                            'class' => 'red-radio'
                            ]) !!}
                    </label>
                    {{--@if ($errors->has('status'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('status') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                </div>
                {{--<span class="col-md-3"></span>--}}
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" form="examForm" id="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
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
            $('input[type="checkbox"].green-checkbox, input[type="radio"].green-radio').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            })
        });
    </script>
    <script>
        $(function () {
            $('input[type="checkbox"].red-checkbox,input[type="radio"].red-radio').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass   : 'iradio_flat-red'
            })
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#submit').click(function() {
                if(!$('input[name="classRoom[]"]:checked').length > 0) {// $('input[name="class[]"]:checked').length gets the number of checked boxes. if the length of checked boxes is not less than or equal to zero
                    alert("You must Select at least one Class.");//alerts user to select at least one class
                    return false;
                }
            });
        });
    </script>
@endsection