<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Utility {
    public static function stripXSS(&$request)
    {
      static::cleanArray($request);
    }

    public static function stripSingleXSS(&$name)
    {
      $name = trim(htmlspecialchars(strip_tags(preg_replace('~\r\n?~', "\n", $name)), ENT_NOQUOTES | ENT_HTML5));
    }

    public static function cleanArray(&$array)
    {
        $result = array();
        foreach ($array->all() as $key => $value) {
            if($key != 'html')
            {
              $tmp_val     = $array[$key];
              unset($array[$key]);
              $key         = strip_tags($key);
              if (is_array($tmp_val)) {
                  $array[$key] = static::cleanArray($tmp_val);
              } else {
                  $array[$key] = trim(htmlspecialchars(strip_tags(preg_replace('~\r\n?~', "\n", $tmp_val)), ENT_NOQUOTES | ENT_HTML5)); // Remove trim() if you want to.
              }
            }
       }
    }
}
