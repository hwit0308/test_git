<?php
namespace backend\modules\staff\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\StaffMst;
use common\models\User;
use backend\components\AccessRule;
use backend\models\ChangePassForm;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index', 'detail', 'update', 'changepass'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
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
     * view list staff
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 02/02/2016
     */
    
    public function actionIndex()
    {
        $staffModel = new StaffMst();
        $request = Yii::$app->request;
        $param = $request->queryParams;
        if (!empty($param['StaffMst'])) {
            $staffModel->setAttributes($param['StaffMst']);
        }
        $dataProvider = $staffModel->getListStaff();
        if ($request->isPost) {
            $post = $request->post();
            if (isset($post['selection'])) {
                $staffModel->deleteAll(['staff_id' => $post['selection']]);
                Yii::$app->session->setFlash('message_delete', 'ユーザ情報の削除が完了しました。');
            }
        }
        return $this->render('index', [
            'model' => $staffModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
    /*
     * view detail staff
     * @Author Nguyen Van Hien(hiennv6244@seta-asia.com.vn)
     * @Date 02/02/2016
     */
    public function actionDetail($staffId)
    {
        $staff = new StaffMst();
        $dataDb = $staff->findOne(['staff_id' => $staffId]);
        if (empty($dataDb)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        return $this->render('detail', [
            'data' => $dataDb,
        ]);
    }
    
    /*
     * Staff add/edit
     * @Author Can Tuan Anh(anhct6616@seta-asia.com.vn)
     * @Date 18/03/2016
     */
    public function actionUpdate($staffId = null)
    {
        $request = Yii::$app->request;
        if ($staffId == null) {
            $model = new StaffMst();
            $message = 'ユーザ情報の登録が完了しました。';
            $model->scenario = StaffMst::SCENARIO_ADD;
            $view = 'add';
        } else {
            $model = StaffMst::findOne(['staff_id' => $staffId]);
            if (empty($model)) {
                return Yii::$app->response->redirect(['/error/error']);
            }
            $message = 'ユーザ情報の編集が完了しました。';
            $view = 'edit';
        }
        if ($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                if ($staffId == null) {
                    $model->setPassword($model->staff_password);
                }
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('message_success', $message);
                    return Yii::$app->response->redirect(['/staff/default/detail', 'staffId' => $model->staff_id]);
                }
            }
        }
        return $this->render($view, ['model' => $model]);
    }

    /*
    * @Change Password
    * @Author Do Duy Duc
    * @Date 25/03/2016
    */
    public function actionChangepass($staffId = null)
    {
        if ($staffId == null) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $request = Yii::$app->request;
        $user = User::findOne(['staff_id' => $staffId]);
        if (empty($user)) {
            return Yii::$app->response->redirect(['/error/error']);
        }
        $model = new ChangePassForm($user);
        $model->scenario = ChangePassForm::SCENARIO_CHANGEPASS;
        if ($request->isPost && $model->load($request->post()) && $model->changePass()) {
            Yii::$app->session->setFlash('message_success', 'パスワードの変更が完了しました。');
            return Yii::$app->response->redirect(['/staff/default/detail', 'staffId' => $user->staff_id]);
        }
        return $this->render('changepass', ['model' => $model]);
    }
}
