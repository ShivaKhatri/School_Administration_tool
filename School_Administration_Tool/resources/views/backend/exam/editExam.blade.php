@extends('staff.layout.auth')
@section('headScripts')
    <link rel="stylesheet" href="{!! asset('plugins/iCheck/all.css')!!}">
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">

@endsection
@section('content')
    {!! Form::model($exam, [
          'route' => ['exam.update', $exam->id],
          'class' =>"form-horizontal form-label-left",
          'method' => 'PUT',
          'id' => 'examForm',
          'enctype' => "multipart/form-data",
      ])
      !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Exam</h3>
        </div>
        <div class="box-body">
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">

                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Exam Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'','maxlength'=>25)) }}
                </div>
                @if ($errors->has('name'))
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <span class="col-md-2 col-sm-2 col-xs-2"></span>
                        <div class="alert alert-danger alert-dismissible col-md-8 col-sm-8 col-xs-8">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            {{ $errors->first('name') }}
                        </div>
                        <span class="col-md-2 col-sm-2 col-xs-2"></span>
                    </div>
                @endif
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">
                <span class="col-md-2 col-sm-2 col-xs-2"></span>
                <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }} col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Start date
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::date('from',null,['class'=>'date'])}}
                    </div>
                    @if ($errors->has('from'))
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="col-md-2 col-sm-2 col-xs-2"></span>
                            <div class="alert alert-danger alert-dismissible col-md-8 col-sm-8 col-xs-8">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                The Start Date is required for the exam
                            </div>
                            <span class="col-md-2 col-sm-2 col-xs-2"></span>
                        </div>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('to') ? ' has-error' : '' }} col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >End date
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::date('to',null,['class'=>'date'])}}

                        {{--                    {{ Form::date('to', \Carbon\Carbon::createFromFormat('d-m-Y', $to->to)->format('Y') )}}--}}
                    </div>
                    @if ($errors->has('to'))
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="col-md-2 col-sm-2 col-xs-2"></span>
                            <div class="alert alert-danger alert-dismissible col-md-8 col-sm-8 col-xs-8">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                The End Date must me after the Start Date of exam
                            </div>
                            <span class="col-md-2 col-sm-2 col-xs-2"></span>
                        </div>
                    @endif
                </div>
                <span class="col-md-2 col-sm-2 col-xs-2"></span>

            </div>
            {{----}}
            <div class="col-md-12 col-sm-12 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">
                <span class="col-md-2 col-sm-2 col-xs-2"></span>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Result date
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::date('resultDay',null,['class'=>'date'])}}
                    </div>
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Session Year
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::selectYear('session_year',date('Y')-10, date('Y')+1,null,['class'=>'year']) }}

                        {{--                    {{ Form::date('to', \Carbon\Carbon::createFromFormat('d-m-Y', $to->to)->format('Y') )}}--}}
                    </div>
                </div>
                <span class="col-md-2 col-sm-2 col-xs-2"></span>

            </div>
            {{----}}
            {{--<div class="form-group">--}}
            {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" >Session--}}
            {{--</label>--}}
            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
            {{--{{ Form::selectYear('session_year',date('Y')-10, date('Y')+1,null,['class'=>'year']) }}--}}

            {{--                    {{ Form::date('session_year', \Carbon\Carbon::createFromFormat('d-m-Y', $session_year->session_year)->format('Y') )}}--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
            {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" >Result Day--}}
            {{--</label>--}}
            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
            {{--{{ Form::selectYear('resultDay',date('Y')-10, date('Y')+1,null,['class'=>'year']) }}--}}

            {{--                    {{ Form::date('session_year', \Carbon\Carbon::createFromFormat('d-m-Y', $session_year->session_year)->format('Y') )}}--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="form-group col-md-12 col-sm-12 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">
                @foreach($classRoom as $data)
                    <span class="col-md-2 col-sm-2 col-xs-2"></span>
                    <div class="col-md-8 col-sm-8 col-xs-8 row" style="margin:3px; border-style: groove; border-color:#3c8dbc; ">
                        <span class="col-md-4 col-sm-4 col-xs-4"></span>
                        {{--{{dd($exam)}}--}}
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label >Class {{$data->name}}
                            </label>
                            {{Form::checkbox('classRoom[]', $data->id,null,array('class'=>'green-checkbox'))}}&ensp;&ensp;

                        </div>
                        <span class="col-md-4 col-sm-4 col-xs-4"></span>
                        <div class="col-md-12 col-sm-12 col-xs-12"  style="display: flex; flex-wrap: wrap; align-content: stretch; margin:5px;">

                            <span class="col-md-5 col-sm-5 col-xs-5"></span>
                            <label class="col-md-2 col-sm-2 col-xs-2" >Subject
                            </label>
                            <span class="col-md-5 col-sm-5 col-xs-5"></span>
                        </div>
                        @php
                            $subject=\App\Model\ClassRoom::find($data->id)->subject()->get()
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
                                        {{Form::number('full_marks'.$diff,null,array('min' => 10,'max'=>100,'class'=> 'form-control col-md-7 col-xs-12'))}}
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Pass Marks</label>
                                        {{Form::number('pass_marks'.$diff,null,array('min' => 10,'max'=>60,'class'=> 'form-control col-md-7 col-xs-12','maxlength' => 2))}}
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
        $(document).ready(function () {//executes when the html file is fully loaded
            $('#submit').click(function() {//when the submit button is clicked this function will execute
                // classCheck = $("input[name='class[]':checked").length;  //checks the number of checked box. updates every time we check or uncheck
                //console.log(classCheck)//  to see the number of clicked check boxes
//
                if(!$('input[name="classRoom[]"]:checked').length > 0) {// $('input[name="class[]"]:checked').length gets the number of checked boxes. if the length of checked boxes is not less than or equal to zero
                    alert("You must Select at least one Class.");//alerts user to select at least one class
                    return false;
                }
            });
        });
    </script>
@endsection