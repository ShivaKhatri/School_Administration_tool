<?php

namespace App\Http\Controllers\Backend;

use App\Model\Bill;
use App\Model\ClassRoom;
use App\Model\Discount;
use App\Model\Fee;
use App\Model\Fine;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $fee=Fee::all()->where('paid_status','=',1);
//        $fine=Fine::all()->where('paid_status','=',1);
//        $fine=Fine::all()->where('paid_status','=',1);

        $class=ClassRoom::all();
        return view('backend.bill.indexBill')->with('class',$class);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $class=ClassRoom::all()->pluck('name','id');
        return view('backend.bill.generateBill')->with('class',$class);

    }
    public function student($class)
    {
        $session=date('Y-m-d');
        $student = DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->get();
        $html='  <div id="studentDetails"> 
                    <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" >Student
                         </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 ">
                    <select name="student_id" class="form-control student_id" required><option value="">Select Student</option>';
        foreach ($student as $value){
            $studentId=Student::find($value->student_id);
            $html= $html.' <option value="'.$studentId->id.'">'.$studentId->firstName.' '.$studentId->middleName.' '.$studentId->LastName. ' ID:'.$studentId->id.'</option>';
        }
        $html= $html.'</select>     
                    </div>
                </div>
            </div>';


        return json_encode($html);


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                $classFee = DB::table('class_rooms')
            ->join('fees', 'class_rooms.id', '=', 'fees.class_id')
            ->select('class_rooms.*')->where('fees.paid_status','=',0)->distinct()->pluck('class_rooms.name','class_rooms.id');

        $classFine = DB::table('class_rooms')
            ->join('fines', 'class_rooms.id', '=', 'fines.class_id')
            ->select('class_rooms.*')->where('fines.paid_status','=',0)->distinct()->pluck('class_rooms.name','class_rooms.id');


        $i=0;
        foreach($classFee as $key=>$value)
        {
            if($request->class_id==$key)
                $i=$i+1;
        }
        foreach($classFine as $key=>$value)
        {

            if($request->class_id==$key)
                $i=$i+1;
        }
       if($i==0){
           return redirect()->back()->withErrors(["This class does not have any fees or fines assigned so the bill cannot be published"]);

       }



        $student=ClassRoom::find($request->class_id)->student()->get();
        foreach ($student as $getStudent)
        {
            $bill=new Bill();

//['student_id', 'guardian_id', 'paid_status','status', 'staff_id', 'total_amount','due_amount','paid_amount','session_year','paid_date','issue_date','due_date'];
            $session=date('Y');
            $staff_id=Auth::guard('staff')->user()->id;
            $bill->issue_date=$request->issue_date;
            $bill->due_date=$request->due_date;
            $bill->staff_id=$staff_id;
            $bill->session_year=$session;
            $bill->status=1;
            $bill->student_id=$getStudent->id;

            $bill_due_amount=0;

            $due=Bill::all()->where('student_id','=',$getStudent->id)->where('due_amount','!=',0)->where('paid_status','=',1);
            foreach ($due as $getDue){
                $findBill=Bill::find($getDue->id);
                $bill_due_amount=$bill_due_amount+$findBill->due_amount;
                $findBill->due_amount=0;
                $findBill->save();
            }
            $bill->due_amount=$bill_due_amount;
            $bill->save();

//            dd($bill->id);
            $billTotalAmount=0;
            $fee=ClassRoom::find($request->class_id)->fee()->where('paid_status','=',0)->get();
//                        dd($fee);

            foreach ($fee as $getFee)
            {
                if($getFee->student_id!=null){
                    if($getFee->student_id==$getStudent->id){
                        $billTotalAmount=$billTotalAmount+$getFee->amount;
                    }
                }else{
                    $billTotalAmount=$billTotalAmount+$getFee->amount;

                }


                $bill_fee=DB::table('bill_fee');
                $bill_fee->insert(['bill_id'=>$bill->id,'fee_id'=>$getFee->id]);

            }
            $fine=ClassRoom::find($request->class_id)->fine()->where('paid_status','=',0)->get();
            foreach ($fine as $getFine)
            {
                if($getFine->student_id!=null){
                    if($getFine->student_id==$getStudent->id){
                        $billTotalAmount=$billTotalAmount+$getFine->amount;
                    }
                }else{
                    $billTotalAmount=$billTotalAmount+$getFine->amount;

                }
                $bill_fine=DB::table('bill_fine');
                $bill_fine->insert(['bill_id'=>$bill->id,'fine_id'=>$getFine->id]);
            }

            $discount=ClassRoom::find($request->class_id)->discount()->where('paid_status','=',0)->get();
            foreach ($discount as $getDiscount)
            {
                if($getDiscount->student_id!=null){

                    if($getDiscount->student_id==$getStudent->id){
                        $billTotalAmount=$billTotalAmount-$getDiscount->amount;

                    }
                }else{
                    $billTotalAmount=$billTotalAmount-$getDiscount->amount;

                }
                $bill_discount=DB::table('bill_discount');
                $bill_discount->insert(['bill_id'=>$bill->id,'discount_id'=>$getDiscount->id]);
            }
//            dd(intval($billTotalAmount));

//            $bill=Bill::find($bill->id);
            $bill->total_amount=intval($billTotalAmount);
            $bill->save();

        }
        $fee=ClassRoom::find($request->class_id)->fee()->where('paid_status','=',0)->get();
//                        dd($fee);

        foreach ($fee as $getFee)
        {
            $updateFee=Fee::find($getFee->id);
            $updateFee->paid_status=1;
            $updateFee->save();

        }

        $fine=ClassRoom::find($request->class_id)->fine()->where('paid_status','=',0)->get();
        foreach ($fine as $getFine)
        {
            $updateFine=Fine::find($getFine->id);
            $updateFine->paid_status=1;
            $updateFine->save();
        }
        $discount=ClassRoom::find($request->class_id)->discount()->where('paid_status','=',0)->get();
        foreach ($discount as $getDiscount)
        {
            $updateDiscount=Discount::find($getDiscount->id);
            $updateDiscount->paid_status=1;
            $updateDiscount->save();
        }
        return redirect('staff/bill');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
