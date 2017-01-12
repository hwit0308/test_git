<?php
namespace backend\modules\goodMaster\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\OptMst;

/**
 * Site controller
 */
class OptionController extends Controller
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

    /*
     * view list option
     * @Author To Ngoc Duy
     * @Date 04/02/2016
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $formSearch = new OptMst();
        $param = $request->queryParams;
        if (!empty($param['OptMst'])) {
            $formSearch->setAttributes($param['OptMst']);
        }
        $dataProvider = $formSearch->getAllOption();
        if ($request->isPost) {
            $post = $request->post() ;
            if (isset($post['selection'])) {
                $id = $post['selection'];
                $dataPost = '';
                foreach ($id as $value) {
                    $dataPost = $dataPost .'(' . $value . '),';
                }
                $dataPost = trim($dataPost, ",");
                $optMst = new OptMst();
                if ($optMst->countOptSpecial($dataPost) == 0) {
                    $formSearch->deleteOption($dataPost);
                    Yii::$app->session->setFlash('message_delete', 'オプション情報の削除が完了しました。');
                } else {
                    Yii::$app->session->setFlash('message_delete', '特殊なオプションは削除できません。');
                }
            }
        }
        return $this->render('index', ['dataProvider' => $dataProvider, 'formSearch' => $formSearch]);
    }

    /*
     * view option detail
     * @Author To Ngoc Duy
     * @Date 04/02/2016
     */
    public function actionDetail($packCode, $code)
    {
        $request = Yii::$app->request;
        $model = OptMst::findOne(['opt_packcode' => $packCode, 'opt_code' => $code]);
        if (!$model) {
            Yii::$app->response->redirect(['/error/error']);
        }
        return $this->render('detail', ['model' => $model]);
    }
    
    /*
     * @Action: Add + edit option
     * @Author Đỗ Duy Đức
     * @since 21/03/2016
    */
    public function actionSave($packCode = null, $code = null)
    {
        $request = Yii::$app->request;
        if ($packCode == null || $code == null) {
            $model = new OptMst();
            $message = 'オプション情報の登録が完了しました。';
        } else {
            $model = OptMst::findOne(['opt_packcode' => $packCode, 'opt_code' => $code]);
            if (empty($model)) {
                return Yii::$app->response->redirect(['/error/error']);
            }
            $message = 'オプション情報の編集が完了しました。';
        }
        if ($request->isPost) {
            $dataPost = $request->post();
            if ($model->opt_flag == 1 && (((!empty($dataPost['OptMst']['opt_packcode']) &&
                    $dataPost['OptMst']['opt_packcode'] != $model->opt_packcode)) ||
                    (!empty($dataPost['OptMst']['opt_code']) && $dataPost['OptMst']['opt_code'] != $model->opt_code))) {
                Yii::$app->session->setFlash('message_error', '特殊なオプシンは管理IDが編集できません。');
            } else {
                $model->load($request->post());
                if ($model->validate()) {
                    if ($model->saveOption($packCode, $code)) {
                        Yii::$app->session->setFlash('message_success', $message);
                        return Yii::$app->response->redirect(['/goodMaster/option/detail',
                            'packCode' => $model->opt_packcode, 'code' => $model->opt_code]);
                    } else {
                        return Yii::$app->response->redirect(['/error/error']);
                    }
                }
            }
        }
        return $this->render('save', ['model' => $model]);
    }
}
