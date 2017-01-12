<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;

class SuccessController extends Controller
{
    /*
     * Action success add
     *
     * @author Hiennv6244 <hienn6244@co-well.com.vn>
     */
    
    public function actionAddInvite()
    {
        $this->layout = 'user';
        return $this->render('add_invite');
    }
    
    /*
     * Action success forgot
     *
     * @author Hiennv6244 <hienn6244@co-well.com.vn>
     */
    
    public function actionForgot()
    {
        $this->layout = 'user';
        return $this->render('forgot');
    }
    
    /*
     * Action success forgot
     *
     * @author Hiennv6244 <hienn6244@co-well.com.vn>
     */
    
    public function actionResetPass()
    {
        $this->layout = 'user';
        return $this->render('reset-pass');
    }
}
