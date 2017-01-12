<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->title;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <meta name="robots" content="noindex,nofollow,noarchive" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <script type="text/javascript">
            var baseUrl = '<?=Yii::$app->request->baseUrl;?>';
        </script>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body>
        <div id="AllWidth">
            <?= \Yii::$app->view->renderFile('@app/views/element/header.php'); ?>
            <div id="wrap">
                <table cellpadding="0" cellspacing="0" border="0" id="contents">
                    <tr>
                        <?= \Yii::$app->view->renderFile('@app/views/element/navigation.php'); ?>
                        <?= $content ?>
                    </tr>
                </table>
            </div>
            <?= \Yii::$app->view->renderFile('@app/views/element/footer.php'); ?>
        </div><!-- end wrapper -->
    </body>
    <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>