@extends('staff.layout.auth')

@section('content')
    <div class="box row" style="overflow:hidden; word-wrap:break-word">
        <div class="box-header row">
            <h3 class="box-title col-md-6 col-sm-6 col-xs-12">Generated Bills</h3>
            <span class="col-md-5 col-sm-5 col-xs-5"></span>
        </div>

    @foreach($class as $getClass)
        <!-- /.box-header -->

            @php
                $classDetails=\App\Model\ClassRoom::find($getClass->id);
                $session=date('Y');
                $fee=\App\Model\Fee::all()->where('class_id','=',$getClass->id)->where('session_year','=',$session)->where('paid_status','=',1);
                $fine=\App\Model\Fine::all()->where('class_id','=',$getClass->id)->where('session_year','=',$session)->where('paid_status','=',1);
                $discount=\App\Model\Discount::all()->where('class_id','=',$getClass->id)->where('session_year','=',$session)->where('paid_status','=',1);
                       $i=0;
                $j=0;
                if($fee->isNotEmpty())
                    $j=$j+1;
                if($fine->isNotEmpty())
                    $j=$j+1;
                if($discount->isNotEmpty())
                    $j=$j+1;
            @endphp
            @if($j!=0)
                <div class="box-body">
                    <div class="box box-success box-solid">
                        <div class="box-header ">
                            <h3 class="box-title col-md-6 col-sm-6 col-xs-12">Class: {{$classDetails->name}}</h3>
                            <span class="col-md-5 col-sm-5 col-xs-5"></span>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>For</th>
                                                <th>Issue Date</th>
                                                <th>Due Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($fee as $getFee)
                                                @php
                                                    $bill=\App\Model\Fee::find($getFee->id)->bill()->first();
                                                    $i=$i+1;
                                                      if($getFee->student_id==null)
                                                          $for='Whole Class';
                                                          else{
                                                          $student=\App\Student::find($getFee->student_id);
                                                          $for='ID:'.$student->id.' '.$student->firstName.' '.$student->middleName.' '.$student->LastName;
                                                          }
                                                  echo '<tr>
                                                      <td>'.$i.'</td>
                                                      <td>Fee</td>
                                                      <td>'.$getFee->name.'</td>
                                                      <td>'.$getFee->amount.'</td>
                                                      <td>'.$for.'</td>
                                                       <td>'.$bill->issue_date.'</td>
                                                        <td>'.$bill->due_date.'</td>
                                                  </tr>';
                                                @endphp
                                            @endforeach
                                            @foreach($fine as $getFine)
                                                @php
                                                    $bill=\App\Model\Fine::find($getFine->id)->bill()->first();

                                                    $i=$i+1;
                                                        if($getFine->student_id==null)
                                                            $for='Whole Class';
                                                            else{
                                                            $student=\App\Student::find($getFine->student_id);
                                                            $for='ID:'.$student->id.' '.$student->firstName.' '.$student->middleName.' '.$student->LastName;
                                                            }
                                                    echo '<tr>
                                                        <td>'.$i.'</td>
                                                        <td>Fine</td>
                                                        <td>'.$getFine->name.'</td>
                                                        <td>'.$getFine->amount.'</td>
                                                        <td>'.$for.'</td>
                                                         <td>'.$bill->issue_date.'</td>
                                                        <td>'.$bill->due_date.'</td>
                                                    </tr>';
                                                                                                @endphp
                                            @endforeach
                                            @foreach($discount as $getDiscount)
                                                @php
                                                    $bill=\App\Model\Discount::find($getDiscount->id)->bill()->first();
                                                    $i=$i+1;
                                                        if($getDiscount->student_id==null)
                                                            $for='Whole Class';
                                                            else{
                                                            $student=\App\Student::find($getDiscount->student_id);
                                                            $for='ID:'.$student->id.' '.$student->firstName.' '.$student->middleName.' '.$student->LastName;
                                                            }
                                                    echo '<tr>
                                                        <td>'.$i.'</td>
                                                        <td>Discount</td>
                                                        <td>'.$getDiscount->name.'</td>
                                                        <td>'.$getDiscount->amount.'</td>
                                                        <td>'.$for.'</td>
                                                        <td>'.$bill->issue_date.'</td>
                                                        <td>'.$bill->due_date.'</td>
                                                    </tr>';
                                                @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

@endsection


