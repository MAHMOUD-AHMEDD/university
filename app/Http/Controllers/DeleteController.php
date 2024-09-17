<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Messages;
use Illuminate\Http\Request;
use App\Http\Requests\DeleteFormRequest;
use App\Models\Images;
use App\Actions\DeleteFromPublicAction;
class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DeleteFormRequest $request)
    {
        if(request('model_name')=='images'){
            $image=images::query()->find(request('id'));
            $image->delete();
            DeleteFromPublicAction::delete('images',$image->name);
        }
        else{
            $item=('App\Models\\'.request('model_name'))::query()->find(request('id'));
            $item->delete();
        }
        return Messages::success('',__('messages.deleted_successfully'));
    }
}
