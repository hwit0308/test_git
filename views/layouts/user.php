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
        <link href="<?= Yii::$app->request->baseUrl; ?>/css/custom.css" rel="stylesheet" type="text/css"></link>
        <link href="<?= Yii::$app->request->baseUrl; ?>/js/jquery-2.0.3.min.js" rel="stylesheet" type="text/css"></link>
    </head>
    <body>
        <div id="AllWidth">
            <?= $content ?>
            <!-- FOOTER -->
            <?= \Yii::$app->view->renderFile('@app/views/element/footer.php'); ?>
            <!-- /FOOTER --> 
        </div>
    </body>
</html>