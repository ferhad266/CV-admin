<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PersonalInformation;
use App\Models\Portfolio;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $educationList = Education::query()
            ->statusActive()
            ->select('education_date', 'university_name', 'university_faculty', 'university_degree', 'description')
            ->orderBy('order', 'DESC')
            ->get();

        $experienceList = Experience::query()
            ->statusActive()
            ->select('date', 'task_name', 'company_name', 'description')
            ->orderBy('order', 'DESC')
            ->get();

        return view('pages.index', compact('educationList', 'experienceList'));
    }

    public function resume()
    {
        return view('pages.resume');
    }

    public function portfolio()
    {
        $portfolio = Portfolio::with('featuredImage')
            ->where('status', 1)
            ->orderByDesc('id')
            ->get();

        return view('pages.portfolio', compact('portfolio'));
    }

    public function portfolioDetail($id)
    {

        $portfolio = Portfolio::with('images')
            ->where('status', 1)
            ->where('id', $id)
            ->first();

        if (is_null($portfolio)) {
            abort(404, 'Portfolio does not exist!');
        }

        return view('pages.portfolioDetail', compact('portfolio'));

    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
