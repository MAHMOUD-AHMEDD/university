<?php

namespace App\filters;
use Closure;
class NameFilter
{
    public function handle($request ,Closure $next)
    {
//        dd(request()->filled('name'));
        if(request()->filled('name')){
            return $next($request)
                ->where('name','LIKE','%'.request('name').'%');
        }
        return $next($request);
    }
}
