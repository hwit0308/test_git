<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use backend\models\ChangePassForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'password-complete'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['password'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return !empty(Yii::$app->session['user']);
                        }
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = false;
        if (!\Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['/goodMaster/default/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $login = $model->login()) {
            if ($login === 'password_expired') {
                return Yii::$app->response->redirect(['/site/password']);
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionPassword()
    {
        $this->layout = false;
        $session = Yii::$app->session;
        $user = $session->get('user');
        $model = new ChangePassForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->changePass()) {
            $session->remove('user');
            return Yii::$app->response->redirect(['/site/password-complete']);
        }
        
        return $this->render('password', [
            'model' => $model,
        ]);
    }
    
    public function actionPasswordComplete()
    {
        $this->layout = false;
        return $this->render('password_complete');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
