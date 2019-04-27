@extends('staff.layout.auth')

@section('content')
    <div class="row">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Discount Details</h3>
            </div>
            {!! Form::model($discount, [
                  'route' => ['discount.update', $discount->id],
                  'class' =>"form-horizontal form-label-left",
                  'method' => 'PUT',
                  'id' => 'sectionForm',
                  'enctype' => "multipart/form-data",
              ])
              !!}
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Discount Title<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::text('name',$discount->name, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="textarea form-control" placeholder="Place some text here" name="description"
                >{{$discount->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Discount For<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        @if($discount->student_id==null)
                            {{ Form::select('type',[''=>'Discount For','class'=>'For a Class','student'=>'For a particular student'],'class', array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                        @else
                            {{ Form::select('type',[''=>'Discount For','class'=>'For a Class','student'=>'For a particular student'],'student', array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}

                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('class_id',$class,$discount->class_id, array('class' => 'form-control col-md-7 col-xs-12','required'=>'','placeholder'=>'Select Class')) }}
                    </div>
                </div>
                <div id="student">

                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Discount Amount<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::text('amount',$discount->amount, array('class' => 'form-control col-md-7 col-xs-12','id'=>'amount','required'=>'','maxlength'=>7)) }}
                    </div>
                </div>
            </div>
            <div class="box-footer  d-flex justify-content-center">
                <button type="submit" form="sectionForm" class="btn btn-primary">Add</button>
            </div>
        </div>
        {!! Form::close() !!}


        @endsection

        @section('scripts')
            <script type="text/javascript">
                $(document).ready(function() {
                    var classId = $('select[name="class_id"]').val();
                    var feeType = $('select[name="type"]').val();
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
                    $('select[name="class_id"]').on('change', function() {
                        var classId = $(this).val();
                        var feeType = $('select[name="type"]').val();
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
                    $('select[name="type"]').on('change', function() {
                        var classId = $('select[name="class_id"]').val();
                        var feeType = $(this).val();
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
                $("#amount").inputFilter(function(value) {
                    return /^\d*$/.test(value); });
            </script>

@endsection

