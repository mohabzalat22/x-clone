<?php

namespace App\Services;

Class SourceTypeService {

    public static function getExtension($fileName){
        $parts = explode('.', $fileName);
        if(count($parts) == 1) return null;
        $extension = "";
        for($i = 0; $i < count($parts); $i++)
        {
            if($i+1 == count($parts)){
                $extension = $parts[$i];
            }
        }
        return $extension;
        
    }

    public static function extensionIn($filename , $availableExtensions){
        $extension = self::getExtension($filename);
        if($extension != null){
            return in_array($extension, $availableExtensions) ? true : false;
        }
        else {
            return false;
        }
    }

}