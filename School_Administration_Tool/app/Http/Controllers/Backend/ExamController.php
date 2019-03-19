<?php

namespace App\Http\Controllers\Backend;

use App\Model\ClassRoom;
use App\Model\Exam;
use App\Model\Section;
use App\Model\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.exam.indexExam');
    }


    public function tableData()
    {
        $exam = Exam::all();

        return DataTables::of($exam)
            ->addColumn('class', function ($exam) {
                $exam=Exam::find($exam->id)->classRoom()->get();
                $count=count($exam);
                $wow='<ol>';
                foreach($exam as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Class Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('subject', function ($exam) {
                $subject=Exam::find($exam->id)->subject()->get();
                $count=count($subject);
                $wow='<ol>';
                foreach($subject as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Subject Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($exam) {
                return '<a href="'.route('exam.edit',$exam->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('exam.destroy',$exam->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns([ 'class','subject', 'action'])
            ->make(true);

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
        foreach($request->class as $get) {
//            dd($get);
            $subject='subject'.$get;
//            dd($request->subject10);
            foreach($request->$subject as $data){
                $fullmarks='full_marks'.$data;
                $passmarks='pass_marks'.$data;
                $examDate='examDate'.$data;
                $timeFrom='time_from'.$data;
                $timeTo='time_to'.$data;
                $class_exam_sub->insert([
                    ['exam_id' => $exam->id, 'class_id' => $get,'sub_id'=>$data,'full_marks'=>$request->$fullmarks,'pass_marks'=>$request->$passmarks,'time_from'=>$request->$timeFrom,'time_to'=>$request->$timeTo,'examDate'=>$request->$examDate]
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
        $exam=Exam::find($id);
        $subject=Subject::all();
        $class=ClassRoom::all();
        return view('backend.exam.editExam')->with('class',$class)->with('exam',$exam)->with('subject',$subject);

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

        foreach($request->class as $get) {

//            dd($get);
            $subject='subject'.$get;
//            dd($request->subject10);
            foreach($request->$subject as $data){
                $fullmarks='full_marks'.$data;
                $passmarks='pass_marks'.$data;
                $examDate='examDate'.$data;
                $timeFrom='time_from'.$data;
                $timeTo='time_to'.$data;
                $class_exam_sub->insert([
                    ['exam_id' => $exam->id, 'class_id' => $get,'sub_id'=>$data,'full_marks'=>$request->$fullmarks,'pass_marks'=>$request->$passmarks,'time_from'=>$request->$timeFrom,'time_to'=>$request->$timeTo,'examDate'=>$request->$examDate]
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
            return redirect()->route('exam.index');
        }

        Exam::destroy($id);

        return redirect()->route('exam.index');
    }

    public function checkId($id)
    {
        $query = Exam::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
