<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        try {
            DB::beginTransaction();
            $packageObj = new Package();
            if($request->hasFile('image')){
                $imagePath = $request->file('image')->store('packageImage', 'public');
            }



            $packageObj->image   = $imagePath;
            $packageObj->name    = $request->input('name');
            $packageObj->price   = $request->input('price');
            $packageObj->type    = $request->input('type');
            $packageObj->message = $request->input('message');

            $res = $packageObj->save();

            DB::commit();
            if($res){
                return redirect()->back()->with('message', 'Package created successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}