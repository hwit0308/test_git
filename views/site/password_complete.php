<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>営業支援システム 管理サイト</title>
    <link href="<?= Yii::$app->request->baseUrl; ?>/css/common.css" rel="stylesheet" type="text/css"></link>
    <link href="<?= Yii::$app->request->baseUrl; ?>/css/aeon.css" rel="stylesheet" type="text/css"></link>
    <link href="<?= Yii::$app->request->baseUrl; ?>/js/jquery-2.0.3.min.js" rel="stylesheet" type="text/css"></link>
    </head>
    <body>
        <div id="AllWidth">
            <div id="wrap">
              <div id="loginBox" class="space_1">
                <h1 class="title"><a href="javascript:void(0)"><img src="<?= Yii::$app->request->baseUrl; ?>/img/logo_sp.jpg" alt="イオンデジタルワールド" title="イオンデジタルワールド" /></a></h1>
                <p>契約申込管理</p>
                <form action="<?= Url::to(['/goodMaster/default/index']); ?>" novalidate="novalidate" id="StaffLoginForm" method="get" accept-charset="utf-8">
                  <div class="searchNoData">
                    <p>パスワードの変更</p>
                  </div>
                  <div class="loginContent">
                    <span>パスワードの変更が完了しました。</span>
                  </div>
                  <input  class="btnGray" type="submit" value="契約申込管理サイトトップへ"/>
                </form>
              </div>
            </div>
            <!-- FOOTER -->
            <div id="foot">
              <div id="footCopy">Copyright © AEON RETAIL CO.,LTD. All rights reserved.</div>
            </div>
            <!-- /FOOTER --> 
        </div>
    </body>
</html>