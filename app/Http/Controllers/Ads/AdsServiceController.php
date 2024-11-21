<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\AdsService;
use App\Models\ConfigAds;
use Illuminate\Http\Request;

class AdsServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if ($request->status) {
            $status = $request->status;
            $adss = AdsService::where('status', $status)->orderBy('id', 'desc')->get();
        } else {
            $adss = AdsService::where('status', 1)->orderBy('id', 'desc')->get();
        }
        return view('ads.index', compact('adss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ads = AdsService::find($id);
        $config = ConfigAds::where('id_ads', $id)->orderBy('created_at', 'desc')->get();
        return view('ads.show', compact('ads','config'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
