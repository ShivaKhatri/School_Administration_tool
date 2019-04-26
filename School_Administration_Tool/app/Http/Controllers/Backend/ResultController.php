<?php

namespace App\Http\Controllers\Backend;

use App\Model\ClassRoom;
use App\Model\Exam;
use App\Model\Mark;
use App\Model\Result;
use App\Model\Section;
use App\Model\Subject;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function showResult()
    {
        $class = DB::table('class_rooms')
            ->join('class_exam_sub', 'class_rooms.id', '=', 'class_exam_sub.class_id')
            ->join('marks', 'marks.class_id', '=', 'class_exam_sub.class_id')
            ->select('class_rooms.*','marks.result')->where('marks.result','=',1)->distinct()->pluck('class_rooms.name','class_rooms.id')
        ;
//        result/2/1/2019/5/8:1

//        $class=2;
//        $section=1;
//        $session=2019;
//        $exam=5;
//        $student=8;


//        $id=2; $session=2019;

//dd($html);
        return view('backend.result.showResult')->with('class',$class);
    }

    //    classId+'/'+secID+'/'+session+'/'+examID+'/'+studentID
    public function result($class,$section,$session,$exam,$student)
    {


        $result=Result::query()->where('class_id','=',$class)->where('sec_id','=',$section)->where('exam_id','=',$exam)->where('session','=',$session)->where('published','=',1)->where('student_id','=',$student)->first();
//                dd($result);

        if($result==null){
            $html='<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Result has not been published yet.
              </div>';
            return json_encode($html);

        }
        $mark=DB::table('mark_student')->select('*')->where('mark_id','=',$result->mark_id)->where('student_id','=',$student)->get();
        $studentDetails=Student::find($student);
        $classDetails=ClassRoom::find($class);
        $examDetails=Exam::find($exam);
        if($section!=null)
            $sectionDetails=Section::find($section)->name;
        else
            $sectionDetails='';

        $html='<section class="invoice" id="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> Om Gyan Mandir Secondary School
                        <small class="pull-right">Date: '.date("d/m/Y").'</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col" id="printAddress">
                    <address>
                        <strong>'.$studentDetails->firstName.' '.$studentDetails->middleName.' '.$studentDetails->LastName.'</strong><br>
                        Class: '.$classDetails->name.'<br>
                        Section: '.$sectionDetails.'<br>
                        ID: '.$studentDetails->id.'<br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Exam: </b>'.$examDetails->name.'<br>
                    <b>Overall Grade</b> '.$result->grade.'<br>
                    <b>Grade Description:</b> '.$result->gradeDescription.'
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Subject</th>
                            <th>Full Mark</th>
                            <th>Pass Mark</th>
                            <th>Obtained Mark</th>
                            <th>Grade</th>
                            <th>Grade Description</th>
                        </tr>
                        </thead>
                        <tbody>';
        $i=0;
        foreach ($mark as $getMark){
            $i=$i+1;
            $subject=Subject::find($getMark->sub_id);
            $examSubMark=DB::table('class_exam_sub')->select('full_marks','pass_marks')
                ->where('class_id','=',$class)->where('exam_id','=',$exam)
                ->where('sub_id','=',$subject->id)->first();
            $obtainedSubMark=DB::table('mark_student')->select('mark')
                ->where('student_id','=',$student)->where('mark_id','=',$getMark->mark_id)
                ->where('sub_id','=',$subject->id)->first();

            $overAllPercentage=($obtainedSubMark->mark/$examSubMark->full_marks)*100;

            if($overAllPercentage>=1 AND $overAllPercentage<20){

                $grade='E';
                $gradeDescription='insufficient';
            }
            elseif($overAllPercentage>=20 AND $overAllPercentage<40){
                $grade='D';
                $gradeDescription='below average';
            }
            elseif($overAllPercentage>=40 AND $overAllPercentage<50){
                $grade='C';
                $gradeDescription='average';
            }
            elseif($overAllPercentage>=50 AND $overAllPercentage<60){
                $grade='C+';
                $gradeDescription='above average';
            }
            elseif($overAllPercentage>=60 AND $overAllPercentage<70){
                $grade='B';
                $gradeDescription='good';
            }
            elseif($overAllPercentage>=70 AND $overAllPercentage<80){
                $grade='B+';
                $gradeDescription='very good';
            }
            elseif($overAllPercentage>=80 AND $overAllPercentage<90){
                $grade='A';
                $gradeDescription='excellent';
            }
            elseif($overAllPercentage>=90){
                $grade='A+';
                $gradeDescription='outstanding';
            }
            else{
                $grade='N';
                $gradeDescription='Nill';
            }
            $html=$html.'
                               <tr>
                            <td>'.$i.'</td>
                            <td>'.$subject->name.'</td>
                            <td>'.$examSubMark->full_marks.'</td>
                            <td>'.$examSubMark->pass_marks.'</td>
                            <td>'.$obtainedSubMark->mark.'</td>
                            <td>'.$grade.'</td>
                            <td>'.$gradeDescription.'</td>
                        </tr>';

        }
        $html=$html.'            </tbody>
                    </table>
                </div>
            </div>
        </section>
                </div>
                </div>';
        return json_encode($html);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class = DB::table('class_rooms')
            ->join('class_exam_sub', 'class_rooms.id', '=', 'class_exam_sub.class_id')
            ->join('marks', 'marks.class_id', '=', 'class_exam_sub.class_id')
            ->select('class_rooms.*','marks.result')->where('marks.result','=',0)->distinct()->pluck('class_rooms.name','class_rooms.id');
//        $class=2; $section=1; $session=2019;



//dd($html);
        return view('backend.result.publishResult')->with('class',$class);

    }

    public function section($id)
    {
        $section = ClassRoom::find($id)->section()->pluck('name','id');
            $html='  <div id="sectionDetails"> <div class="col-md-4 col-sm-6 col-xs-12" style="margin-top:5px; margin-bottom: 5px;">
                    <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" >Section
                         </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                    <select name="section_id" class="form-control section_id" required><option value="">Select Section</option>';
            foreach ($section as $key=>$value){
                $html= $html.' <option value="'.$key.'">'.$value.'</option>';
            }
            $html= $html.'</select>     
                    </div>
                </div>
            </div>
            </div>';


        return json_encode($html);


    }

    public function student($class,$section,$session)
    {
        $student = DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('section_id','=',$section)->where('session_year','=',$session)->get();
        $html='  <div id="studentDetails"> <div class="col-md-6 col-sm-10 col-xs-12" style="margin-top:5px; margin-bottom: 5px;">
                    <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" >Student
                         </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                    <select name="student_id" class="form-control student_id" required><option value="">Select Student</option>';
        foreach ($student as $value){
            $studentId=Student::find($value->student_id);
            $html= $html.' <option value="'.$studentId->id.'">'.$studentId->firstName.' '.$studentId->middleName.' '.$studentId->LastName. ' ID:'.$studentId->id.'</option>';
        }
        $html= $html.'</select>     
                    </div>
                </div>
            </div>
            </div>';


        return json_encode($html);


    }
    public function exam($id,$session){
        $exam=DB::table('class_exam_sub')->select('exam_id')->where('class_id','=',$id)->where('session_year','=',$session)->distinct()->get();

        $html=' <div id="examDetails">  <div class="col-md-4 col-sm-6 col-xs-12" style="margin-top:5px; margin-bottom: 5px;">
                    <div class="form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" >Exam
                         </label>
                    <div class="col-md-9 col-sm-9 col-xs-12 ">
                    <select name="exam_id" class="form-control exam_id" required><option value="">Select Exam</option>';
        foreach ($exam as $value){
            $examValue=Exam::find($value->exam_id);

            $html= $html.' <option value="'.$examValue->id.'">'.$examValue->name.'</option>';
        }
        $html= $html.'</select>     
                    </div>
                </div>
            </div>
            </div>
        ';
//        dd($html);

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
        $session=$request->session_year;
        $class=$request->class_id;
        $exam=$request->exam_id;
        if($request->section_id){
            $section=$request->section_id;

            $Sname=Section::find($section);
            $mark=DB::table('marks')->select('id')->where('class_id','=',$class)->where('exam_id','=',$exam)->where('sec_id','=',$section)->where('session','=',$session)->first();
            if($mark==null){
                return redirect()->back()->withErrors(["Marks have not been given for this section".$Sname->name." Please submit the marks obtained by the students from this section in order to generate result"]);

            }
        }else{
            $Cname=ClassRoom::find($class);

            $mark=DB::table('marks')->select('id')->where('class_id','=',$class)->where('exam_id','=',$exam)->where('session','=',$session)->first();
            if($mark==null){
                return redirect()->back()->withErrors(["Marks have not been given for this Class".$Cname->name." Please submit the marks obtained by the students from this section in order to generate result"]);

            }
        }




        $students=DB::table('class_section_student')->select('student_id')->where('class_id','=',$class)->where('section_id','=',$section)->where('session_year','=',$session)->distinct()->get();
        foreach ($students as $getStudents){
            $obtainedMarks=DB::table('mark_student')->select('sub_id','mark')->where('mark_id','=',$mark->id)->where('student_id','=',$getStudents->student_id)->get();

            $totalPassMark=0;
            $totalFullMark=0;
            $totalObtainedMark=0;
            foreach ($obtainedMarks as $getSubMark){
                $examSubMark=DB::table('class_exam_sub')->select('full_marks','pass_marks')
                    ->where('class_id','=',$class)->where('exam_id','=',$exam)
                    ->where('sub_id','=',$getSubMark->sub_id)->first();
                $totalPassMark=$totalPassMark+$examSubMark->pass_marks;
                //calculating total pass marks.
                // first the variable is assigned value of 0 then in each loop it adds it self
                // where on each loop its value is assigned to the current passmark of the subject


                $totalFullMark=$totalFullMark+$examSubMark->full_marks;
                //calculating total pass marks.
                // first the variable is assigned value of 0 then in each loop it adds it self
                // where on each loop its value is assigned to the current passmark of the subject


                $totalObtainedMark=$totalObtainedMark+$getSubMark->mark;
                //calculating total pass marks.
                // first the variable is assigned value of 0 then in each loop it adds it self
                // where on each loop its value is assigned to the current passmark of the subject

            }
            $overAllPercentage=($totalObtainedMark/$totalFullMark)*100;
//            source: https://en.wikipedia.org/wiki/Academic_grading_in_Nepal
//            >= 90%	A+	outstanding	4.0
//            >=80% AND <90%	A	excellent	3.6
//            >=70% AND <80%	B+	very good	3.2
//            >=60% AND <70%	B	good	2.8
//            >=50% AND <60%	C+	above average	2.4
//            >=40% AND <50%	C	average	2.0
//            >=20% AND <40%	D	below average	1.6
//            >=1% AND <20%	E	insufficient	0.8
//            0	N	Nill
            $result=new Result();
            $result->class_id=$class;
            $result->session=$session;
            $result->exam_id=$exam;
            if($request->section_id){
                $result->sec_id=$section;

            }
            $result->mark_id=$mark->id;
            $result->student_id=$getStudents->student_id;
            $result->total_mark=$totalFullMark;
            $result->obtained_mark=$totalObtainedMark;
            $result->published=0;
            if($overAllPercentage>=1 AND $overAllPercentage<20){

                $grade='E';
                $gradeDescription='insufficient';

                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;


            }
            elseif($overAllPercentage>=20 AND $overAllPercentage<40){
                $grade='D';
                $gradeDescription='below average';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            elseif($overAllPercentage>=40 AND $overAllPercentage<50){
                $grade='C';
                $gradeDescription='average';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            elseif($overAllPercentage>=50 AND $overAllPercentage<60){
                $grade='C+';
                $gradeDescription='above average';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            elseif($overAllPercentage>=60 AND $overAllPercentage<70){
                $grade='B';
                $gradeDescription='good';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            elseif($overAllPercentage>=70 AND $overAllPercentage<80){
                $grade='B+';
                $gradeDescription='very good';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            elseif($overAllPercentage>=80 AND $overAllPercentage<90){
                $grade='A';
                $gradeDescription='excellent';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            elseif($overAllPercentage>=90){
                $grade='A+';
                $gradeDescription='outstanding';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
                }
            else{
                $grade='N';
                $gradeDescription='Nill';
                $result->grade=$grade;
                $result->gradeDescription=$gradeDescription;
            }
            $result->save();

        }
        $updateMarks=Mark::find($mark->id);
            $updateMarks->result=1;
        $updateMarks->save();
//        dd('this');

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
