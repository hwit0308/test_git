<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8"/>        
        <title><?= $this->title;?></title>
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body>        
        <div class="wrapper">
            <div class="header section">
                <div class="container">
                    <h1 class="logo">
                        <a href="javascript:void(0)"><img src="<?=Yii::$app->request->baseUrl?>/img/logo_sp.jpg" alt="AEON digital world" title="AEON"></a>
                    </h1>
                </div>
            </div><!-- end header -->

            <?= $content ?>

        </div><!-- end wrapper -->
    </body>
    <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>