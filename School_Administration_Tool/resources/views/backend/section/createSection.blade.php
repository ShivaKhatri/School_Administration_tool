@extends('staff.layout.auth')
@section('headScripts')
    <link rel="stylesheet" href="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')!!}">
@endsection
@section('content')
    <div class="row">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add New Section</h3>
            </div>
            {!! Form::open(array('route'=>'section.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Section Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                    </div>
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
            </div>
            <div class="box-footer">
                <button type="submit" form="sectionForm" class="btn btn-primary">Submit</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{!! asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')!!}"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
        })
    </script>
@endsection


