@extends('staff.layout.auth')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-top:5px; margin-bottom: 5px;">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                        {{Form::select('class_id',$class,null,['class'=>'form-control examID required','placeholder'=>'Select Class','required'=>''])}}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">


            <div id="exam">

            </div>

        </div>
        <div class="box-footer" id="resultFooter">
            <div class="row no-print">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" onclick="printDiv()">
                        <i class="fa fa-download"></i> Generate PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#resultFooter').hide();
            $('select[name="class_id"]').on('change', function() {
                var classId = $(this).val();
                var examId = '{{$exam_id}}';
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'class/'+examId+'/'+classId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#exam').html(data);
                            $('#resultFooter').show();
                        }
                    });
                }else{
                    $('#resultFooter').hide();
                    $('#examRoutine').detach();
                }
            });
        });
    </script>
    <script>
        function printDiv() {
            var content = document.getElementById('examRoutine').innerHTML;
            // setTimeout(function(){ window.open('', 'Print', 'height=600,width=800')  }, 3000);
            // var mywindow = window.open('', 'Print', 'height=600,width=800');

            var bootstrap = '{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}';
            console.log(bootstrap);
            var fontAwsome = '{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}';
            var icon = '{{ URL:: asset('bower_components/Ionicons/css/ionicons.min.css') }}';
            var skin = '{{ URL:: asset('dist/css/skins/_all-skins.min.css') }}';
            var adminLite = '{{ URL::asset('dist/css/AdminLTE.min.css') }}';
            var mywindow= window.open('', 'Print', 'height=600,width=800');
            mywindow.document.open();
            mywindow.document.write("<!DOCTYPE html><html lang=\"en\"><head>"+
                "    <meta charset=\"utf-8\"><title>Print</title> <link rel=\"stylesheet\" href=\""+bootstrap+"\" media=\"print\">" +
                "    <link rel=\"stylesheet\" href=\""+fontAwsome+"\" media=\"print\">" +
                "    <link rel=\"stylesheet\" href=\""+icon+"\" media=\"print\">" +
                "    <link rel=\"stylesheet\" href=\""+skin+"\" media=\"print\">" +
                "    <link rel=\"stylesheet\" href=\""+adminLite+"\" media=\"print\"></head><body  onload=\"window.print()\">"+content+"</body></html>");
            mywindow.document.close();
            mywindow.focus()
            // mywindow.print();
            setTimeout(function(){mywindow.close();},3000);
            return true;
        }
    </script>
    @endsection