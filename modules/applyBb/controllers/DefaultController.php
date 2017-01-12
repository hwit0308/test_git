<?php
namespace backend\modules\applyBb\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\OptMst;
use common\models\AeonbbApplyTbl;
use common\models\ShareplanOption;
use backend\models\FormSearchApplyBb;
use common\models\ZipcodeMst;
use yii\filters\VerbFilter;
use arturoliveira\ExcelView;

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
        $formSearch = new FormSearchApplyBb();
        $request = Yii::$app->request;
        $param = $request->queryParams;
        $formSearch->load($param);
        $dataProvider = $formSearch->getListApply();
        if ($request->isPost) {
            $modelApplyBb = new AeonbbApplyTbl();
            $dataProvider = $modelApplyBb->getDataExportCSV();
            ExcelView::widget([
                'dataProvider' => $dataProvider,
                'fullExportType'=> 'csv',
                'grid_mode' => 'export',
                'fullExportConfig' => [
                        ExcelView::FULL_CSV => ['filename' => 'ApplyBb', 'noExportColumns' => '1'],
                ],
            ]);
        }
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
        $apply = new AeonbbApplyTbl();
        $optMst = new OptMst();
        $dataDb = $apply->getDetail($applyId);
        if (empty($dataDb)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $dataDb['sim_opt'] = $optMst->renderSimOpt($dataDb['apply_sim_opt'], $dataDb['apply_jan']);
        $optionShare = ShareplanOption::findAll(['apply_id' => $applyId]);
        if ($request->isPost) {
            //update status
            $dataPost = $request->Post();
            $apply->changeStatus($dataPost, $applyId);
            Yii::$app->response->redirect(['/applyBb/default/detail', 'applyId' => $applyId]);
        }
        return $this->render('detail', [
            'model' => $apply,
            'data' => $dataDb,
            'optionShare' => $optionShare
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
        $apply = new AeonbbApplyTbl();
        $dataDb = $apply->findOne(['apply_id' => $applyId]);
        if (empty($dataDb)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $optionShare = ShareplanOption::findAll(['apply_id' => $applyId]);
        if ($request->isPost) {
            $dataPost = $request->post();
            $dataDb->apply_mail_resend = $dataDb->apply_mail = $dataPost['AeonbbApplyTbl']['apply_mail_resend'];
            $dataDb->scenario  = AeonbbApplyTbl::SCENARIO_BACKEND;
            if ($dataDb->validate()) {
                //send email
                Yii::$app->mailer->compose(['text' => 'mail_images_retransmission_bb'], ['data' => $dataDb->toArray(),'optionShare' => $optionShare])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($dataDb->apply_mail)
                    ->setSubject('お申し込み内容を確認ください')
                    ->send();
                //update email
                $apply->updateEmail($dataDb);
                Yii::$app->response->redirect(['/applyBb/default/mail-success', 'applyId' => $applyId]);
            }
        }
        return $this->render('mail_detail', [
            'dataDb' => $dataDb,
            'optionShare' => $optionShare
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
