<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\government;
use Illuminate\Http\Request;

class GovernmentControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=government::query();
        if(request()->filled('name')){
            $data->where('name','LIKE','%'.request('name').'%');
        }
        if(request()->filled('start_date')){
            $data->where('created_at','>=',request('start_date'));
        }
        if(request()->filled('start_date')){
            $data->where('created_at','<=',request('end_date'));
        }
        return $data->get();
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
        $item=government::query()->find($id);
        if($item){
            return $item;
        }
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
