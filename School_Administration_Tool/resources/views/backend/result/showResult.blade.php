<!-- Main content -->

@extends('staff.layout.auth')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-top:5px; margin-bottom: 5px;">
                <div class="form-group" >
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Session
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                        {{ Form::selectYear('session_year',date('Y')-3, date('Y')+1,date('Y'),['class'=>'year form-control ','required'=>'']) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12" style="margin-top:5px; margin-bottom: 5px;">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Class
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                        {{Form::select('class_id',$class,null,['class'=>'form-control examID required','placeholder'=>'Select Class','required'=>''])}}
                    </div>
                </div>
            </div>

            <div id="section">

            </div>
            <div id="exam">

            </div>
            <div id="student">

            </div>
        </div>
        <div class="box-body">

            <div id="result">

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
    <script>
        function printDiv() {
            var content = document.getElementById('invoice').innerHTML;
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="class_id"]').on('change', function() {
                var classId = $(this).val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'section/'+classId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#section').html(data);
                            $('#resultFooter').hide();
                        }
                    });
                }else{
                    $('#sectionDetails').detach();
                    $('#examDetails').detach();
                    $('#resultFooter').hide();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#forFooter').hide();
            $('select[name="class_id"]').on('change', function() {
                var classId = $(this).val();
                var session = $('select[name="session_year"]').val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'exam/'+classId+'/'+session,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#exam').html(data);
                            $('#forFooter').show();
                            $('#studentDetails').detach();
                        }
                    });
                }else{
                    $('#forFooter').hide();
                    $('#studentDetails').detach();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#resultFooter').hide();

            $('select[name="session_year"]').on('change', function() {
                var session = $(this).val();
                var classId = $('select[name="class_id"]').val();
                console.log(classId);
                if(classId) {
                    $.ajax({
                        url: 'exam/'+classId+'/'+session,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('#examDetails').detach();
                            $('#studentDetails').detach();
                            $('#exam').html(data);
                        }
                    });
                }else{
                    $('#examDetails').detach();
                    $('#studentDetails').detach();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('change', '.exam_id', function(){
            var session = $('select[name="session_year"]').val();
            var classId = $('select[name="class_id"]').val();
            var secID='';
            if( $('select[name="section_id"]').val()){
                secID = $('select[name="section_id"]').val();}
            else{
                secID =null;
            }
var examID=$('select[name="exam_id"]').val();
            console.log(examID);
            if(examID!='') {
                $.ajax({
                    url: 'student/'+classId+'/'+secID+'/'+session,
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

    </script>

    <script type="text/javascript">
        $(document).on('change', '.student_id', function(){
            var session = $('select[name="session_year"]').val();
            var classId = $('select[name="class_id"]').val();
            var secID='';
            if( $('select[name="section_id"]').val()){
                secID = $('select[name="section_id"]').val();}
            else{
                secID =null;
            }
            var examID=$('select[name="exam_id"]').val();
            var studentID=$('select[name="student_id"]').val();
            console.log(examID);
            if(examID!='') {
                $.ajax({
                    url: 'result/'+classId+'/'+secID+'/'+session+'/'+examID+'/'+studentID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        $('#result').html(data);
                        $('#resultFooter').show();
                    }
                });
            }else{
                $('#resultDetails').detach();
                $('#resultFooter').hide();

            }
        });

    </script>

    <script type="text/javascript">
        $(document).on('change', '.section_id', function(){
            var session = $('select[name="session_year"]').val();
            var classId = $('select[name="class_id"]').val();
            var secID = $('select[name="section_id"]').val();

            console.log(classId);
            var examID=$('select[name="exam_id"]').val();
            if(examID!='') {
                $.ajax({
                    url: 'student/'+classId+'/'+secID+'/'+session,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        $('#student').html(data);
                    }
                });
            }else{
                $('#studentsDetails').detach();

            }
        });

    </script>


@endsection
