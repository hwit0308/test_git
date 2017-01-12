<?php
namespace backend\modules\apply\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\OptMst;
use common\models\ApplyTbl;
use backend\models\FormSearchApply;
use common\models\ZipcodeMst;
use yii\filters\VerbFilter;

/**
 * Site controller
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
                        'actions' => ['index' ,'detail' ,'mail-detail' ,'mail-success'],
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
     /*
     * view list apply
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 02/02/2016
     */
    
    public function actionIndex()
    {
        $formSearch = new FormSearchApply();
        $request = Yii::$app->request;
        $param = $request->queryParams;
        $formSearch->load($param);
        $dataProvider = $formSearch->getListApply();
        return $this->render('index', ['dataProvider' => $dataProvider, 'formSearch' => $formSearch]);
    }
    
    /*
     * view detail apply
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 02/02/2016
     */
    public function actionDetail($applyId)
    {
        $request = Yii::$app->request;
        $apply = new ApplyTbl();
        $optMst = new OptMst();
        $dataDb = $apply->getDetail($applyId);
        if (empty($dataDb)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $dataDb['sim_opt'] = $optMst->renderSimOpt($dataDb['apply_sim_opt'], $dataDb['apply_jan']);
        $dataZipcode = ZipcodeMst::findOne($dataDb['apply_zip']);
        $dataDb['zip_pref'] = !empty($dataZipcode->zip_pref) ? $dataZipcode->zip_pref : '';
        if ($request->isPost) {
            //update status
            $dataPost = $request->Post();
            $apply->changeStatus($dataPost, $applyId);
            Yii::$app->response->redirect(['/apply/default/detail', 'applyId' => $applyId]);
        }
        return $this->render('detail', [
            'model' => $apply,
            'data' => $dataDb,
        ]);
    }
    
    /*
     * view detail mail
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 23/02/2016
     */
    
    public function actionMailDetail($applyId)
    {
        $request = Yii::$app->request;
        $apply = new ApplyTbl();
        $dataDb = $apply->findOne(['apply_id' => $applyId]);
        if (empty($dataDb)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        if (!isset($dataDb->apply_mail)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        if ($request->isPost) {
            $dataPost = $request->post();
            $dataDb->apply_mail = $dataPost['ApplyTbl']['apply_mail_resend'];
            $dataDb->setAttributesFromDb();
            $dataDb->scenario  = ApplyTbl::SCENARIO_BACKEND;
            if ($dataDb->validate()) {
                //send email
                Yii::$app->mailer->compose(['text' => 'mail_images_retransmission'], ['data' => $dataDb->toArray()])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($dataDb->apply_mail)
                    ->setSubject('［イオンデジタルワールド］お申し込み受け付け')
                    ->send();
                //update email
                $apply->updateEmail($dataDb);
                Yii::$app->response->redirect(['/apply/default/mail-success', 'applyId' => $applyId]);
            }
        }
        return $this->render('mail_detail', [
            'dataDb' => $dataDb
        ]);
    }
    
    /*
     * view send mail success
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 23/02/2016
     */
    
    public function actionMailSuccess($applyId)
    {
        return $this->render('mail_success', [
            'applyId' => $applyId
        ]);
    }
}
