<?php

/**
 * Search in array and return the parents keys
 * @param  midex   $needle
 * @param  array   $haystack
 * @param  boolean $firstKey
 * @return mixed
 */
function array_search_recursive($needle, $haystack, $firstKey = false)
{
    $keys = array();

    foreach ($haystack as $key => $value) {
        if (is_array($value)) {
            $keys[] = $key;
            $newkeys = array_search_recursive($needle, $value);
            if ($newkeys) {
                $keys = array_merge($keys, $newkeys);
                return $firstKey ? $keys[0] : $keys;
            }

            $keys = array();

        } else if ($value == $needle) {
            $keys[] = $key;
            return $firstKey ? $keys[0] : $keys;
        }
    }

    return false;
}


function doOperation($a, $operator, $b)
{
    switch ($operator) {
        case '<':  return ($a <  $b); break;
        case '<=': return ($a <= $b); break;
        case '=':  return ($a == $b); break;
        case '>=': return ($a >= $b); break;
        case '>':  return ($a >  $b); break;
    }

    throw new Exception("The operator {$operatos} doesn't exist", 1);

}
