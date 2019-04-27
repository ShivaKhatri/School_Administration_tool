@extends('staff.layout.auth')

@section('content')
    {!! Form::open(['url' => 'staff/bill','class'=>'form-horizontal','id'=>'examForm']) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Generate Bills</h3>
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
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>No Publishable Bills
                </div>
            @else
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 ">
                            {{Form::select('class_id',$class,null,['class'=>'form-control required','placeholder'=>'Select Class','required'=>''])}}
                        </div>
                    </div>
                </div>

                <div id="student">

                </div>
        </div>
        <div id="forFooter">
            <div class="box-footer">
                <button type="submit" form="examForm" id="submit" class="btn btn-primary">Generate Bill</button>
            </div>
        </div>
    </div>
    @endif
    {!! Form::close() !!}
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="class_id"]').on('change', function() {
                var classId = $(this).val();
                var feeType = $('select[name="type"]').val()
                console.log(feeType);
                if(feeType==='student') {
                    $.ajax({
                        url: 'student/'+classId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#student').html(data);
                        }
                    });
                }else{
                    $('#studentDetails').detach();
                }
            });
        });
    </script>
@endsection