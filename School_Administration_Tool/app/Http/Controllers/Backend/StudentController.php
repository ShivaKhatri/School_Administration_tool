<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\StudentsDataTable;
use App\Guardian;
use App\Model\ClassRoom;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StudentsDataTable $students)

    {
//        dd(Auth::guard('staff')->user()->name);
        if (Auth::guard('staff')->check()) {
            return $students->render('backend.student.indexStudent');
        }

    }

    public function tableData()
    {
        $student = DB::table('students')
            ->select(['id', 'name', 'email', 'created_at', 'updated_at']);

        return DataTables::of($student)
            ->addColumn('action', function ($student) {
                return '<a href="'.route('student.edit',$student->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="#edit-'.$student->id.'" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')

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
        $class=ClassRoom::all()->pluck('name','id');

        return view('student.auth.register')->with('class',$class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student=new Student();
        $student->firstName=$request->firstName;
        $student->middleName=$request->middleName;
        $student->lastName=$request->lastName;
        $student->email=$request->email;
        $student->gender=$request->gender;
        $student->dob=$request->dob;
        $student->address=$request->address;
//        $student->profilePic=$request->profilePic;
        $student->remark=$request->remarks;
        $student->mobile_no=$request->mobile_no;
        $student->phone_no=$request->phone_no;
        $student->password=bcrypt($request->password);
        $student->save();
        if (!file_exists(public_path() . '/images/staffProfilePic/')) {
            mkdir(public_path() . '/images/staffProfilePic/');
        }
        if ($request->profilePic) {
            $file = $request->file('profilePic');
            $file_name = rand(1857, 9899) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/staffProfilePic/', $file_name);
//            dd($file_name);
            $student->profilePic = $file_name;
            $student->save();
        }
//        else{
//            return redirect('staff/guardian')->withErrors(['msg', 'There was some problem uploading the profile picture']);;
//        }
        $student->save();
        $class_section_student=DB::table('class_section_student');
        $class_section_student->insert([
            ['class_id' => $request->classRoom, 'section_id' => $request->section,'student_id'=> $student->id,'session_year'=>date('Y')]
        ]);
        foreach($request->guardian as $get){
        if(!($get==null)) {

            if($get=="Mother") {
                $mother = new Guardian();
                $mother->firstName = $request->ma_Fname;
                $mother->middleName = $request->ma_Mname;
                $mother->lastName = $request->ma_Lname;
                $mother->email = $request->ma_email;
                $mother->relation = "Mother";
                $mother->address = $request->ma_address;
                $mother->occupation = $request->ma_occupation;
//        $mother->profilePic=$request->profilePic;
                $mother->mobile_no = $request->ma_mobile_no;
                $mother->phone_no = $request->ma_phone_no;
                $mother->password = bcrypt($request->ma_password);
                $mother->save();
                if (!file_exists(public_path() . '/images/guardianProfilePic/')) {
                    mkdir(public_path() . '/images/guardianProfilePic/');
                }
                if ($request->ma_profilePic) {
                    $file = $request->file('ma_profilePic');
                    $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
                    $file->move(public_path() . '/images/guardianProfilePic/', $file_name);
//            dd($file_name);
                    $mother->profilePic = $file_name;
                    $mother->save();

                }
                $guardian_student=DB::table('guardian_student');
                $guardian_student->insert([
                    ['guard_id' => $mother->id,'student_id'=> $student->id]
                ]);
            }
            elseif($get=="Father"){
                $father = new Guardian();
                $father->firstName = $request->fa_Fname;
                $father->middleName = $request->fa_Mname;
                $father->lastName = $request->fa_Lname;
                $father->email = $request->fa_email;
                $father->relation = "Father";
                $father->address = $request->fa_address;
                $father->occupation = $request->fa_occupation;
                $father->mobile_no = $request->fa_mobile_no;
                $father->phone_no = $request->fa_phone_no;
                $father->password = bcrypt($request->fa_password);
                $father->save();
                if (!file_exists(public_path() . '/images/guardianProfilePic/')) {
                    mkdir(public_path() . '/images/guardianProfilePic/');
                }
                if ($request->fa_profilePic) {
                    $file = $request->file('fa_profilePic');
                    $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
                    $file->move(public_path() . '/images/guardianProfilePic/', $file_name);
//            dd($file_name);
                    $father->profilePic = $file_name;
                    $father->save();
                }
                $guardian_student=DB::table('guardian_student');
                $guardian_student->insert([
                    ['guard_id' => $father->id,'student_id'=> $student->id]
                ]);
            }
            elseif($get=="Guardian"){
                $guardian = new Guardian();
                $guardian->firstName = $request->ga_firstName;
                $guardian->middleName = $request->ga_middleName;
                $guardian->lastName = $request->ga_lastName;
                $guardian->email = $request->ga_email;
                $guardian->relation = $request->relation;
                $guardian->address = $request->ga_address;
                $guardian->occupation = $request->ga_occupation;
                $guardian->mobile_no = $request->ga_mobile_no;
                $guardian->phone_no = $request->ga_phone_no;
                $guardian->password = bcrypt($request->ga_password);
                $guardian->save();
                if (!file_exists(public_path() . '/images/guardianProfilePic/')) {
                    mkdir(public_path() . '/images/guardianProfilePic/');
                }
                if ($request->ga_profilePic) {
                    $file = $request->file('ga_profilePic');
                    $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
                    $file->move(public_path() . '/images/guardianProfilePic/', $file_name);
//            dd($file_name);
                    $guardian->profilePic = $file_name;
                    $guardian->save();
                }
                $guardian_student=DB::table('guardian_student');
                $guardian_student->insert([
                    ['guard_id' => $guardian->id,'student_id'=> $student->id]
                ]);

            }

        }
    }
        return redirect('staff/student');
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

    //for related select box
    public function ajax($id)
    {

        $section = ClassRoom::find($id)->section()->pluck('name','id');
//        dd($section);
        return json_encode($section);
    }
}
