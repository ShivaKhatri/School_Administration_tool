<?php

namespace App\Http\Controllers\Backend;

use App\Model\ClassRoom;
use App\Model\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ClassController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('backend.class.indexClass');

    }

    public function tableData()
    {
        $class = ClassRoom::all();

        return DataTables::of($class)
            ->addColumn('section', function ($class) {
                $sec=ClassRoom::find($class->id)->section()->get();
                $count=count($sec);
                $wow='<ol>';
                foreach($sec as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Section Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($class) {
                return '<a href="'.route('class.edit',$class->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="#edit-'.$class->id.'" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->editColumn('id', '{{$id}}')
            ->rawColumns(['section', 'action'])
            ->make(true)
            ;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('staff')->check()) {
            $section=Section::all();
            return view('backend.class.createClass')->with('section',$section);
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
//        dd($request->section);
        $class=new ClassRoom();
        $class->name=$request->name;
        $class->description=$request->description;
        $class->save();
        $class_section=DB::table('classroom_section');
        foreach($request->section as $get) {
//            dd($get);
            $class_section->insert([
                ['class_id' => $class->id, 'sec_id' => $get]
            ]);
        }
        return redirect('staff/class');
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
        $class=ClassRoom::find($id);
        $section=Section::all();
        return view('backend.class.editClass')->with('class',$class)->with('section',$section);
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
//        dd($request->description);
        $class=ClassRoom::find($id);
        $class->update([
            'name'=>$request->name,
//            'updated_at'=>Carbon::now('asia/kathmandu'),
            'description'=>$request->description

        ]);
        $class_section=DB::table('classroom_section');
        $class_section->where('class_id','=',$id)->delete();
        foreach($request->section as $get) {
//            dd($id);
            $class_section->insert(['class_id' => $id, 'sec_id' => $get]);
        }
        return redirect('staff/class');
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
