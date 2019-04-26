<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AttendanceDataTable;
use App\Model\Attendance;
use App\Model\AttendanceStudent;
use App\Model\ClassRoom;
use App\Model\Exam;
use App\Model\Section;
use App\Model\Subject;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttendanceDataTable $section)
    {
        return  $section->render('backend.attendance.indexAttendance');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session=date('Y');
        $attendance=ClassRoom::find(Auth::guard('staff')->user()->classTeacher_id);
        $section=Section::find(Auth::guard('staff')->user()->sectionTeacher_id);

        if(Auth::guard('staff')->user()->sectionTeacher_id==null){
            $student=DB::table('class_section_student')->where('class_id','=',$attendance->id)->where('session_year','=',$session)->get();
        }
        else{
            //select student_id  from class_section_student where class_section_student.class_id equals to
            // attendance.class_id and  class_section_student.section_id equals to attendance.section_id
            // and class_section_student.session_year equals to current session year
            $student=DB::table('class_section_student')
                ->select('student_id')
                ->where('class_id','=',$attendance->id)
                ->where('section_id','=',$section->id)
                ->where('session_year','=',$session)
                ->distinct()->get();
        }
//        dd($student);
//        dd($student);
        $examAll=DB::table('class_exam_sub')->select('exam_id')->where('session_year','=',$session)->where('class_id','=',$attendance->id)->distinct()->get();
//        dd($examAll);
        $arrayExam[0]=[];
        $i=0;
        foreach($examAll as $get){
            $i=$i+1;
            $examGet=Exam::find($get->exam_id);
            $arrayExam[$i]=$examGet;
        }
//dd($arrayExam);
        $arrayStudent[0]=[];
        $j=0;
        foreach($student as $getStudent){
            $j=$j+1;
            $studentGet=Student::find($getStudent->student_id);
            $arrayStudent[$j]=$studentGet;
        }
//        dd($arrayStudent);
        return view('backend.attendance.takeAttendance')->with('arrayStudent',$arrayStudent)->with('arrayExam',$arrayExam);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkDate=Attendance::all();


        if($request->typeExam=='exam'){
            foreach ($checkDate as $value){

                if($value->date==$request->attendance_date&&$value->staff_id==Auth::guard('staff')->user()->id){
                    $sub=DB::table('attendance_students')->select('sub_id')->where('attendance_id','=',$value->id)->distinct()->get();
                    foreach($sub as $getSub){
                        if($request->subject_id==$getSub->sub_id){
                            return redirect()->back()->withErrors(["Attendance Already Taken For this subject today. Check Attendance With ID: ".$value->id]);

                        }
                    }

                }
            }
        }
        else{
            foreach ($checkDate as $value){
                if($value->date==$request->attendance_date&&$value->staff_id==Auth::guard('staff')->user()->id){
                    return redirect()->back()->withErrors(["Attendance Already Taken For today. Check Attendance With ID: ".$value->id]);

                }
            }
        }


        $attendance=new Attendance();
        $attendance->section_id=Auth::guard('staff')->user()->sectionTeacher_id;
        $attendance->class_id=Auth::guard('staff')->user()->classTeacher_id;
        $attendance->staff_id=Auth::guard('staff')->user()->id;
        $attendance->date=$request->attendance_date;
        $attendance->session=date('Y');
//        dd($request->exam);
        if($request->typeExam=='exam'){
            $attendance->exam_id=$request->exam;

        }
        $attendance->save();

        $session=date('Y');
        $class=ClassRoom::find(Auth::guard('staff')->user()->classTeacher_id);
        $section=Section::find(Auth::guard('staff')->user()->sectionTeacher_id);

        if(Auth::guard('staff')->user()->sectionTeacher_id==null){
            $student=DB::table('class_section_student')->where('class_id','=',$class->id)->where('session_year','=',$session)->get();
        }
        else{
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class->id)->where('section_id','=',$section->id)->where('session_year','=',$session)->distinct()->get();
        }
        $attendance_students=DB::table('attendance_students');
        foreach($student as $getStudent){
            $name='student'.$getStudent->student_id;
            if($request->present=="all"){
                if($request->typeExam=='exam'){
                    $attendance_students->insert([
                        ['sub_id' => $request->subject_id, 'student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }else{
                    $attendance_students->insert([
                        ['student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }

            }
            elseif($request->$name){
                if($request->typeExam=='exam'){
                    $attendance_students->insert([
                        ['sub_id' => $request->subject_id,'student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }else{
                    $attendance_students->insert([
                        ['student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }

            }
            else{
                if($request->typeExam=='exam'){
                    $attendance_students->insert([
                        ['sub_id' => $request->subject_id,'student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 0]
                    ]);
                }else{
                    $attendance_students->insert([
                        ['student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 0]
                    ]);
                }

            }

        }
        return redirect('staff/attendance');
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
    public function subject($id)
    {
        $class=Auth::guard('staff')->user()->classTeacher_id;
        $examSubject =DB::table('class_exam_sub')->select('sub_id')->where('class_id','=',$class)->where('exam_id','=',$id)->where('result','=',0)->get();
        $html='<div id="attendanceGet" class="col-md-5 col-sm-5 col-sm-6">
                <label for="type" class="control-label" style="margin-right: 10px;">Subjects</label>
                <select class="form-control" name="subject_id" ><option>Select Subject</option>';
        $i=0;
        foreach($examSubject as $getSubject){
            $subject=Subject::find($getSubject->sub_id);
                $html=$html.' <option value="'.$subject->id.'">'.$subject->name.'</option>';

            $i=$i+1;
        }
        $html=$html.'</select>
            </div>';
        return json_encode($html);

    }
    public function subjectEdit($use,$id)
    {
        $class=Auth::guard('staff')->user()->classTeacher_id;
        $examSubject =DB::table('class_exam_sub')->select('sub_id')->where('class_id','=',$class)->where('exam_id','=',$id)->where('result','=',0)->get();
        $html='<div id="attendanceGet" class="col-md-5 col-sm-5 col-sm-6">
                <label for="type" class="control-label" style="margin-right: 10px;">Subjects</label>
                <select class="form-control" name="subject_id" ><option>Select Subject</option>';
        $i=0;
        foreach($examSubject as $getSubject){
            $subject=Subject::find($getSubject->sub_id);
            $html=$html.' <option value="'.$subject->id.'">'.$subject->name.'</option>';

            $i=$i+1;
        }
        $html=$html.'</select>
            </div>';
        return json_encode($html);
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
        $attendance=ClassRoom::find(Auth::guard('staff')->user()->classTeacher_id);
        $section=Section::find(Auth::guard('staff')->user()->sectionTeacher_id);

        if(Auth::guard('staff')->user()->sectionTeacher_id==null){
            $student=DB::table('class_section_student')->where('class_id','=',$attendance->id)->where('session_year','=',$session)->get();
        }
        else{
            //select student_id and present from class_section_student where class_section_student.class_id equals to
            // attendance.class_id and  class_section_student.section_id equals to attendance.section_id
            // and class_section_student.session_year equals to current session year
            $student=DB::table('class_section_student')
                ->select('student_id')
                ->where('class_id','=',$attendance->id)
                ->where('section_id','=',$section->id)
                ->where('session_year','=',$session)
                ->distinct()->get();
        }
//        dd($student);
//        dd($student);
        $examAll=DB::table('class_exam_sub')->select('exam_id')->where('session_year','=',$session)->where('class_id','=',$attendance->id)->distinct()->get();
//        dd($examAll);
        $arrayExam[0]=[];
        $i=0;
        foreach($examAll as $get){
            $i=$i+1;
            $examGet=Exam::find($get->exam_id);
            $arrayExam[$i]=$examGet;
        }
//dd($arrayExam);
        $arrayStudent[0]=[];
        $status[0]=[];
        $j=0;
        foreach($student as $getStudent){
            $j=$j+1;
            $presentStatus=AttendanceStudent::all()->where('attendance_id','=',$id)->where('student_id','=',$getStudent->student_id)->first();
            $status[$j]=$presentStatus;
            $studentGet=Student::find($getStudent->student_id);
            $arrayStudent[$j]=$studentGet;
        }
//dd($status);
        $count1=DB::table('attendance_students')->select('student_id')->where('attendance_id','=',$id)->where('present','=',1)->count('student_id');
        $studentcount=DB::table('class_section_student')
            ->select('student_id')
            ->where('class_id','=',$attendance->id)
            ->where('section_id','=',$section->id)
            ->where('session_year','=',$session)
            ->count('student_id');
        if($count1==$studentcount){
            $all=true;
        }
        else
            $all=false;
        $data=Attendance::find($id);
        return view('backend.attendance.editAttendance')->with('all',$all)->with('present',$status)->with('attendance',$data)->with('arrayStudent',$arrayStudent)->with('arrayExam',$arrayExam);


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
        $checkDate=Attendance::all();

        if($request->typeExam=='exam'){
            foreach ($checkDate as $value){

                if($value->date==$request->attendance_date&&$value->staff_id==Auth::guard('staff')->user()->id&& $value->id!=$id){
                    $sub=DB::table('attendance_students')->select('sub_id')->where('attendance_id','=',$value->id)->distinct()->get();
                    foreach($sub as $getSub){
                        if($request->subject_id==$getSub->sub_id){
                            return redirect()->back()->withErrors(["Attendance Already Taken For this subject today. Check Attendance With ID: ".$value->id]);

                        }
                    }

                }
            }
        }
        else{
            foreach ($checkDate as $value){
                if($value->date==$request->attendance_date&&$value->staff_id==Auth::guard('staff')->user()->id&& $value->id!=$id){
                    return redirect()->back()->withErrors(["Attendance Already Taken For today. Check Attendance With ID: ".$value->id]);

                }
            }
        }
        $attendance=Attendance::find($id);
        $attendance->section_id=Auth::guard('staff')->user()->sectionTeacher_id;
        $attendance->class_id=Auth::guard('staff')->user()->classTeacher_id;
        $attendance->staff_id=Auth::guard('staff')->user()->id;
        $attendance->date=$request->attendance_date;
        $attendance->session=date('Y');
//        dd($request->exam);
        if($request->exam!=null)
            $attendance->exam_id=$request->exam;
        $attendance->save();

        $session=date('Y');
        $class=ClassRoom::find(Auth::guard('staff')->user()->classTeacher_id);
        $section=Section::find(Auth::guard('staff')->user()->sectionTeacher_id);

        if(Auth::guard('staff')->user()->sectionTeacher_id==null){
            $student=DB::table('class_section_student')->where('class_id','=',$class->id)->where('session_year','=',$session)->get();
        }
        else{
            $student=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class->id)->where('section_id','=',$section->id)->where('session_year','=',$session)->distinct()->get();
        }
        $attendance_students=DB::table('attendance_students');
        $attendance_students->where('attendance_id','=',$id)->delete();
        foreach($student as $getStudent){
            $name='student'.$getStudent->student_id;
            if($request->present=="all"){
                if($request->typeExam=='exam'){
                    $attendance_students->insert([
                        ['sub_id' => $request->subject_id, 'student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }else{
                    $attendance_students->insert([
                        ['student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }

            }
            elseif($request->$name){
                if($request->typeExam=='exam'){
                    $attendance_students->insert([
                        ['sub_id' => $request->subject_id,'student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }else{
                    $attendance_students->insert([
                        ['student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 1]
                    ]);
                }

            }
            else{
                if($request->typeExam=='exam'){
                    $attendance_students->insert([
                        ['sub_id' => $request->subject_id,'student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 0]
                    ]);
                }else{
                    $attendance_students->insert([
                        ['student_id' => $getStudent->student_id, 'attendance_id' => $attendance->id, 'present' => 0]
                    ]);
                }

            }

        }
        return redirect('staff/attendance');
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
        $attendance_students=DB::table('attendance_students');
        $attendance_students->where('attendance_id','=',$id)->delete();
        Attendance::destroy($id);

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
