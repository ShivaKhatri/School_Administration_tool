<?php

namespace App\Http\Controllers\Backend;

use App\Model\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\DataTables\SectionsDataTable;
class SectionController extends Controller
{
    protected $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        return view('backend.section.indexSection');
//    }

    public function index(SectionsDataTable $dataTable)

    {
//        dd(Auth::guard('staff')->user()->name);
        if (Auth::guard('staff')->check()) {
            return $dataTable->render('backend.section.indexSection');

        }

    }

    public function tableData()
    {
        $section = DB::table('sections')
            ->select(['id', 'name', 'description', 'created_at', 'updated_at']);

        return Datatables::of($section)
            ->addColumn('action', function ($section) {
                return '<a href="'.route('section.edit',$section->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('section.destroy',$section->id).'" class="btn btn-sm btn-danger" id="delete"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')

            ->make(true)
            ;

    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('staff')->check()) {
            return view('backend.section.createSection');
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
        $section=new Section();
        $section->name=$request->name;
        $section->description=$request->description;
        $section->save();
        return redirect('staff/section');
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
        $section=Section::find($id);
        return view('backend.section.editSection')->with('section',$section);
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
        $section=Section::find($id);
        $section->update([
           'name'=>$request->name,
//            'updated_at'=>Carbon::now('asia/kathmandu'),
        'description'=>$request->description

        ]);
        return redirect('staff/section');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd('here');
        if (!$this->checkId($id)) {
            return redirect()->route('section.index');
        }
        $class_section=DB::table('classroom_section');
        $class_section->where('sec_id','=',$id)->delete();

            Section::destroy($id);

        return 'success';
    }

    public function checkId($id)
    {
        $query = Section::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

}



