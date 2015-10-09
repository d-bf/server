<?php

namespace app\modules\api;

use yii\base\BootstrapInterface;
use yii\web\Response;
use yii\web\Request;

class Api extends \yii\base\Module implements BootstrapInterface
{

    public $controllerNamespace = 'app\modules\api\controllers';

    protected $responseFormats = [
        'application/json' => Response::FORMAT_JSON,
        'application/xml' => Response::FORMAT_XML
    ];

    protected static $defaultVersion = 'v1';

    public static function getDefaultVersion()
    {
        return self::$defaultVersion;
    }

    public function bootstrap($app)
    {
        \Yii::$app->on(\yii\base\Application::EVENT_BEFORE_REQUEST, 
            function ($event) {
                $request = \Yii::$app->getRequest();
                
                // Enable parsing of json request
                $request->parsers = [
                    'application/json' => 'yii\web\JsonParser'
                ];
                
                // Handle response negotiation
                if (strtolower(strstr($request->getPathInfo() . '/', '/', true)) == 'api') { // It's an api module request
                    $response = \Yii::$app->getResponse();
                    $response->format = false;
                    foreach ($request->getAcceptableContentTypes() as $type => $params) { // Determine response format
                        if (isset($this->responseFormats[$type])) {
                            $response->format = $this->responseFormats[$type];
                            $response->acceptMimeType = $type;
                            $response->acceptParams = $params;
                            break;
                        }
                    }
                    if (empty($response->format)) { // Response format is not determined yet, use default format
                        $response->format = Response::FORMAT_JSON;
                        $response->acceptMimeType = 'application/json';
                        $response->acceptParams = [];
                    }
                }
            });
        
        $app->getUrlManager()->addRules(
            [
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'prefix' => 'api',
                    'rules' => [
                        '' => 'default/index',
                        [
                            'pattern' => '<api_ver:v\d+>/<controller:\w+>',
                            'route' => '<api_ver>/<controller>/index',
                            'verb' => 'POST'
                        ]
                    ]
                ]
            ], false);
    }

    function init()
    {
        parent::init();
        
        \Yii::$app->user->enableSession = false;
        
        $this->modules = [
            'v1' => 'app\modules\api\versions\v1\ApiV1'
        ];
    }
}