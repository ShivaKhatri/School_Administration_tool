<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\MarkDataTable;
use App\Model\Attendance;
use App\Model\Exam;
use App\Model\Mark;
use App\Model\Subject;
use App\Staff;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MarkDataTable $datable)
    {
        if (Auth::guard('staff')->check()) {
            return $datable->render('backend.mark.indexMark');
        }
        else
            return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $session=date('Y');
        $date=date('Y-m-d');
        $exam=Exam::query()->select('*')->where('to','<=',$date)->where('status','=',1)->where('session_year','=',$session)->pluck('name','id');

        return view('backend.mark.giveMark')->with('exam',$exam);
//        $id=1;

//        dd($html);


    }
    public function giveMark($id)
    {
        $session=date('Y');
        $class=Auth::guard('staff')->user()->classTeacher_id;
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            $section=Auth::guard('staff')->user()->sectionTeacher_id;
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('section_id','=',$section)->where('session','=',$session)->where('exam_id','=',$id);
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->where('section_id','=',$section)->get();

        }else{
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->get();
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('session','=',$session)->where('exam_id','=',$id);

        }

        $examSubject =DB::table('class_exam_sub')->select('sub_id')->where('class_id','=',$class)->where('exam_id','=',$id)->where('result','=',0)->get();
//        dd($attendance);
        $html='<div id="getMark">';
        foreach($student as $getStudent){
            $studentDetail=Student::find($getStudent->student_id);
            $html=$html.'<div class="col-md-6 col-sm-6 col-xs">
                        <div class="box box-primary box-success box-solid box-comments">
                            <div class="box-header with-border">
                                <h3 class="box-title">Name: '.$studentDetail->firstName.' '. $studentDetail->middleName.' '.$studentDetail->LastName.'ID: '.$studentDetail->id.'</h3>
                            </div>
                            <div class="box-body">';
            foreach ($examSubject as $getSubject){
                $subjectDetail=Subject::find($getSubject->sub_id);
                foreach ($attendance as $getAttendace){
                    $attendanceExam=DB::table('attendance_students')->select('present')->where('student_id','=',$studentDetail->id)->where('sub_id','=',$getSubject->sub_id)->where('attendance_id','=',$getAttendace->id)->first();
//                   dd($getAttendace->id);
                    if($attendanceExam){
                        if($attendanceExam->present==1){
                            $html=$html.' <div class="form-group col-md-4 col-sm-4 col-xs-12">

                                    <label class="control-label" style="margin-left: 15px;">'.$subjectDetail->name.'<span class="required" >*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="SubjectId" value="'.$getSubject->sub_id.'" hidden>
                                        <input name="mark'.$getSubject->sub_id.$getStudent->student_id.'" type="text" class="form-control" minLength="1" maxLength="3" required>
                                    </div>
                                </div>';
                        }
                        else{
                            $html=$html.' <div class="form-group col-md-4 col-sm-4 col-xs-12">

                                    <label class="control-label" style="margin-left: 15px;">'.$subjectDetail->name.'<span class="required" >*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="SubjectId" value="'.$getSubject->sub_id.'" hidden>
                                        <input name="mark'.$getSubject->sub_id.$getStudent->student_id.'" type="text" class="form-control" value="A" readonly="readonly">
                                    </div>
                                </div>';
                        }

                    }







                }

            }
            $html=$html.'       </div>

                        </div>
                    </div>';

        }
        $html=$html.'</div>';
        return json_encode($html);
    }
    public function editGiveMark($use,$id)
    {
        $session=date('Y');
        $class=Auth::guard('staff')->user()->classTeacher_id;
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            $section=Auth::guard('staff')->user()->sectionTeacher_id;
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('section_id','=',$section)->where('session','=',$session)->where('exam_id','=',$id);
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->where('section_id','=',$section)->get();

        }else{
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->get();
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('session','=',$session)->where('exam_id','=',$id);

        }

        $examSubject =DB::table('class_exam_sub')->select('sub_id')->where('class_id','=',$class)->where('exam_id','=',$id)->where('result','=',0)->get();
//        dd($attendance);
        $html='<div id="getMark">';
        foreach($student as $getStudent){
            $studentDetail=Student::find($getStudent->student_id);
            $html=$html.'<div class="col-md-6 col-sm-6 col-xs">
                        <div class="box box-primary box-success box-solid box-comments">
                            <div class="box-header with-border">
                                <h3 class="box-title">Name: '.$studentDetail->firstName.' '. $studentDetail->middleName.' '.$studentDetail->LastName.'ID: '.$studentDetail->id.'</h3>
                            </div>
                            <div class="box-body">';
            foreach ($examSubject as $getSubject){
                $subjectDetail=Subject::find($getSubject->sub_id);
                foreach ($attendance as $getAttendace){
                    $attendanceExam=DB::table('attendance_students')->select('present')->where('student_id','=',$studentDetail->id)->where('sub_id','=',$getSubject->sub_id)->where('attendance_id','=',$getAttendace->id)->first();
//                   dd($getAttendace->id);
                    if($attendanceExam){
                        if($attendanceExam->present==1){

                            $markObtained=DB::table('mark_student')->select('mark')->where('student_id','=',$studentDetail->id)->where('sub_id','=',$getSubject->sub_id)->where('mark_id','=',$use)->first();
                            $html=$html.' <div class="form-group col-md-4 col-sm-4 col-xs-12">

                                    <label class="control-label" style="margin-left: 15px;">'.$subjectDetail->name.'<span class="required" >*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="SubjectId" value="'.$getSubject->sub_id.'" hidden>
                                        <input name="mark'.$getSubject->sub_id.$getStudent->student_id.'" type="text" class="form-control" minLength="1" maxLength="3" value="'.$markObtained->mark.'" required>
                                    </div>
                                </div>';
                        }
                        else{
                            $html=$html.' <div class="form-group col-md-4 col-sm-4 col-xs-12">

                                    <label class="control-label" style="margin-left: 15px;">'.$subjectDetail->name.'<span class="required" >*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="SubjectId" value="'.$getSubject->sub_id.'" hidden>
                                        <input name="mark'.$getSubject->sub_id.$getStudent->student_id.'" type="text" class="form-control" value="A" readonly="readonly">
                                    </div>
                                </div>';
                        }

                    }







                }

            }
            $html=$html.'       </div>

                        </div>
                    </div>';

        }
        $html=$html.'</div>';
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
        $giveMark=Mark::all();
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            foreach ($giveMark as $value){
                if($request->exam_id==$value->exam_id&&$value->class_id==Auth::guard('staff')->user()->classTeacher_id&&$value->sec_id==Auth::guard('staff')->user()->secTeacher_id){
                    return redirect()->back()->withErrors(["Marks  Already Given For This Exam. Check Marks Details With ID: ".$value->id]);

                }
            }
        }else{
            foreach ($giveMark as $value){
                if($request->exam_id==$value->exam_id&&$value->class_id==Auth::guard('staff')->user()->classTeacher_id){
                    return redirect()->back()->withErrors(["Marks  Already Given For This Exam. Check Marks Details With ID: ".$value->id]);

                }
            }
        }

        $session=date('Y');

        $mark=new Mark();
        $mark->class_id=Auth::guard('staff')->user()->classTeacher_id;
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            $mark->sec_id=Auth::guard('staff')->user()->sectionTeacher_id;

        }
        $mark->exam_id=$request->exam_id;
        $mark->date=date('Y-m-d');
        $mark->staff_id=Auth::guard('staff')->user()->id;
        $mark->session=date('Y');
        $mark->save();



        $class=Auth::guard('staff')->user()->classTeacher_id;
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            $section=Auth::guard('staff')->user()->sectionTeacher_id;
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('section_id','=',$section)->where('session','=',$session)->where('exam_id','=',$request->exam_id);
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->where('section_id','=',$section)->get();

        }else{
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->get();
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('session','=',$session)->where('exam_id','=',$request->exam_id);

        }

        $examSubject =DB::table('class_exam_sub')->select('sub_id')->where('class_id','=',$class)->where('exam_id','=',$request->exam_id)->where('result','=',0)->get();
//        dd($attendance);
        $mark_student =DB::table('mark_student');

        foreach($student as $getStudent){
            $studentDetail=Student::find($getStudent->student_id);

            foreach ($examSubject as $getSubject){
                $subjectDetail=Subject::find($getSubject->sub_id);
                $name='mark'.$getSubject->sub_id.$getStudent->student_id;
                foreach ($attendance as $getAttendace){
                    $attendanceExam=DB::table('attendance_students')->select('present')->where('student_id','=',$studentDetail->id)->where('sub_id','=',$getSubject->sub_id)->where('attendance_id','=',$getAttendace->id)->first();
//                   dd($getAttendace->id);
                    if($attendanceExam){
                        if($attendanceExam->present==1){

                            $mark_student->insert([
                                ['student_id' => $getStudent->student_id,'sub_id' => $getSubject->sub_id,'mark_id' => $mark->id,'mark' =>$request->$name,]
                            ]);
                        }
                        else{
                            $mark_student->insert([
                                ['student_id' => $getStudent->student_id,'sub_id' => $getSubject->sub_id,'mark_id' => $mark->id]
                            ]);
                        }

                    }

                }

            }

        }
        return redirect('staff/mark')->with('message','Marks Recorded Successfully');

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
        $session=date('Y');
        $date=date('Y-m-d');
        $exam=Exam::query()->select('*')->where('to','<=',$date)->where('status','=',1)->where('session_year','=',$session)->pluck('name','id');
        $mark=Mark::find($id);
        return view('backend.mark.editGivenMark')->with('exam',$exam)->with('mark',$mark);
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
        $giveMark=Mark::all();

        if(Auth::guard('staff')->user()->sectionTeacher_id){
            foreach ($giveMark as $value){
                if($request->exam_id==$value->exam_id&&$value->class_id==Auth::guard('staff')->user()->classTeacher_id&&$value->sec_id==Auth::guard('staff')->user()->sectionTeacher_id&&$value->id!=$id){
                    return redirect()->back()->withErrors(["Marks  Already Given For This Exam. Check Marks Details With ID: ".$value->id]);

                }
            }
        }else{
            foreach ($giveMark as $value){
                if($request->exam_id==$value->exam_id&&$value->class_id==Auth::guard('staff')->user()->classTeacher_id&&$value->id!=$id){
                    return redirect()->back()->withErrors(["Marks  Already Given For This Exam. Check Marks Details With ID: ".$value->id]);

                }
            }
        }

        $session=date('Y');

        $mark=Mark::find($id);
        $mark->class_id=Auth::guard('staff')->user()->classTeacher_id;
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            $mark->sec_id=Auth::guard('staff')->user()->sectionTeacher_id;

        }
        $mark->exam_id=$request->exam_id;
        $mark->date=date('Y-m-d');
        $mark->staff_id=Auth::guard('staff')->user()->id;
        $mark->session=date('Y');
        $mark->save();



        $class=Auth::guard('staff')->user()->classTeacher_id;
        if(Auth::guard('staff')->user()->sectionTeacher_id){
            $section=Auth::guard('staff')->user()->sectionTeacher_id;
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('section_id','=',$section)->where('session','=',$session)->where('exam_id','=',$request->exam_id);
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->where('section_id','=',$section)->get();

        }else{
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('session_year','=',$session)->get();
            $attendance=Attendance::all()->where('staff_id','=',Auth::guard('staff')->user()->id)->where('class_id','=',$class)->where('session','=',$session)->where('exam_id','=',$request->exam_id);

        }

        $examSubject =DB::table('class_exam_sub')->select('sub_id')->where('class_id','=',$class)->where('exam_id','=',$request->exam_id)->where('result','=',0)->get();
//        dd($attendance);
        $mark_student =DB::table('mark_student');
        $mark_student->where('mark_id','=',$id)->delete();
        foreach($student as $getStudent){
            $studentDetail=Student::find($getStudent->student_id);

            foreach ($examSubject as $getSubject){
                $subjectDetail=Subject::find($getSubject->sub_id);
                $name='mark'.$getSubject->sub_id.$getStudent->student_id;
                foreach ($attendance as $getAttendace){
                    $attendanceExam=DB::table('attendance_students')->select('present')->where('student_id','=',$studentDetail->id)->where('sub_id','=',$getSubject->sub_id)->where('attendance_id','=',$getAttendace->id)->first();
//                   dd($getAttendace->id);
                    if($attendanceExam){
                        if($attendanceExam->present==1){



                            $mark_student->insert([
                                ['student_id' => $getStudent->student_id,'sub_id' => $getSubject->sub_id,'mark_id' => $mark->id,'mark' =>$request->$name,]
                            ]);
                        }
                        else{

                            $mark_student->insert([
                                ['student_id' => $getStudent->student_id,'sub_id' => $getSubject->sub_id,'mark_id' => $mark->id]
                            ]);
                        }

                    }

                }

            }

        }
        return redirect('staff/mark')->with('message','Marks Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkId($id)) {
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
        $mark_student =DB::table('mark_student');

        $mark_student->where('mark_id','=',$id)->delete();
        Mark::destroy($id);

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Attendance::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
