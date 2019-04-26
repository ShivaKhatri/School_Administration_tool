<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\StaffDatableDataTable;
use App\Model\ClassRoom;
use App\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StaffDatableDataTable $staffs)
    {
        return $staffs->render('backend.staff.indexStaff');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $class=ClassRoom::all()->pluck('name','id');
        return view('staff.auth.register')->with('class',$class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
//        dd($request);
        $staff=new Staff();
        $staff->firstName=$request->firstName;
        $staff->middleName=$request->middleName;
        $staff->lastName=$request->lastName;
        $staff->email=$request->email;
        $staff->gender=$request->gender;
        $staff->dob=$request->dob;
        $staff->role=$request->role;
        $staff->address=$request->address;
//        $staff->profilePic=$request->profilePic;
        $staff->remark=$request->remark;
        $staff->mobile_no=$request->mobile_no;
        $staff->phone_no=$request->phone_no;
        $staff->password=bcrypt($request->password);

        if (!file_exists(public_path() . '/images/staffProfilePic/')) {
            mkdir(public_path() . '/images/staffProfilePic/');
        }
        if ($request->profilePic) {
            $file = $request->file('profilePic');
            $file_name = rand(1857, 9899) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/staffProfilePic/', $file_name);
//            dd($file_name);
            $staff->profilePic = $file_name;
        }


        if($request->role=="ClassTeacher"){
            if($request->section)
                $staff->sectionTeacher_id = $request->section;

            $staff->classTeacher_id = $request->classRoom;
        }
        $staff->save();

        $class_staff=DB::table('class_staff');
        $class_staff_subject=DB::table('class_staff_subject');
        if($request->role=="Teacher"||$request->role=="ClassTeacher"){
            $class=ClassRoom::all();
            foreach ($class as $getClass){
                $section=$getClass->section()->get();
                $name='class'.$getClass->id;

                foreach($section as $getSection){
                    $sectiontName='section'.$getSection->id.$getClass->id;
                    if(!($request->$name)){
                        if($request->$sectiontName){
                            Staff::destroy($staff->id);
                            return redirect()->back()->withErrors(['You need to select the class to select its section and subjects']);
                        }
                    }
                    if($request->$name){
                        if($request->$sectiontName){
                            $class_staff->insert([
                                ['class_id' => $request->$name,'sec_id'=>$request->$sectiontName,'staff_id'=>$staff->id]
                            ]);
                        }

                    }
                    $subject=$getClass->subject()->get();

                    foreach($subject as $getSubject){
                        $subjectName='subject'.$getSubject->id.$getClass->id.$getSection->id;
                        if(!($request->$name)){
                            if(!($request->$sectiontName)){
                                if($request->$subjectName) {
                                    Staff::destroy($staff->id);
                                return redirect()->back()->withErrors(['You need to select the class to select its section and subjects']);
                            }
                            }
                        }
                        if($request->$name){
                            if($request->$subjectName) {

                                $class_staff_subject->insert([
                                    ['class_id' => $request->$name, 'sec_id'=>$request->$sectiontName,'staff_id'=>$staff->id,'subject_id' =>$request->$subjectName]
                                ]);
                            }
                        }
                    }
                }

            }
        }
        return redirect('staff/staff');
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
        $class=ClassRoom::all()->pluck('name','id');
        $staff=Staff::find($id);
        return view('backend.staff.editStaff')->with('staff',$staff)->with('class',$class);

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
        $class_staff=DB::table('class_staff');
        $class_staff->where('staff_id','=',$id)->delete();
        $class_staff_subject=DB::table('class_staff_subject');
        $class_staff_subject->where('staff_id','=',$id)->delete();
        if($request->role=="Teacher"||$request->role=="ClassTeacher"){
            $class=ClassRoom::all();
            foreach ($class as $get){
                $section=$get->section()->get();
                $name='class'.$get->id;

                foreach($section as $getSection){
                    $sectiontName='section'.$getSection->id.$get->id;
                    if(!($request->$name)){
                        if($request->$sectiontName){
                            return redirect()->back()->withErrors(['You need to select the class to select its section and subjects']);
                        }
                    }
                    if($request->$name){
                        if($request->$sectiontName){
                            $class_staff->insert([
                                ['class_id' => $request->$name,'sec_id'=>$request->$sectiontName,'staff_id'=>$id]
                            ]);
                        }

                    }
                    $subject=$get->subject()->get();

                    foreach($subject as $getSubject){
                        $subjectName='subject'.$getSubject->id.$get->id.$getSection->id;
                        if(!($request->$name)){
                            if(!($request->$sectiontName)){
                                if($request->$subjectName) {
                                    return redirect()->back()->withErrors(['You need to select the class to select its section and subjects']);
                                }
                            }
                        }
                        if($request->$name){
                            if($request->$subjectName) {
                                $class_staff_subject->insert([
                                    ['class_id' => $request->$name,'sec_id' =>$request->$sectiontName, 'staff_id'=>$id,'subject_id' =>$request->$subjectName]
                                ]);
                            }
                        }
                    }
                }

            }
        }

//        dd($request->section);
        $staff=Staff::find($id);
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
        if($request->password){
            $staff->update([

                'firstName'=>$request->firstName,
                'middleName'=>$request->middleName,
                'LastName'=>$request->LastName,
                'email'=>$request->email,
                'gender'=>$request->gender,
                'role'=>$request->role,
                'dob'=>$request->dob,
                'address'=>$request->address,
                'remark'=>$request->remark,
                'phone_no'=>$request->phone_no,
                'mobile_no'=>$request->mobile_no,
                'profilePic'=>$profilePic,
                'classTeacher_id'=>$request->classRoom,
                'sectionTeacher_id'=>$request->section,
                'password'=>bcrypt($request->password)

            ]);
        }
        else{
            $staff->update([

                'firstName'=>$request->firstName,
                'middleName'=>$request->middleName,
                'LastName'=>$request->lastName,
                'email'=>$request->email,
                'gender'=>$request->gender,
                'role'=>$request->role,
                'dob'=>$request->dob,
                'address'=>$request->address,
                'remark'=>$request->remark,
                'phone_no'=>$request->phone_no,
                'mobile_no'=>$request->mobile_no,
                'profilePic'=>$profilePic,
                'classTeacher_id'=>$request->classRoom,
                'sectionTeacher_id'=>$request->section,
            ]);
        }


        return redirect('staff/staff');
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
            return response()->json([
                'success' => 'Record not deleted!'
            ]);

        }
//
//        $guardian_student=DB::table('staff_subject');
//        $guardian_student->where('staff_id','=',$id)->delete();
        $class_staff=DB::table('class_staff');
        $class_staff->where('staff_id','=',$id)->delete();
        $class_staff_subject=DB::table('class_staff_subject');
        $class_staff_subject->where('staff_id','=',$id)->delete();
        Staff::destroy($id);

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Staff::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
    public function role($id){
//
        $html='<div id="roleTeacher">';
        $class=ClassRoom::all()->pluck('name','id');
        $option='<option value="">Select Class</option>';

        foreach ($class as $key=>$value){
            $option=$option.'<option value="'.$key.'">'.$value.'</option>';
        }
        if($id=="ClassTeacher"){
            $html=$html.'<div class="x_title col-md-12 col-sm-12 col-xs-12" id="cTeacher">
                            <h2> Assign Class Teachers to a class </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                            <label class="control-label"> Class
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                <select name="classRoom"  class="classRoom form-control" required>
                                '.$option.'
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                            <label class="control-label"> Section
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                <select name="section" class="form-control" ></select>
                            </div>
                        </div>';
        }
        $class=ClassRoom::all();
        $html = $html . '<div class="x_title col-md-12 col-sm-12 col-xs-12">
                            <h2> Assign Teachers to subjects and class </h2>
                            <div class="clearfix"></div>
                        </div>';
        foreach ($class as $get) {
            $html = $html . '
                        <div class="col-md-6"><div class="panel panel-default ">
                                <div class="panel-heading">Class: ' . $get->name . ' <input name="class' . $get->id . '" type="checkbox" class="flat-red" value="' . $get->id . '"> </div>
                                <div class="panel-body">
                                    ';
            $section = $get->section()->get();
            foreach ($section as $getSection) {
                $html = $html . 'Section: <br><div class="row d-flex justify-content-around">
                                            <div class="col-md-5" style="margin-top: 3px; margin-bottom: 3px">
                                                <span class="badge badge-pill badge-success" style="background-color: #3c8dbc">' . $getSection->name . ' &nbsp;&nbsp;<input name="section' . $getSection->id . $get->id . '" type="checkbox" class="flat-red" value="' . $getSection->id . '"></span>
                                            </div>
                                        </div>';
                $html = $html . '  <hr>Subjects: <br><div class="row">';
                $subject = $get->subject()->get();
                foreach ($subject as $getSubject) {
                    $html = $html . '
                                                <div class="col-md-6" style="margin-top: 3px; margin-bottom: 3px">
                                                    <span class="badge badge-pill badge-success" style="background-color: #3c8dbc">' . $getSubject->name . ' &nbsp;&nbsp;<input name="subject' . $getSubject->id . $get->id .$getSection->id. '" type="checkbox" class="flat-red" value="' . $getSubject->id . '"></span>
                                                </div>
                                           ';
                }
                $html = $html . '  </div> <hr>';
            }


            $html = $html . '      </div>
                                    <div class="panel-footer">
                                    </div>
                                </div>
                                </div>
                            ';

        }

        $html = $html . '</div>';

        return json_encode($html);
    }
    public function roleEdit($use,$id){
//
        $html='<div id="roleTeacher">';
        $class=ClassRoom::all()->pluck('name','id');
        $option='<option value="">Select Class</option>';

        foreach ($class as $key=>$value){
            $option=$option.'<option value="'.$key.'">'.$value.'</option>';
        }
        if($id=="ClassTeacher"){
            $html=$html.'<div class="x_title col-md-12 col-sm-12 col-xs-12" id="cTeacher">
                            <h2> Assign Class Teachers to a class </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                            <label class="control-label"> Class
                                <span class="required">*</span></label>
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                <select name="classRoom"  class="classRoom form-control" required>
                                '.$option.'
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                            <label class="control-label"> Section
                            <div class="input-group col-md-11 col-sm-11 col-xs-12">
                                <select name="section" class="form-control" ></select>
                            </div>
                        </div>';
        }
        $class=ClassRoom::all();
        $html = $html . '<div class="x_title col-md-12 col-sm-12 col-xs-12">
                            <h2> Assign Teachers to subjects and class </h2>
                            <div class="clearfix"></div>
                        </div>';
        foreach ($class as $get) {
            $html = $html . '
                        <div class="col-md-6"><div class="panel panel-default ">
                                <div class="panel-heading">Class: ' . $get->name . ' <input name="class' . $get->id . '" type="checkbox" class="flat-red" value="' . $get->id . '"> </div>
                                <div class="panel-body">
                                    ';
            $section = $get->section()->get();
            foreach ($section as $getSection) {
                $html = $html . 'Section: <br><div class="row d-flex justify-content-around">
                                            <div class="col-md-5" style="margin-top: 3px; margin-bottom: 3px">
                                                <span class="badge badge-pill badge-success" style="background-color: #3c8dbc">' . $getSection->name . ' &nbsp;&nbsp;<input name="section' . $getSection->id . $get->id . '" type="checkbox" class="flat-red" value="' . $getSection->id . '"></span>
                                            </div>
                                        </div>';
                $html = $html . '  <hr>Subjects: <br><div class="row">';
                $subject = $get->subject()->get();
                foreach ($subject as $getSubject) {
                    $html = $html . '
                                                <div class="col-md-6" style="margin-top: 3px; margin-bottom: 3px">
                                                    <span class="badge badge-pill badge-success" style="background-color: #3c8dbc">' . $getSubject->name . ' &nbsp;&nbsp;<input name="subject' . $getSubject->id . $get->id .$getSection->id. '" type="checkbox" class="flat-red" value="' . $getSubject->id . '"></span>
                                                </div>
                                           ';
                }
                $html = $html . '  </div> <hr>';
            }


            $html = $html . '      </div>
                                    <div class="panel-footer">
                                    </div>
                                </div>
                                </div>
                            ';

        }

        $html = $html . '</div>';

        return json_encode($html);
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
}
