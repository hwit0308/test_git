<?php
use yii\helpers\Url;
?>
<header>
    <section>
        <nav>
            <ul>
                <li><?= Yii::$app->user->identity->staff_name ?></li>
                <li><a href="<?= Url::to(['/site/logout']) ?>" class="simpleBtn">ログアウト</a></li>
            </ul>
        </nav>
        <div class="btBoder"></div>
    </section>
    <ul>
        <li><h1><a href="javascript:void(0)"><img src="<?=Yii::$app->request->baseUrl?>/img/logo_sp.jpg" alt="イオンデジタルワールド" title="イオンデジタルワールド" /></a></h1></li>
        <li><span class="title">契約申込管理</span></li>
    </ul>
</header>