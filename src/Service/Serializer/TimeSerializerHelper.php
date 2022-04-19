<?php


namespace App\Service\Serializer;


use DateTime;
use Exception;

class TimeSerializerHelper
{
    /**
     * @param array $preNormalizedObject
     * @return array
     * @throws Exception
     */
    public static function normalizeTimeAttributes(array $preNormalizedObject)
    {
        foreach ($preNormalizedObject as $key => $value){
            if(is_array($value)){
                $preNormalizedObject[$key] = self::normalizeTimeAttributes($value);
                continue;
            }
            if(!str_contains($key, 'Date') || empty($value)) continue;
            $preNormalizedObject[$key] = (new DateTime($value))->format('H:i');
        }
        return $preNormalizedObject;
    }
}
