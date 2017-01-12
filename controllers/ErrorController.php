<?php
namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Session;

class ErrorController extends Controller
{
    /*
     * Action Step 2
     *
     * @author Can Tuan Anh <Anhct6616@seta-asia.com.vn>
     */
    public function actionError()
    {
        $this->layout = 'other';
        return $this->render('error');
    }
}
