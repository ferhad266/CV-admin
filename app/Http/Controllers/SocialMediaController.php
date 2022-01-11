<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function list()
    {
        $data = SocialMedia::all();

        return view('admin.social_media_list', ['data' => $data]);
    }

    public function addShow(Request $request)
    {
        $socialMedia = null;

        $socialMediaId = $request->socialMediaId;

        if ($socialMediaId) {
            $socialMedia = SocialMedia::find($socialMediaId);
        }

        return view('admin.social_media_add', ['socialMedia' => $socialMedia]);
    }

    public function add(Request $request)
    {
        $data = [
            'name' => $request->get('name'),
            'link' => $request->get('link'),
            'icon' => $request->get('icon'),
            'order' => $request->get('order')
        ];

        if ($request->get('status')) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $socialMediaId = $request->socialMediaId;

        if ($socialMediaId) {
            SocialMedia::where('id', $socialMediaId)->update($data);

            alert()->success('Success', 'Update was successfully!')
                ->showConfirmButton('Okay', '#3085d6')
                ->persistent(true, true);

        } else {
            SocialMedia::create($data);

            alert()->success('Success', 'Add was successfully!')
                ->showConfirmButton('Okay', '#3085d6')
                ->persistent(true, true);
        }

        return redirect()->route('admin.socialMedia.list');

    }

    public function delete(Request $request)
    {
        $socialMediaId = $request->socialMediaId;

        SocialMedia::where('id', $socialMediaId)->delete();

        return response()->json(['message' => 'Success'], 200);
    }

    public function changeStatus(Request $request)
    {
        $socialMediaId = $request->socialMediaId;

        $socialMedia = SocialMedia::find($socialMediaId);
        $status = $socialMedia->status;
        $socialMedia->status = $status ? $status = 0 : $status = 1;
        $socialMedia->save();

        return response()->json(
            [
                'newStatus' => $socialMedia->status == 1 ? 'Active' : 'Passive',
                '$socialMediaId' => $socialMediaId,
                'status' => $status
            ], 200
        );
    }
}
