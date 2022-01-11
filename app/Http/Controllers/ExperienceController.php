<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function list()
    {
        $data = Experience::all();

        return view('admin.experienceList', compact('data'));
    }

    public function addShow(Request $request)
    {
        $id = $request->experienceId;

        $experience = null;

        if (!is_null($id)) {
            $experience = Experience::find($id);
        }

        return view('admin.experienceAdd', compact('experience'));
    }

    public function add(ExperienceRequest $request)
    {
        $status = 0;
        $active = 0;

        $order = $request->order;

        if (isset($request->status)) {
            $status = 1;
        }

        if (isset($request->active)) {
            $active = 1;
        }

        if (isset($request->experienceId)) {
            $id = $request->experienceId;

            Experience::where('id', $id)->update([
                'date' => $request->date,
                'task_name' => $request->task_name,
                'company_name' => $request->company_name,
                'description' => $request->description,
                'status' => $status,
                'active' => $active,
                'order' => $order ? $order : 999
            ]);

            alert()->success('Success', 'Experience data was updated!')->showConfirmButton('Okay', '#3085d6')->persistent(true, true);
            return redirect()->route('admin.experience.list');

        } else {
            Experience::create([
                'date' => $request->date,
                'task_name' => $request->task_name,
                'company_name' => $request->company_name,
                'description' => $request->description,
                'status' => $status,
                'active' => $active,
                'order' => $order ? $order : 999
            ]);

            alert()->success('Success', 'Experience data was added!')->showConfirmButton('Okay', '#3085d6')->persistent(true, true);
            return redirect()->route('admin.experience.list');
        }
    }

    public function changeStatus(Request $request)
    {
        $id = $request->experienceId;
        $newStatus = null;
        $findExperience = Experience::find($id);
        $status = $findExperience->status;

        if ($status) {
            $status = 0;
            $newStatus = "Passive";
        } else {
            $status = 1;
            $newStatus = "Active";
        }
        $findExperience->status = $status;
        $findExperience->save();

        return response()->json([
            'newStatus' => $newStatus,
            'experienceId' => $id,
            'status' => $status
        ], 200);
    }

    public function activeStatus(Request $request)
    {
        $id = $request->experienceId;
        $newActive = null;
        $findExperience = Experience::find($id);
        $active = $findExperience->active;

        if ($active) {
            $active = 0;
            $newActive = "Passive";
        } else {
            $active = 1;
            $newActive = "Active";
        }
        $findExperience->active = $active;
        $findExperience->save();

        return response()->json([
            'newActive' => $newActive,
            'experienceId' => $id,
            'active' => $active
        ], 200);
    }

    public function delete(Request $request)
    {
        $id = $request->experienceId;

        Experience::where('id', $id)->delete();

        return response()->json([], 200);
    }


}
