<?php
namespace app\components\generator;

use Yii;

class Policy extends \yii\base\Component
{

    public static function getKeyTotal(&$model, $simpleMode)
    {
        $key_total = 0;
        
        if (! $simpleMode) { // TODO: Mask is not supported yet! Convert mask mode to simple mode!
            $model->charset_1 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 !"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
            $model->charset_2 = '';
            $model->charset_3 = '';
            $model->charset_4 = '';
            
            $model->mask = str_repeat('?1', $model->len_max);
            
            $simpleMode = true;
        }
        
        if ($simpleMode) {
            $charsetLen = strlen($model->charset_1);
            
            $d_chars = '';
            $u_chars = '';
            $l_chars = '';
            $s_chars = '';
            for ($i = 0; $i < $charsetLen; $i ++) {
                $ascii = ord($model->charset_1[$i]);
                
                if ((47 < $ascii) && ($ascii < 58)) // 48 <= digit <= 57
                    $d_chars .= $model->charset_1[$i];
                elseif ((64 < $ascii) && ($ascii < 91)) // 65 <= upper <= 90
                    $u_chars .= $model->charset_1[$i];
                elseif ((96 < $ascii) && ($ascii < 123)) // 97 <= upper <= 122
                    $l_chars .= $model->charset_1[$i];
                elseif ((31 < $ascii) && ($ascii < 127)) // 32 <= printable <= 126
                    $s_chars .= $model->charset_1[$i];
            }
            
            $d = strlen($d_chars);
            $u = strlen($u_chars);
            $l = strlen($l_chars);
            $s = strlen($s_chars);
            
            if (($d > 0) && ($u > 0) && ($l > 0) && ($s > 0)) {
                $duls = $d + $u + $l + $s;
                
                $dul = $d + $u + $l;
                $dus = $d + $u + $s;
                $dls = $d + $l + $s;
                $uls = $u + $l + $s;
                
                $du = $d + $u;
                $dl = $d + $l;
                $ds = $d + $s;
                $ul = $u + $l;
                $us = $u + $s;
                $ls = $l + $s;
                
                for ($len = max(4, $model->len_min); $len <= $model->len_max; $len ++) {
                    $key_total += (pow($duls, $len) - (pow($dul, $len) + pow($dus, $len) + pow($dls, $len) + pow($uls, $len)) + (pow($du, $len) + pow($dl, $len) + pow($ds, $len) + pow($ul, $len) + pow($us, $len) + pow($ls, $len)) - (pow($d, $len) + pow($u, $len) + pow($l, $len) + pow($s, $len)));
                }
            }
        }
        // else {
        // // TODO: Mask is not supported yet!
        // }
        
        if ($key_total == 0) {
            if ($model->len_max < 4) {
                $model->addError('len_max', 'This generator requires at least 4 characters.');
            } else {
                $model->addError('charset', 'At leaset one digit, one upper case, one lower case and one special char are needed.');
            }
        }
        
        return $key_total;
    }
}
