<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Image;
use common\models\AeonbbApplyTbl;

class ImageEditController extends Controller {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Displays images
     *
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = false;
        $applyTbl = new AeonbbApplyTbl();
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $imagesPath = Yii::$app->params['imagesPath']; // 画像保存先指定
        $tmpImagesPath = Yii::$app->params['tmpImagesPath']; // 一時的画像保存先指定
        $applyId = $request->getQueryParam('apply_id');
        
        $data = [];

        if (isset($applyId)) {
           $data = $applyTbl->findOne(['apply_id' => $applyId]);
        }
        
        if(count($data) > 0) {
            $n = $request->getQueryParam('n') ? $request->getQueryParam('n') : '';
            $t = $request->getQueryParam('t') ? $request->getQueryParam('t') : '';

            $result = '';
            if($t == 1 && $session->has("img_{$applyId}_{$n}")) {
                $result = $session->get("img_{$applyId}_{$n}");
            } else {
                if (!empty($applyId) && !empty($n)) {
                    $imageFile = Image::getListEditImageFiles($applyId, $n, $imagesPath, $tmpImagesPath);
                    if (isset($imageFile[0]) && !empty($imageFile[0])) {
                        $result = $imageFile[0];
                    }
                }
            }

            if(!empty($result)) {
                $contents = file_get_contents($result);
                header('Content-type: image/jpeg');
                echo $contents;
            } else {
                Yii::$app->response->redirect(array('/site/error'));
            }
        } else {
            Yii::$app->response->redirect(array('/site/error'));
        }
    }
}
