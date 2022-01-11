<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{

    public function index()
    {
        $data = Portfolio::with('featuredImage')->get();

        return view('admin.portfolio_list', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.portfolio_add');
    }

    public function store(PortfolioRequest $request)
    {
        $portfolio = Portfolio::create([
            'title' => $request->get('title'),
            'tags' => $request->get('tags'),
            'about' => $request->get('about'),
            'keywords' => $request->get('keywords'),
            'description' => $request->get('description'),
            'website' => $request->get('website'),
            'status' => $request->get('status') ? 1 : 0
        ]);

        if ($request->file('images')) {

            $now = now()->format('YmdHis');
            $count = 0;

            foreach ($request->file('images') as $image) {

                $extension = $image->getClientOriginalExtension();
                $name = $image->getClientOriginalName();
                $slugName = Str::slug($name, '-') . '_' . $now . '.' . $extension;
                $publicPath = 'public/';
                $path = 'portfolio/';
                Storage::putFileas($publicPath . $path, $image, $slugName);

                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image' => $slugName,
                    'featured' => $count == 0 ? 1 : 0,
                    'status' => 1
                ]);

                $count = 1;

            }
        }

        alert()->success('Success', 'Portfolio data was added!')
            ->showConfirmButton('Okay', '#3085d6')
            ->persistent(true, true);
        return redirect()->route('portfolio.index');
    }

    public function show($id)
    {
        //
    }

    public function showImages(Request $request, $id)
    {
        $images = PortfolioImage::where('portfolio_id', $id)->get();

        return view('admin.portfolio_list_images', ['images' => $images]);
    }

    public function newImage(Request $request, $id)
    {

        if ($request->file('images')) {

            $now = now()->format('YmdHis');

            foreach ($request->file('images') as $image) {

                $extension = $image->getClientOriginalExtension();
                $name = $image->getClientOriginalName();
                $slugName = Str::slug($name, '-') . '_' . $now . '.' . $extension;
                $publicPath = 'public/';
                $path = 'portfolio/';
                Storage::putFileas($publicPath . $path, $image, $slugName);

                PortfolioImage::create([
                    'portfolio_id' => $id,
                    'image' => $slugName,
                    'featured' => 0,
                    'status' => 1
                ]);

            }
        }

        alert()->success('Success', 'Portfolio data was added!')
            ->showConfirmButton('Okay', '#3085d6')
            ->persistent(true, true);

        return redirect()->back();

    }

    public function deleteImage(Request $request, $id)
    {

        try {
            $image = PortfolioImage::find($id);

            if ($image) {
                if (file_exists('storage/portfolio/' . $image->image)) {
                    unlink('storage/portfolio/' . $image->image);
                }
                $image->delete();
            }

        } catch (\Exception $exception) {
            return response()->json(['errorMessage' => $exception->getMessage()], 500);
        }

        return response()->json(['success' => true], 200);
    }

    public function featureImage(Request $request, $id)
    {

        try {
            $image = PortfolioImage::find($id);

            if ($image) {
                PortfolioImage::where('portfolio_id', $image->portfolio_id)
                    ->update(
                        [
                            'featured' => 0
                        ]
                    );
                $image->featured = 1;
                $image->save();
            }

        } catch (\Exception $exception) {
            return response()->json(['errorMessage' => $exception->getMessage()], 500);
        }

        return response()->json(['success' => true], 200);
    }

    public function edit($id)
    {
        $portfolio = Portfolio::find($id);

        return view('admin.portfolio_add', compact('portfolio'));
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::where('id', $id)
            ->update([
                'title' => $request->get('title'),
                'tags' => $request->get('tags'),
                'about' => $request->get('about'),
                'keywords' => $request->get('keywords'),
                'description' => $request->get('description'),
                'website' => $request->get('website'),
                'status' => $request->get('status') ? 1 : 0
            ]);

        alert()->success('Success', 'Portfolio data was updated!')
            ->showConfirmButton('Okay', '#3085d6')
            ->persistent(true, true);

        return redirect()->route('portfolio.index');
    }

    public function destroy($id)
    {
        try {
            $portfolio = Portfolio::find($id);

            if ($portfolio) {
                $portfolio->delete();
            }
        } catch (\Exception $exception) {
            return response()->json(['errorMessage', $exception->getMessage()], 500);
        }

        return response()->json(['success', true], 200);
    }

    public function changeStatus(Request $request)
    {
        $id = $request->portfolioId;
        $newStatus = null;
        $findPortfolio = Portfolio::find($id);

        if ($findPortfolio->status) {
            $status = 0;
            $newStatus = "Passive";
        } else {
            $status = 1;
            $newStatus = "Active";
        }
        $findPortfolio->status = $status;
        $findPortfolio->save();

        return response()->json([
            'newStatus' => $newStatus,
            'portfolioId' => $id,
            'status' => $status
        ], 200);
    }

    public function changeStatusImage(Request $request)
    {
        $id = $request->id;
        $newStatus = null;
        $findPortfolio = PortfolioImage::find($id);

        if ($findPortfolio->status) {
            $status = 0;
            $newStatus = "Passive";
        } else {
            $status = 1;
            $newStatus = "Active";
        }
        $findPortfolio->status = $status;
        $findPortfolio->save();

        return response()->json([
            'newStatus' => $newStatus,
            'id' => $id,
            'status' => $status
        ], 200);
    }

}
