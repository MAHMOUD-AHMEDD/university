<?php

namespace App\Http\Controllers;

use App\filters\GovernmentIdFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColleageFormRequest;
use App\Http\Resources\ColleagesResource;
use App\Models\colleages;
use App\Models\colleages_years;
use http\Message;
use Illuminate\Http\Request;
use App\Actions\HandleDataBeforeSaveAction;
use App\Http\Resources\GovernmentResource;
use App\Models\government;
use App\Services\Messages;
use Illuminate\Pipeline\Pipeline;
use App\filters\NameFilter;
use App\filters\StartDateFilter;
use App\filters\EndDateFilter;
use App\filters\SubjectIdFilter;
use App\Http\Requests\GovernmentFormRequest;
use Illuminate\Support\Facades\DB;

//use App\filters\GovernmentIdFilter;
class ColleagesControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=colleages::query()->with('government')->orderBy('id','DESC');
        $result=app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
                SubjectIdFilter::class,
                GovernmentIdFilter::class
            ])
            ->thenReturn()
            ->paginate(10);
        return ColleagesResource::collection($result);
    }
    public function save($data)
    {
        DB::beginTransaction();
        $data['years_ids']=json_decode($data['years_ids'],true);
        $output=colleages::query()->updateOrCreate([
            'id'=>$data['id']??null
        ],$data);
        foreach ($data['years_ids'] as $year){
            colleages_years::query()->updateOrCreate([
                'id'=>$year['id']??null
            ],[
                'colleage_id'=>$output->id,
                'year_id'=>$year['year_id'],
                ]);
        }
        $output->load('government');
        DB::commit();
        return Messages::success(ColleagesResource::make($output,__('messages.saved_successfully')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColleageFormRequest $request)
    {
       $data=$request->validated();
//       dd($data);
       $handle_data=HandleDataBeforeSaveAction::handle($data);
//       dd($handle_data);
        return $this->save($handle_data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item=colleages::query()->find($id);
//        dd($item);
        if($item){
            return ColleagesResource::make($item);
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
