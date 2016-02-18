<?php
namespace app\modules\api\common\components;

use app\components\AppComp;

class ApiComp extends \yii\base\Component
{

    /**
     *
     * @return string
     */
    public static function getVendorPath()
    {
        return AppComp::getVendorPath();
    }

    /**
     *
     * @return string
     */
    public static function getDepPath()
    {
        return AppComp::getDepPath();
    }
}