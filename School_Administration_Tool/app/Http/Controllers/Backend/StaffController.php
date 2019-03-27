<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\StaffDatableDataTable;
use App\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('staff.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
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
            $staff->save();
        }
//        else{
//            return redirect('staff/guardian')->withErrors(['msg', 'There was some problem uploading the profile picture']);;
//        }
        $staff->save();
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
