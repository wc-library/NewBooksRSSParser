<?php

namespace util;

class Utility {
    public static function parseRange($strlist) {
        $ranges = explode(',',str_replace(' ','',$strlist));
        $n = count($ranges);
        for ($i=0; $i<$n; ++$i) {
            $ranges[$i] = explode('-',$ranges[$i]);
        }

        return $ranges;
    }

    public static function loadClass($classname) {
        $filename = __DIR__ . "/../../classes/"
            . str_replace('\\', DIRECTORY_SEPARATOR, ltrim($classname, '\\'))
            . ".php";

        if ($filepath = stream_resolve_include_path($filename)) {
            require_once $filepath;
        }
        return $filepath !== false;
    }

    public static function isValidImage($url) {
        if (empty($url))
            return false;
        $data = getimagesize($url);
        return ($data[0]>1 && $data[1]>1);
    }
}
