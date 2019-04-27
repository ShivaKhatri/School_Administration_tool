<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FineDataTable;
use App\Model\ClassRoom;
use App\Model\Fine;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FineDataTable $section)
    {

        return  $section->render('backend.fine.indexFine');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class=ClassRoom::all()->pluck('name','id');
        return view('backend.fine.createFine')->with('class',$class);

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
    public function studentEdit($use,$class)
    {
        $fee=Fine::find($use);
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
            if($fee->student_id==$value->student_id)
                $html= $html.' <option value="'.$studentId->id.'" selected>'.$studentId->firstName.' '.$studentId->middleName.' '.$studentId->LastName. ' ID:'.$studentId->id.'</option>';
            else
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
//['class_id', 'student_id', 'paid_status', 'staff_id', 'amount','description','session_year','name'];

        $session_year=date('Y');
        $staff_id=Auth::guard('staff')->user()->id;
        $fee=new Fine();
        $fee->class_id=$request->class_id;
        $fee->staff_id=$staff_id;
        $fee->session_year=$session_year;
        $fee->paid_status=0;
        $fee->amount=$request->amount;
        $fee->name=$request->name;
        $fee->description=$request->description;
        if($request->student_id)
            $fee->student_id=$request->student_id;
        $fee->save();
        return redirect('staff/fine');


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
        $fee=Fine::find($id);
        $class=ClassRoom::all()->pluck('name','id');
        return view('backend.fine.editFine')->with('class',$class)->with('fine',$fee);
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
        $session_year=date('Y');
        $staff_id=Auth::guard('staff')->user()->id;
        $fee=Fine::find($id);
        $fee->class_id=$request->class_id;
        $fee->staff_id=$staff_id;
        $fee->session_year=$session_year;
        $fee->paid_status=0;
        $fee->amount=$request->amount;
        $fee->name=$request->name;
        $fee->description=$request->description;
        if($request->student_id)
            $fee->student_id=$request->student_id;
        $fee->save();
        return redirect('staff/fine');

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
