<?php

namespace App\filters;
use Closure;
use Illuminate\Support\Str;
class FilterRequest
{
    public function handle($request ,Closure $next)
    {
        $filter=class_basename($this);
        $filter=str_replace('Filter','',$filter);
        $filter=Str::snake($filter);
        if(request()->filled($filter)){
            return $next($request)->where($filter,request($filter));
        }
        return $next($request);
    }
}
