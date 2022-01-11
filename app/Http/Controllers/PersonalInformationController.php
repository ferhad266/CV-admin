<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PersonalInformationController extends Controller
{
    public function index()
    {
        $data = PersonalInformation::find(1);

        return view('admin.personal_information', ['information' => $data]);
    }

    public function update(Request $request)
    {
        $this->validate($request,
            [
                'cv' => 'mimes:jpeg,jpg,png',
                'image' => 'mimes:jpeg,jpg,png',
                'title_left' => 'required',
                'title_right' => 'required'
            ],
            [
                'cv.mimes' => 'Only this type is valid: jpeg, png , jpg',
                'image.mimes' => 'Only this type is valid: jpeg, png , jpg',
                'title_left.required' => 'Please , enter title',
                'title_right.required' => 'Please , enter title'
            ]
        );

        $data = PersonalInformation::find(1);

        if ($request->file('cv')) {

            $file = $request->file('cv');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);

            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/cv', $file, $fileOriginalName);
            $data->cv = 'cv/' . $fileOriginalName;

        }

        if ($request->file('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);

            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/image', $file, $fileOriginalName);
            $data->image = 'image/' . $fileOriginalName;
        }

        $data->main_title = $request->main_title;
        $data->about_text = $request->about_text;
        $data->btn_contact_text = $request->btn_contact_text;
        $data->btn_contact_link = $request->btn_contact_link;
        $data->small_title_left = $request->small_title_left;
        $data->title_left = $request->title_left;
        $data->small_title_right = $request->small_title_right;
        $data->title_right = $request->title_right;
        $data->full_name = $request->full_name;
        $data->birthday = $request->birthday;
        $data->website = $request->website;
        $data->phone = $request->phone;
        $data->mail = $request->mail;
        $data->address = $request->address;
        $data->about_text = $request->about_text;
        $data->languages = $request->get('languages');
        $data->interests = $request->interests;

        $data->save();

        alert()->success('Success', 'Data Saved!')
            ->showConfirmButton('Okay', '#3085d6')
            ->persistent(true, true);

        return redirect()->back();
    }
}
