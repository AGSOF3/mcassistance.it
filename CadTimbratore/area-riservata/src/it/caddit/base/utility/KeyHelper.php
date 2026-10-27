<?php 

// chr(22);
define("KEY_SEPARATOR","");

class KeyHelper {

    const KEY_SEPARATOR = "";

    public static function buildObjectKey($objectKey) {
        $key = "";
        for ($i = 0; $i < count($objectKey); $i ++) {
            if ($i > 0)
                $key .= KEY_SEPARATOR;
            $key .= $objectKey[$i];
        }
        return $key;
    }
    
    public static function getTokenObjectKey($key, $index) {
        if ($key != null) {
            $keyArray = explode(KEY_SEPARATOR, $key);
            if ($index > 0 && $index <= COUNT($keyArray))
                return $keyArray[$index -1];
        }
        return null;
    }
    
}

?>