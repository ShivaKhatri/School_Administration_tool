<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubjectDataTable;
use App\Model\ClassRoom;
use App\Model\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubjectDataTable $subjects)
    {
//        dd(Auth::guard('staff')->user()->name);
        if (Auth::guard('staff')->check()) {
            return $subjects->render('backend.subject.indexSubject');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class=ClassRoom::all();

            return view('backend.subject.createSubject')->with('class',$class);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject=new Subject();
        $subject->name=$request->name;
        $subject->description=$request->description;
        $subject->save();

        $class_subject=DB::table('classroom_subject');
        if(!($request->classRoom==null)) {//if class are selected to a subject then this will execute
            foreach($request->classRoom as $get) {//loops until the last class
//            dd($id);
                $class_subject->insert(['class_id' => $get, 'sub_id' => $subject->id]);//inserts class id and section id into the normalised many to many relationship table

            }
        }
        else{//if no classes are selected fo the subject then this will execute
            return redirect('staff/subject');//return to the subjects index page
        }
        return redirect('staff/subject');
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
        $subject=Subject::find($id);
        $classRoom=ClassRoom::all();
        return view('backend.subject.editSubject')->with('subject',$subject)->with('classRoom',$classRoom);
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
        $subject=Subject::find($id);
        $subject->update([
            'name'=>$request->name,
//            'updated_at'=>Carbon::now('asia/kathmandu'),
            'description'=>$request->description

        ]);
        $class_subject=DB::table('classroom_subject');
        $class_subject->where('sub_id','=',$id)->delete();
        if($request->classRoom) {
            foreach($request->classRoom as $get) {
//            dd($id);
                $class_subject->insert(['class_id' => $get, 'sub_id' => $id]);

            }
        }
        else{
            return redirect('staff/subject');
        }
        return redirect('staff/subject');

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
            return redirect()->route('subject.index');
        }
        $class_subject=DB::table('classroom_subject');
        $class_subject->where('sub_id','=',$id)->delete();
        Subject::destroy($id);

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Subject::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
