<?php

namespace App\Http\Controllers;

use App\Actions\HandleDataBeforeSaveAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColleagesResource;
use App\Http\Resources\GovernmentResource;
use App\Models\government;
use App\Services\Messages;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\filters\NameFilter;
use App\filters\StartDateFilter;
use App\filters\EndDateFilter;
use App\filters\SubjectIdFilter;
use App\Http\Requests\GovernmentFormRequest;
use App\filters\GovernmentIdFilter;
class GovernmentControllerResource extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store','update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=government::query()->orderBy('id','DESC');
        $result=app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                SubjectIdFilter::class,
                GovernmentIdFilter::class,
            ])
            ->thenReturn()
            ->paginate(10);
        return ColleagesResource::collection($result);
//        DRY===> Dont Repeat yourself
//        if(request()->filled('name')){
//            $data->where('name','LIKE','%'.request('name').'%');
//        }
//        if(request()->filled('start_date')){
//            $data->where('created_at','>=',request('start_date'));
//        }
//        if(request()->filled('start_date')){
//            $data->where('created_at','<=',request('end_date'));
//        }
//        return $data->get();
    }
    public function save($data)
    {
        $output=government::query()->updateOrCreate([
            'id'=>$data['id']?? null
        ],$data);
        return Messages::success(GovernmentResource::make($output),__('messages.saved_successfully'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GovernmentFormRequest $request)
    {
        $data=$request->validated();
//        dd($data);
        $handled_data=HandleDataBeforeSaveAction::handle($data);
//        dd($handled_data);
        return $this->save($handled_data);
//        return $data;
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
    public function update(GovernmentFormRequest $request, string $id)
    {
        $data=$request->validated();
        $handled_data=HandleDataBeforeSaveAction::handle($data);
        $handled_data['id']=$id;
        return $this->save($handled_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
