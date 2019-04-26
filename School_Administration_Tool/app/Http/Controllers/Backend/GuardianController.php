<?php

namespace App\Http\Controllers\Backend;

use App\Guardian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataTables\GuardiansDataTable;
use Illuminate\Support\Facades\DB;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GuardiansDataTable $datable)
    {
        if (Auth::guard('staff')->check()) {
            return $datable->render('backend.guardian.indexGuardian');
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
        return redirect('staff/guardian');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('staff/guardian');
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
        $guardian=Guardian::find($id);
        return view('backend.guardian.editGaurdian')->with('guardian',$guardian);

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
        $guardian=Guardian::find($id);
        if (!file_exists(public_path() . '/images/guardianProfilePic/')) {
            mkdir(public_path() . '/images/guardianProfilePic/');
        }
        $profilePic='';
        if ($request->ga_profilePic) {
            $file = $request->file('ga_profilePic');
            $file_name = rand(1857, 9899) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/guardianProfilePic/', $file_name);
//            dd($file_name);
            $profilePic = $file_name;
        }
        $guardian->update([

            'firstName'=>$request->ga_Fname,
            'middleName'=>$request->ga_Mname,
            'LastName'=>$request->ga_Lname,
            'email'=>$request->ga_email,
            'relation'=>$request->relation,
            'address'=>$request->ga_address,
            'remark'=>$request->ga_remarks,
            'phone_no'=>$request->ga_phone_no,
            'mobile_no'=>$request->ga_mobile_no,
            'profilePic'=>$profilePic,
            'password'=>bcrypt($request->ga_password)

        ]);

        return redirect('staff/guardian');
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
                'success' => 'Record not deleted !'
            ]);

        }

        $guardian_student=DB::table('guardian_student');
        $guardian_student->where('guard_id','=',$id)->delete();

        Guardian::destroy($id);

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Guardian::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
