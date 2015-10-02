<?php

namespace app\modules\api;

use yii\base\BootstrapInterface;

class Api extends \yii\base\Module implements BootstrapInterface
{

    public $controllerNamespace = 'app\modules\api\controllers';

    private static $_defaultVersion = 'v1';

    public static function getDefaultVersion()
    {
        return self::$_defaultVersion;
    }

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => [
                    'api/v1/default'
                ]
            ]
        ], false);
    }

    function init()
    {
        parent::init();
        
        $this->modules = [
            'v1' => 'app\modules\api\versions\v1\ApiV1'
        ];
    }
}
