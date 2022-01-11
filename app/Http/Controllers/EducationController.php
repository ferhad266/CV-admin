<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationAddRequest;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function list()
    {
        $data = Education::all();

        return view('admin.educationList', compact('data'));
    }

    public function changeStatus(Request $request)
    {
        $id = $request->educationId;
        $newStatus = null;
        $findEducation = Education::find($id);
        $status = $findEducation->status;

        if ($status) {
            $status = 0;
            $newStatus = "Passive";
        } else {
            $status = 1;
            $newStatus = "Active";
        }
        $findEducation->status = $status;
        $findEducation->save();

        return response()->json([
            'newStatus' => $newStatus,
            'educationId' => $id,
            'status' => $status
        ], 200);
    }

    public function addShow(Request $request)
    {
        $id = $request->educationId;

        $education = null;

        if (!is_null($id)) {
            $education = Education::find($id);
        }

        return view('admin.educationAdd', compact('education'));
    }

    public function add(EducationAddRequest $request)
    {
        $status = 0;
        $order = $request->order;

        if (isset($request->status)) {
            $status = 1;
        }

        if (isset($request->educationId)) {
            $id = $request->educationId;

            Education::where('id', $id)->update([
                'education_date' => $request->education_date,
                'university_name' => $request->university_name,
                'university_faculty' => $request->university_faculty,
                'university_degree' => $request->university_degree,
                'description' => $request->description,
                'status' => $status,
                'order' => $order ? $order : 999
            ]);

            alert()->success('Success', 'Education data was updated!')->showConfirmButton('Okay', '#3085d6')->persistent(true, true);
            return redirect()->route('admin.education.list');

        } else {
            Education::create([
                'education_date' => $request->education_date,
                'university_name' => $request->university_name,
                'university_faculty' => $request->university_faculty,
                'university_degree' => $request->university_degree,
                'description' => $request->description,
                'status' => $status,
                'order' => $order ? $order : 999
            ]);

            alert()->success('Success', 'Education data was added!')->showConfirmButton('Okay', '#3085d6')->persistent(true, true);
            return redirect()->route('admin.education.list');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->educationId;

        Education::where('id', $id)->delete();

        return response()->json([], 200);
    }
}
