<?php
namespace app\components;

use Yii;

class AppComp extends \yii\base\Component
{

    /**
     *
     * @return string
     */
    public static function getStoragePath()
    {
        return Yii::$app->basePath . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR;
    }

    /**
     *
     * @return string
     */
    public static function getVendorPath()
    {
        return self::getStoragePath() . 'vendor' . DIRECTORY_SEPARATOR;
    }

    /**
     *
     * @return string
     */
    public static function getDepPath()
    {
        return self::getStoragePath() . 'crack' . DIRECTORY_SEPARATOR . 'dep' . DIRECTORY_SEPARATOR;
    }

    /**
     *
     * @return string
     */
    public static function getPublicPath()
    {
        return self::getStoragePath() . 'public' . DIRECTORY_SEPARATOR;
    }
}