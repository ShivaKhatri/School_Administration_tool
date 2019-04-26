@extends('staff.layout.auth')
@section('content')
    <div class="row">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Record marks obtained by students in a particular exam</h3>
            </div>
            {!! Form::model($mark, [
                  'route' => ['mark.update', $mark->id],
                  'class' =>"form-horizontal form-label-left",
                  'method' => 'PUT',
                  'id' => 'sectionForm',
                  'enctype' => "multipart/form-data",
              ])
              !!}
            <div class="box-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>{{$errors->first()}}
                    </div>
                @endif
                <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                    <label class="control-label"> Exam
                        <span class="required">*</span></label>
                    <div class="input-group col-md-11 col-sm-11 col-xs-12">

                        {!! Form::select('exam_id', $exam, $mark->exam_id, ["class" => "form-control" ,'required' => '','placeholder'=>"Select Exam "]) !!}

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" id="studentMark">

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
    <script type="text/javascript">
        $(document).ready(function() {
                var examID =  $('select[name="exam_id"]').val();
                console.log(examID);
                if(examID) {
                    $.ajax({
                        url: 'giveMark/'+examID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {


                            $('#studentMark').html(data);


                        }
                    });
                }else{
                    $('#getMark').detach();
                }
            $('select[name="exam_id"]').on('change', function() {
                var examID = $(this).val();
                console.log(examID);
                if(examID) {
                    $.ajax({
                        url: 'giveMark/'+examID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {


                            $('#studentMark').html(data);


                        }
                    });
                }else{
                    $('#getMark').detach();
                }
            });
        });
    </script>
    <script>
        // Restricts input for each element in the set of matched elements to the given inputFilter.
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
        $('#studentMark :input').inputFilter(function(value) {
            return /^\d*$/.test(value); });

    </script>
@endsection

