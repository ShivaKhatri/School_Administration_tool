<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ExamDataTable;
use App\Model\ClassRoom;
use App\Model\Exam;
use App\Model\Section;
use App\Model\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExamDataTable $datable)
    {
        if (Auth::guard('staff')->check()) {
            return $datable->render('backend.exam.indexExam');
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
        if (Auth::guard('staff')->check()) {
            $subject=Subject::all();
            $class=ClassRoom::all();
            $section=Section::all();
            return view('backend.exam.createExam')->with('subject',$subject)->with('class',$class)->with('section',$section);
        }
        else
            return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->class);


        $this->validate($request,array(
            'name'=>'required|max:25',
            'from'=>'required',
            'to'=>'required|date|after:from',
            'resultDay'=>'required|date|after:to',
            'session_year'=>'required',
        ));

//                dd($request);
        $exam=new Exam();
        $exam->name=$request->name;
        $exam->description=$request->description;
        $exam->from=$request->from;
        $exam->to=$request->to;
        $exam->session_year=$request->session_year;
        $exam->resultDay=$request->resultDay;
        $exam->status=$request->status;

        $exam->save();
        $class_exam_sub=DB::table('class_exam_sub');
        foreach($request->classRoom as $get) {
//            dd($get);
            $subject='subject'.$get;
//            dd($request->subject10);
            $i=1;
            foreach($request->$subject as $data){
                $diff=$get.$data;
                $fullmarks='full_marks'.$diff;
                $passmarks='pass_marks'.$diff;
                $examDate='examDate'.$diff;
                $timeFrom='time_from'.$diff;
                $timeTo='time_to'.$diff;
//                dd($request);
                $class_exam_sub->insert([
                    ['exam_id' => $exam->id, 'class_id' => $get,'sub_id'=>$data,'full_marks'=>$request->$fullmarks,'pass_marks'=>$request->$passmarks,'time_from'=>$request->$timeFrom,'time_to'=>$request->$timeTo,'examDate'=>$request->$examDate,'session_year'=>date('Y')]
                ]);
            }

        }
        return redirect('staff/exam');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $class = DB::table('class_rooms')
            ->join('class_exam_sub', 'class_rooms.id', '=', 'class_exam_sub.class_id')
            ->select('class_rooms.*')->pluck('class_rooms.name','class_rooms.id')
        ;
        return view('backend.exam.showExam')->with('class',$class)->with('exam_id',$id);
    }
    public function exam($exam_id,$class)
    {



        $examSub = DB::table('class_exam_sub')->select('sub_id','time_from','time_to','examDate')->where('exam_id','=',$exam_id)->where('class_id','=',$class)->get();
        $examDetails=Exam::find($exam_id);
        $classDetails=ClassRoom::find($class);
        $html='
                        <!-- Main content -->
                        <section class="invoice" id="examRoutine" >
                            <!-- title row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="page-header">
                                        <i class="fa fa-globe"></i> Class: '.$classDetails->name.'
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="page-header">
                                        <i class="fa fa-globe"></i> Exam: '.$examDetails->name.'
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>From: '.$examDetails->from.'</strong><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>To: '.$examDetails->to.'</strong><br>
                                    </address>
                                </div>
                                <!-- /.col -->
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
                                            <th>Sub</th>
                                            <th>Exam Date</th>
                                            <th>Time From</th>
                                            <th>Time To</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
        $i=0;
        foreach ($examSub as $value){
            $i=$i+1;
            $subjectDetail=Subject::find($value->sub_id);
            $html= $html.'
                                        <tr>
                                            <td>'.$i.'</td>
                                            <td>'.$subjectDetail->name.'</td>
                                            <td>'.$value->examDate.'</td>
                                            <td>'.$value->time_from.'</td>
                                            <td>'.$value->time_to.'</td>
                                        </tr>';
        }
        $html= $html.'
                                         </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                        </section>
                      
                    ';


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

        $exam=Exam::find($id);
        $subject=Subject::all();
        $classRoom=ClassRoom::all();
        return view('backend.exam.editExam')->with('classRoom',$classRoom)->with('exam',$exam)->with('subject',$subject);
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
        $this->validate($request,array(
            'name'=>'required|max:25',
            'from'=>'required',
            'to'=>'required|date|after:from',
            'resultDay'=>'required|date|after:to',
            'session_year'=>'required',
        ));

//                dd($request->resultDay);
        $exam=Exam::find($id);
        $exam->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'from'=>$request->from,
            'to'=>$request->to,
            'resultDay'=>$request->resultDay,
            'session_year'=>$request->session_year,
            'status'=>$request->status
        ]);
        $class_exam_sub=DB::table('class_exam_sub');
        $class_exam_sub->where('exam_id','=',$id)->delete();

        foreach($request->classRoom as $get) {

//            dd($request);
            $subject='subject'.$get;
//            dd($request->subject10);
            foreach($request->$subject as $data){
                $diff=$get.$data;
                $fullmarks='full_marks'.$diff;
                $passmarks='pass_marks'.$diff;
                $examDate='examDate'.$diff;
                $timeFrom='time_from'.$diff;
                $timeTo='time_to'.$diff;
                $class_exam_sub->insert([
                    ['exam_id' => $exam->id, 'class_id' => $get,'sub_id'=>$data,'full_marks'=>$request->$fullmarks,'pass_marks'=>$request->$passmarks,'time_from'=>$request->$timeFrom,'time_to'=>$request->$timeTo,'examDate'=>$request->$examDate,'session_year'=>date('Y')]
                ]);
            }

        }
        return redirect('staff/exam');
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
                'success' => 'Record  not deleted!'
            ]);
        }

        Exam::destroy($id);

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Exam::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
