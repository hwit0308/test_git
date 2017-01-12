<?php
namespace backend\modules\goodMaster\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\PlanMst;

/**
 * Site controller
 */
class PlanController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'detail', 'save'],
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
     * view list plan
     * @Author To Ngoc Duy
     * @Date 03/02/2016
     */

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $formSearch = new PlanMst();
        $param = $request->queryParams;
        if (!empty($param['PlanMst'])) {
            $formSearch->setAttributes($param['PlanMst']);
        }
        $dataProvider = $formSearch->getData();
        if ($request->isPost) {
            $post = $request->post();
            if (isset($post['selection'])) {
                $id = $post['selection'];
                $message = '商品削除する時にエラーが発生しました。<br/>最初からやり直してください。';
                if ($formSearch->deletePland($id)) {
                    $message = 'プラン情報の削除が完了しました。';
                }
                Yii::$app->session->setFlash('message_delete', $message);
            }
        }
        return $this->render('index', ['dataProvider' => $dataProvider, 'formSearch' => $formSearch]);
    }

    /**
     * view plan detail
     * @Author To Ngoc Duy
     * @Date 03/02/2016
     */

    public function actionDetail($planId)
    {
        $request = Yii::$app->request;
        $model = PlanMst::findOne(['plan_code' => $planId]);
        if (!$model) {
            Yii::$app->response->redirect(['/error/error']);
        }
        return $this->render('detail', ['model' => $model]);
    }
    
    /**
     * Add + Edit plan
     * @Author Do Duy Duc
     * @date 17/03/2016
    */
    public function actionSave($planId = null)
    {
        $request = Yii::$app->request;
        if ($planId == null) {
            $model = new PlanMst();
            $message = 'プラン情報の登録が完了しました。';
        } else {
            $model = PlanMst::findOne(['plan_code' => $planId]);
            if (empty($model)) {
                return Yii::$app->response->redirect(['/error/error']);
            }
            $message = 'プラン情報の編集が完了しました。';
        }
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                if ($model->savePlan($planId)) {
                    Yii::$app->session->setFlash('message_success', $message);
                    return Yii::$app->response->redirect(['/goodMaster/plan/detail', 'planId' => $model->plan_code]);
                } else {
                    return Yii::$app->response->redirect(['/error/error']);
                }
            }
        }
        return $this->render('save', ['model' => $model]);
    }
}
