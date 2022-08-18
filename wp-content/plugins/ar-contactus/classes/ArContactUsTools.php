<?php

class ArContactUsTools 
{
    public static function escJsString($value, $nl2br = false)
    {
        $value = esc_js($value);
        //$value = nl2br($value);
        //$value = str_replace(array("\n", "\r"), '', $value);
        if ($nl2br) {
            $value = str_replace(array('\n'), '<br/>', $value);
        }
        
        return $value;
    }
}
