<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use common\models\ApplyTbl;

/**
 * Site controller
 */
class ApiController extends ActiveController
{
    public $modelClass = 'common\models\ApplyTbl';

    protected function verbs()
    {
        return [
            'success' => ['POST'],
        ];
    }

    public function init()
    {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        //$this->enableCsrfValidation = false;
    }

    /*
     * Api success
     *
     * @author Can Tuan Anh <Anhct6616@seta-asia.com.vn>
     */

    public function actionSuccess()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $dataPost = trim(file_get_contents('php://input'));
        if (empty($dataPost)) {
            \Yii::$app->response->statusCode = 400;
            return ['notify_request' => ['lid_m' => '0000', 'result' => '1000']];
        }

        $extension = '.xml';
        $dir = \yii::getAlias('@runtime') . "/upload/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = $dir . uniqid() . $extension;

        $fp = fopen($filename, "w");
        fwrite($fp, $dataPost);
        fclose($fp);

        $data = simplexml_load_file($filename);
        if (isset($data->basic) && isset($data->kaiin)) {
            $applyTbl = ApplyTbl::findOne(['apply_orderid' => $data->basic->order_id]);
            $lid_m = (int)$data->basic->lid_m;
            
            if (!$applyTbl) {
                \Yii::$app->response->statusCode = 400;
                return ['notify_request' => ['lid_m' => $lid_m, 'result' => '1000']];
            }

            $applyTbl->apply_order_id = $data->basic->order_id;
            $applyTbl->apply_result = $data->basic->result;
            $applyTbl->apply_lid_m = $data->basic->lid_m;
            $applyTbl->apply_auth_date = $data->basic->auth_date;
            $applyTbl->apply_auth_time = $data->basic->auth_time;
            $applyTbl->apply_aeonregi_id = $data->kaiin->aeonregi_id;
            $applyTbl->apply_cardexpiry = $data->kaiin->cardexpiry;
            $applyTbl->apply_approval_code = $data->kaiin->apploval_code;
            $applyTbl->apply_cocode = $data->kaiin->cocode;
            $applyTbl->apply_subcocode = $data->kaiin->subcocode;
            $applyTbl->apply_cocode = $data->kaiin->cocode;
            //$applyTbl->apply_sts = '01';
            if ($data->basic->result == '0000' || $data->basic->status == '1000') {
                $applyTbl->apply_sts = ApplyTbl::APPLY_STS_RECEIVED;
            }
            $applyTbl->apply_shop_id = Yii::$app->params['shop_id'];
            
            if ($applyTbl->save(false)) {
                Yii::info('Update success: ' . $data->basic->order_id . ', file: ' . $filename, 'api');
            } else {
                $applyTbl->logErrorsValidate('api');
            }
            return ['notify_request' => ['lid_m' => $lid_m, 'result' => '0000']];
        } else {
            \Yii::$app->response->statusCode = 400;
            return ['notify_request' => ['lid_m' => '0000', 'result' => '1000']];
        }
    }
}
