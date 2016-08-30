<?php
use yii\helpers\VarDumper;
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.05.2016
 * Time: 20:40
 */

/**
 * Debug function
 * d($var);
 * @param $var
 * @param null $caller
 */
function d($var,$caller=null)
{
    if(!isset($caller)){
        $tmp_var = debug_backtrace(1);
        $caller = array_shift($tmp_var);
    }
    echo '<code>File: '.$caller['file'].' / Line: '.$caller['line'].'</code>';
    echo '<pre>';
    VarDumper::dump($var, 10, true);
    echo '</pre>';
}

/**
 * Debug function with die() after
 * dd($var);
 * @param $var
 */
function dd($var)
{
    $tmp_var = debug_backtrace(1);
    $caller = array_shift($tmp_var);
    d($var,$caller);
    die();
}

function mb_truncate($string, $length = 80, $etc = '...', $charset='UTF-8', $break_words = false, $middle = false)
{
    $string = strip_tags($string);
    $string = preg_replace('/&quot;$/u', '"', $string);

    if ($length == 0)
        return '';
    if (mb_strlen($string) > $length) {
        $length -= min($length, mb_strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length+1, $charset));
        }
        if(!$middle) {
            return mb_substr($string, 0, $length, $charset) . $etc;
        } else {
            return mb_substr($string, 0, $length/2, $charset) . $etc . mb_substr($string, -$length/2, $charset);
        }
    } else {
        return $string;
    }
}