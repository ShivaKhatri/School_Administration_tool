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
use Illuminate\View\View;
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
            ['class_id' => $request->classRoom, 'section_id' => $request->section,'student_id'=> $student->id,'session_year'=>$request->session_year]
        ]);

        if($request->exist=='no'){
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
                        $guardian->firstName = $request->ga_Fname;
                        $guardian->middleName = $request->ga_Mname;
                        $guardian->lastName = $request->ga_Lname;
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
        }
        else{
            foreach($request->guardian as $get){
                if(!($get==null)) {

                    if($get=="Mother") {
                        $guardian_student=DB::table('guardian_student');
                        $guardian_student->insert([
                            ['guard_id' => $request->yesMother,'student_id'=> $student->id]
                        ]);
                    }
                    elseif($get=="Father"){
                        $guardian_student=DB::table('guardian_student');
                        $guardian_student->insert([
                            ['guard_id' => $request->yesFather,'student_id'=> $student->id]
                        ]);
                    }
                    elseif($get=="Guardian"){
                        $guardian_student=DB::table('guardian_student');
                        $guardian_student->insert([
                            ['guard_id' => $request->yesGuardian,'student_id'=> $student->id]
                        ]);

                    }

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
        $student=Student::find($id);
        $class=ClassRoom::all()->pluck('name','id');

        return view('backend.student.editStudent')->with('student',$student)->with('class',$class);

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
        $student=Student::find($id);
//        dd($student);
        if (!file_exists(public_path() . '/images/staffProfilePic/')) {
            mkdir(public_path() . '/images/staffProfilePic/');
        }
        $profilePic='';
        if ($request->profilePic) {
            $file = $request->file('profilePic');
            $file_name = rand(1857, 9899) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/staffProfilePic/', $file_name);
//            dd($file_name);
            $profilePic = $file_name;
        }
        $student->update([

            'firstName'=>$request->firstName,
            'middleName'=>$request->middleName,
            'LastName'=>$request->lastName,
            'email'=>$request->email,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'address'=>$request->address,
            'remark'=>$request->remarks,
            'phone_no'=>$request->phone_no,
            'mobile_no'=>$request->mobile_no,
            'profilePic'=>$profilePic,
            'password'=>bcrypt($request->password)

        ]);
        $student->save();
        if($request->classRoom) {
            $class_student=DB::table('class_section_student');
            $class_student->where('student_id','=',$id)->delete();
                $class_student->insert(['class_id' => $request->classRoom, 'section_id' => $request->section,'student_id' => $id,'session_year'=>$request->session_year]);
        }
        else{
            return redirect('staff/student');
        }
        return redirect('staff/student');
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
        $class_section_student=DB::table('class_section_student');
        $class_section_student->where('student_id','=',$id)->delete();

        $guardian_student=DB::table('guardian_student');
        $guardian_student->where('student_id','=',$id)->delete();

        Student::destroy($id);

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Student::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

    //for related select box
    public function ajax($id)
    {

        $section = ClassRoom::find($id)->section()->pluck('name','id');
//        dd($section);
        return json_encode($section);
    }
    //for related select box
    public function ajaxEdit($use,$id)
    {

        $section = ClassRoom::find($id)->section()->pluck('name','id');
//        dd($section);
        return json_encode($section);
    }
    public function valid($id,$use)
    {

        $valid = Guardian::find($id);
//        dd($section);
        if($valid){
            if($valid->relation==$use) {
                return json_encode(true);
            }
            elseif($use=="guardian"){
                if($valid->relation!="Mother" && $valid->relation!="Father"){
                    return json_encode(true);
                }
                else{
                    return json_encode(false);

                }
            }
            else{
                return json_encode(false);
            }

        }else
            return json_encode(false);


    }
}
