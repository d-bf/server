<?php
namespace app\modules\api\common\controllers;

use app\modules\api\common\controllers;
use yii\helpers\Json;
use app\modules\api\common\components\ApiComp;

class CrackController extends Controller
{

    /**
     * Get crack's information
     */
    public function actionInfo()
    {
        $reqData = \Yii::$app->request->post();
        
        if (empty($reqData['id']) || empty($reqData['platform'])) {
            return [];
        } else {
            $crack = \Yii::$app->db->createCommand("SELECT c.id AS id, c.gen_id AS gen_id, c.gen_config AS gen_config, c.algo_id AS algo_id, a.name AS algo_name, c.len_min AS len_min, c.len_max AS len_max, c.charset_1 AS charset1, c.charset_2 AS charset2, c.charset_3 AS charset3, c.charset_4 AS charset4, c.mask AS mask, c.target AS target, c.has_dep AS has_dep  FROM {{%crack}} c JOIN {{%algorithm}} a ON (c.id = :crackId AND a.id = c.algo_id)", [
                ':crackId' => $reqData['id']
            ])->queryOne(\PDO::FETCH_ASSOC);
            
            $response = [];
            
            if ($crack) {
                // Get cracker with embedded generator
                $cracker = \Yii::$app->db->createCommand("SELECT c.name AS name, cg.config AS config FROM {{%platform}} p JOIN {{%cracker_plat}} cp ON (p.name = :platform AND cp.plat_id = p.id) JOIN {{%cracker_gen}} cg ON (cg.cracker_id = cp.cracker_id AND cg.gen_id = :genId) JOIN {{%cracker_algo}} ca ON (ca.cracker_id = cg.cracker_id AND ca.algo_id = :algoId) JOIN {{%cracker}} c ON (c.id = ca.cracker_id)", [
                    ':platform' => $reqData['platform'],
                    ':genId' => $crack['gen_id'],
                    ':algoId' => $crack['algo_id']
                ])->queryOne(\PDO::FETCH_ASSOC);
                
                if ($cracker) { // Cracker with embedded generator
                    $response['id'] = $crack['id'];
                    $response['type'] = 'embed';
                    $response['generator'] = '';
                    $response['cracker'] = $cracker['name'];
                    $response['cmd_generator'] = '';
                    $response['cmd_cracker'] = str_replace([
                        'ALGO_ID',
                        'ALGO_NAME',
                        'LEN_MIN',
                        'LEN_MAX',
                        ',"CONF_GEN"',
                        ',"CHAR1"',
                        ',"CHAR2"',
                        ',"CHAR3"',
                        ',"CHAR4"',
                        'MASK'
                    ], [
                        isset($crack['algo_id']) ? $crack['algo_id'] : '',
                        isset($crack['algo_name']) ? $crack['algo_name'] : '',
                        isset($crack['len_min']) ? $crack['len_min'] : '',
                        isset($crack['len_max']) ? $crack['len_max'] : '',
                        empty($crack['gen_config']) ? '' : ',"' . implode(Json::decode($crack['gen_config'], true), '","') . '"',
                        empty($crack['charset1']) ? '' : ',"-1","' . self::scapeChars($crack['charset1']) . '"',
                        empty($crack['charset2']) ? '' : ',"-2","' . self::scapeChars($crack['charset2']) . '"',
                        empty($crack['charset3']) ? '' : ',"-3","' . self::scapeChars($crack['charset3']) . '"',
                        empty($crack['charset4']) ? '' : ',"-4","' . self::scapeChars($crack['charset4']) . '"',
                        isset($crack['mask']) ? $crack['mask'] : ''
                    ], $cracker['config']);
                    $response['target'] = $crack['target'];
                    $response['has_dep'] = ! empty($crack['has_dep']);
                } else {
                    // Get cracker with external generator
                    $crackerGenerator = \Yii::$app->db->createCommand("SELECT c.name AS c_name, c.config AS c_config, c.input_mode AS input_mode, g.name AS g_name, g.config AS g_config FROM {{%platform}} p JOIN {{%cracker_plat}} cp ON (p.name = :platform AND cp.plat_id = p.id) JOIN {{%cracker}} c ON (c.input_mode > :inputMode AND c.id = cp.cracker_id) JOIN {{%cracker_algo}} ca ON (ca.algo_id = :algoId AND ca.cracker_id = c.id) JOIN {{%gen_plat}} gp ON (gp.plat_id = cp.plat_id AND gp.gen_id = :genId) JOIN {{%generator}} g ON (g.id = gp.gen_id)", [
                        ':platform' => $reqData['platform'],
                        ':inputMode' => ((stripos($reqData['platform'], '_win') === false) ? 0 : 1), // Win OS supports stdin but not infile with mkfifo
                        ':algoId' => $crack['algo_id'],
                        ':genId' => $crack['gen_id']
                    ])->queryOne(\PDO::FETCH_ASSOC);
                    
                    if ($crackerGenerator) { // Cracker with external generator
                        $response['id'] = $crack['id'];
                        
                        if ($crackerGenerator['input_mode'] == 3) // Infile & stdin
                            $response['type'] = 'stdin'; // Use stdin as default
                        elseif ($crackerGenerator['input_mode'] == 2) // Stdin
                            $response['type'] = 'stdin';
                        elseif ($crackerGenerator['input_mode'] == 1) // Infile
                            $response['type'] = 'infile';
                        
                        $response['generator'] = $crackerGenerator['g_name'];
                        $response['cracker'] = $crackerGenerator['c_name'];
                        
                        $crackerGenerator['g_config'] = Json::decode($crackerGenerator['g_config'], true);
                        $crackerGenerator['g_config'] = Json::encode($crackerGenerator['g_config'][$response['type']]);
                        $crackerGenerator['c_config'] = Json::decode($crackerGenerator['c_config'], true);
                        $crackerGenerator['c_config'] = Json::encode($crackerGenerator['c_config'][$response['type']]);
                        
                        $response['cmd_generator'] = str_replace([
                            'LEN_MIN',
                            'LEN_MAX',
                            ',"CONF_GEN"',
                            ',"CHAR1"',
                            ',"CHAR2"',
                            ',"CHAR3"',
                            ',"CHAR4"',
                            'MASK'
                        ], [
                            isset($crack['len_min']) ? $crack['len_min'] : '',
                            isset($crack['len_max']) ? $crack['len_max'] : '',
                            empty($crack['gen_config']) ? '' : ',"' . implode(Json::decode($crack['gen_config'], true), '","') . '"',
                            empty($crack['charset1']) ? '' : ',"-1","' . self::scapeChars($crack['charset1']) . '"',
                            empty($crack['charset2']) ? '' : ',"-2","' . self::scapeChars($crack['charset2']) . '"',
                            empty($crack['charset3']) ? '' : ',"-3","' . self::scapeChars($crack['charset3']) . '"',
                            empty($crack['charset4']) ? '' : ',"-4","' . self::scapeChars($crack['charset4']) . '"',
                            isset($crack['mask']) ? $crack['mask'] : ''
                        ], $crackerGenerator['g_config']);
                        
                        $response['cmd_cracker'] = str_replace([
                            'ALGO_ID',
                            'ALGO_NAME'
                        ], [
                            isset($crack['algo_id']) ? $crack['algo_id'] : '',
                            isset($crack['algo_name']) ? $crack['algo_name'] : ''
                        ], $crackerGenerator['c_config']);
                        
                        $response['target'] = $crack['target'];
                        $response['has_dep'] = ! empty($crack['has_dep']);
                    }
                }
            }
            
            return $response;
        }
    }

    public function actionDep()
    {
        $reqData = \Yii::$app->request->post();
        
        if (! empty($reqData['id'])) {
            $filePath = ApiComp::getDepPath() . $reqData['id'];
            if (file_exists($filePath)) {
                return \Yii::$app->getResponse()->sendFile($filePath, md5_file($filePath));
            }
        }
        
        return '';
    }

    /**
     * Scape crack's special characters
     *
     * @param string $chars            
     * @return string
     */
    private function scapeChars($chars)
    {
        return str_replace([
            '\\',
            '"',
            '?'
        ], [
            '\\\\',
            '\\"',
            '??'
        ], $chars);
    }
}