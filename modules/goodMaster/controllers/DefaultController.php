<?php

namespace backend\modules\goodMaster\controllers;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\GoodsMst;
use yii\filters\VerbFilter;
use arturoliveira\ExcelView;
use backend\models\FormGoods;
use backend\models\FormImportCSV;
use common\models\GoodsOpt;
use common\models\GoodsPlan;
use common\models\OptMst;

    /**
    * Goods Controller
    *
    * @since : 01/02/2016
    * @author : Le Ngoc Hoan <hoanln6636@seta-asia.com.vn>
    *
    */

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index' ,'detail', 'import', 'message', 'save', 'drop'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
    * Action Index
    *
    * @since : 01/02/2016
    * @author : Le Ngoc Hoan <hoanln6636@seta-asia.com.vn>
    *
    */

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $goodsMst = new GoodsMst();
        $param = $request->queryParams;
        if (!empty($param['GoodsMst'])) {
            $goodsMst->setAttributes($param['GoodsMst']);
        }
        $dataProvider = $goodsMst->getAllData();
        if ($request->isPost) {
            $post = $request->post();
            if ($post['csv'] == 'export') {
                $dataProvider = $goodsMst->getDataExportCSV();
                ExcelView::widget([
                    'dataProvider' => $dataProvider,
                    'fullExportType'=> 'csv',
                    'grid_mode' => 'export',
                    'fullExportConfig' => [
                            ExcelView::FULL_CSV => ['filename' => 'GoodsMst', 'noExportColumns' => '1'],
                    ],
                ]);
            }
            if ($post['csv'] == 'delete') {
                $goods = new FormGoods();
                $message = '商品削除する時にエラーが発生しました。<br/>最初からやり直してください。';
                if ($goods->deleteProduct($post['selection'])) {
                    $message = '商品情報の削除が完了しました。';
                }
                Yii::$app->session->setFlash('message_delete', $message);
            }
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'goodsMst' => $goodsMst,
        ]);
    }

    /*
    * Action Detail
    *
    * @since : 01/02/2016
    * @author : Le Ngoc Hoan <hoanln6636@seta-asia.com.vn>
    *
    */

    public function actionDetail($goodsJan)
    {
        $goods = new FormGoods();
        $goodsItem = $goods->getDetail($goodsJan);
        if (empty($goodsItem)) {
            Yii::$app->response->redirect(['/error/error']);
        }
        return $this->render('detail', [
            'goodsItem' => $goodsItem
        ]);
    }

    /*
    * Action Import CSV
    *
    * @since : 03/02/2016
    * @author : Le Ngoc Hoan <hoanln6636@seta-asia.com.vn>
    *
    */

    public function actionImport()
    {
        $session = Yii::$app->session;
        $model = new FormImportCSV();
        $lineErrors = 0;
        $errorsCount = 0;
        $successCount = 0;
        $messageErrors = [];
        $errors = null;
        $line = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                if ($model->file) {
                    $handle = fopen($model->file->tempName, "r");
                    $header = null;
                    while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
                        // check header file
                        if (!$header) {
                            $header = $fileop;
                            if (count($fileop) != 12) {
                                break;
                            }
                        }
                        $lineErrors++;
                        if (count($fileop) == 12 && $model->saveData($fileop)) {
                            $successCount++;
                        } elseif($line > 0) { // case fail, count error
                            $messageErrors[] = $lineErrors;
                            $errorsCount++;
                        }
                        $line++;
                    }
                    if ($header && count($header) != 12) {
                        Yii::$app->session->setFlash('error_number_csv', 'CSVファイルの項目数が正しくありません。ファイルをご確認ください。');
                    } else {
                        // save to session
                        $session->set('messages', $messageErrors);
                        $session->set('errors', $errorsCount);
                        $session->set('success', $successCount);
                        $this->redirect('message');
                    }
                }
            }
        }

        return $this->render('import', [
            'model' => $model,
            'errors' => $errors,
        ]);
    }

    /**
    * Action Message
    *
    * @since : 04/02/2016
    * @author : Le Ngoc Hoan <hoanln6636@seta-asia.com.vn>
    *
    */

    public function actionMessage()
    {
        $session = Yii::$app->session;
        $messageErrors = $session->get('messages');
        $errorsCount = $session->get('errors');
        $successCount = $session->get('success');
        
        unset($session['messages']);
        unset($session['errors']);
        unset($session['success']);
        
        return $this->render('message', [
            'messageErrors' => $messageErrors,
            'errorsCount' => $errorsCount,
            'successCount' => $successCount,
            ]);
    }
    
    /**
    * Action save
    *
    * @date : 18/03/2016
    * @author : Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
    *
    */
    
    public function actionSave($goodsJan = null)
    {
        $request = Yii::$app->request;
        $model = new FormGoods();
        $flag = 0;
        if (!empty($goodsJan)) {
            $model = $model->renderDataFromDb($goodsJan);
            if (empty($model)) {
                return Yii::$app->response->redirect(['/error/error']);
            }
            $model->scenario  = FormGoods::SCENARIO_EDIT;
            $message = '商品情報の編集が完了しました。';
            $flag = 1;
        } else {
            $model->scenario  = FormGoods::SCENARIO_ADD;
            $message = '商品情報の登録が完了しました。';
        }
        if ($request->isPost) {
            $dataPost = $request->Post();
            if (!is_array($dataPost['FormGoods']['plan_code_left'])) {
                $dataPost['FormGoods']['plan_code_left'] = [];
            }
            if (!is_array($dataPost['FormGoods']['plan_code_right'])) {
                $dataPost['FormGoods']['plan_code_right'] = [];
            }
            if (!is_array($dataPost['FormGoods']['plan_code_button'])) {
                $dataPost['FormGoods']['plan_code_button'] = [];
            }
            $dataPost['FormGoods']['plan_code'] = array_merge($dataPost['FormGoods']['plan_code_left'],
                    $dataPost['FormGoods']['plan_code_right'], $dataPost['FormGoods']['plan_code_button']);
            $model->setAttributes($dataPost['FormGoods']);
            if ($model->validate()) {
                $model->saveData($goodsJan);
                Yii::$app->session->setFlash('message_success', $message);
                return Yii::$app->response->redirect(['/goodMaster/default/detail', 'goodsJan' => $model->goods_jan]);
            }
        }
        return $this->render('save', [
                'model' => $model,
                'flag' => $flag
            ]);
    }
    
    /**
    * Action save
    *
    * @date : 21/07/2016
    * @author : Nguyen Van Hien <hiennv6244@seta-asia.com.vn>
    *
    */
    
    public function actionDrop($goodsJan)
    {
        $request = Yii::$app->request;
        if (!isset($goodsJan)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $goodsMst = GoodsMst::findOne(['goods_jan' => $goodsJan]);
        if (!$goodsMst) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $goodsPlan = new GoodsPlan(['goods_jan' => $goodsJan]);
        $planList = $goodsPlan->getListPlan();
        $optMst = new OptMst();
        $listOptMst = $optMst->getListOption($goodsJan);
        $listOption = $optMst->renderListOption($listOptMst);
        if (count($planList) == 0 && count($listOption) == 0) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        if ($request->isPost) {
            $dataPost = $request->Post();
            if ((!isset($dataPost['drop']['goodsJan']) && $dataPost['drop']['goodsJan'] != $goodsJan) || (!$goodsMst)) {
                return Yii::$app->response->redirect(['/error/error']);
            }
            $option = '';
            foreach ($dataPost['drop'] as $key => $value) {
                if (strpos($key, 'opt') !== false) {
                    $option  = $option . ',' .$value;
                }
            }
            $option =  ltrim($option, ",");
            $listPlan = isset($dataPost['drop']['listPlan']) ? $dataPost['drop']['listPlan'] : [];
            $model = new FormGoods(['goods_jan' => $goodsJan, 'list_plan' => $listPlan, 'list_option' => $option]);
            if ($model->validateDrop()) {
                if ($model->saveDrop()) {
                    Yii::$app->session->setFlash('message_success', '商品情報の編集が完了しました。');
                    return Yii::$app->response->redirect(['/goodMaster/default/detail', 'goodsJan' => $goodsJan]);
                } else {
                    return Yii::$app->response->redirect(['/goodMaster/default/drop', 'goodsJan' => $goodsJan]);
                }
            } else {
                Yii::$app->session->setFlash('error_drop', 'この商品のプランとオプションデータが変更されました。ページをリロードして、やり直してください。');
            }
        }
        
        return $this->render('drop', [
                'goodsJan' => $goodsJan,
                'planList' => $planList,
                'listOption' => $listOption
            ]);
    }
}