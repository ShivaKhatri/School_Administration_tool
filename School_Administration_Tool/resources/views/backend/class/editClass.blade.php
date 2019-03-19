@extends('staff.layout.auth')
@section('headScripts')
    <link rel="stylesheet" href="{!! asset('plugins/iCheck/all.css')!!}">
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">
@endsection
@section('content')
    <div class="row">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Class</h3>
            </div>
            {!! Form::model($class, [
                  'route' => ['class.update', $class->id],
                  'class' =>"form-horizontal form-label-left",
                  'method' => 'PUT',
                  'id' => 'classForm',
                  'enctype' => "multipart/form-data",
              ])
              !!}
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Section
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">

                        @foreach($section as $data)
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                {{Form::checkbox('section[]', $data->id,null,array('class'=>'flat-red'))}}&ensp;&ensp;
                                <label>{{$data->name}}</label>
                            </div>

                        @endforeach


                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Subject
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 row" style="display: flex; flex-wrap: wrap; align-content: stretch;">

                        @foreach($subject as $data)
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                {{Form::checkbox('subject[]', $data->id,null,array('class'=>'flat-red'))}}&ensp;&ensp;
                                <label>{{$data->name}}</label>
                            </div>

                        @endforeach


                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <form>
                <textarea class="textarea" placeholder="Place some text here" name="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$class->description}}</textarea>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" form="classForm" class="btn btn-primary">Submit</button>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
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
            $('input[type="checkbox"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
            })
        });
    </script>
@endsection