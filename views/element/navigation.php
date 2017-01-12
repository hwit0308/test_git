<?php
    use yii\helpers\Url;
?>
<td id="side"><div class="sideBox_list">
        <h3 class="titlebarSide_list">マスタ管理</h3>
        <ul>
            <li class="btnSidemenu"> <a href="<?= Url::to(['/goodMaster/default/index'])?>">商品情報照会</a> </li>
            <li class="btnSidemenu"> <a href="<?= Url::to(['/goodMaster/plan/index'])?>">プランマスタ管理</a> </li>
            <li class="btnSidemenu"> <a href="<?= Url::to(['/goodMaster/option/index'])?>">オプションマスタ管理</a> </li>
        </ul>
    </div>

    <!-- /.sideBox_list --> 
    <div class="sideBox_list">
        <h3 class="titlebarSide_list">申込情報管理</h3>
        <ul>
            <li class="btnSidemenu"> <a href="<?= Url::to(['/apply/default/index'])?>">契約者申込照会</a> </li>
            <li class="btnSidemenu" style="overflow-wrap: break-word "> <a href="<?= Url::to(['/applyBb/default/index'])?>">プラン変更・オプション追加申込照会</a> </li>
        </ul>
    </div>

    <!-- /.sideBox_list --> 
    <?php if (Yii::$app->user->getIdentity()->staff_auth_level == 1) : ?>
    <div class="sideBox_list">
        <h3 class="titlebarSide_list">ユーザ管理</h3>
        <ul>
            <li class="btnSidemenu"> <a href="<?= Url::to(['/staff/default/index'])?>">ユーザ情報照会</a> </li>
            <li class="btnSidemenu"> <a href="<?= Url::to(['/staff/default/update'])?>">新規ユーザ追加</a> </li>
        </ul>
    </div>
    <?php endif;?>
    <!-- /.sideBox_list --></td>