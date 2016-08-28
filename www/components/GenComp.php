<?php
namespace app\components;

use Yii;

class GenComp extends \yii\base\Component
{

    public static function getKeyTotal(&$model, $simpleMode)
    {
        $genClassName = '\app\components\generator\\' . ucfirst($model->gen->name);
        
        if (method_exists($genClassName, __FUNCTION__)) {
            return call_user_func([
                $genClassName,
                __FUNCTION__
            ], $model, $simpleMode);
        }
        
        // Default implementation
        $key_total = 0;
        
        if ($simpleMode) {
            for ($len = $model->len_min; $len <= $model->len_max; $len ++)
                $key_total += pow(strlen($model->charset_1), $len);
        } else {
            $charLenMap = [
                '?l' => 26,
                '?u' => 26,
                '?d' => 10,
                '?s' => 33,
                '?a' => 95,
                '?1' => strlen($model->charset_1),
                '?2' => strlen($model->charset_2),
                '?3' => strlen($model->charset_3),
                '?4' => strlen($model->charset_4)
            ];
            
            for ($len = $model->len_min; $len <= $model->len_max; $len ++) {
                $charLen = 1;
                for ($l = 1; $l <= $len; $l ++)
                    $charLen *= isset($charLenMap[$model->maskChar[$l]]) ? $charLenMap[$model->maskChar[$l]] : 1;
                $key_total += $charLen;
            }
        }
        
        return $key_total;
    }
}