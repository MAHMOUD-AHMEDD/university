<?php

namespace App\Actions;

use App\Models\languages;
//use Psy\Util\Str;
use Illuminate\Support\Str;

class HandleDataBeforeSaveAction
{
    public static function handle($data)
    {
        $data_inserted=[];
        $languages=languages::query()->pluck('prefix');
        $output=[];
        foreach ($data as $key => $value){ //ar_name , قاهرة
            $lang_exist_at_input=0;
            foreach ($languages as $language){ // ar
                if(Str::contains($key,$language.'_')){ // ar_name contains ar
                    $input_name=Str::replace($language,'',$key);// _name
                    $input_name=Str::replace('_','',$input_name);// name
                    $output[$input_name][$language]=$value;
                    $lang_exist_at_input=1;
                }
            }
            if ($lang_exist_at_input==0){
                $output[$key]=$value;
            }
        }
        foreach ($output as $key => $value){
            if (is_array($value)) {
                $output[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
        }
//        dd($output);
        return $output;
    }
}
