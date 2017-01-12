<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\ApplyTbl;
use common\components\Utility;
use common\models\OptMst;

$listPlanId = [];
if (count($planList) > 0) {
    foreach ($planList as $key => $value) {
        $listPlanId[] = "'" . $value['plan_code'] . "'";
    }
}
$listPlanId = implode(',', $listPlanId);
$this->title = '商品プラン・オプション並び替え設定';
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<td id="main"><!-- main contents -->
    <?php $form = ActiveForm::begin([
        'id' => 'drop'
    ]); ?>
    <input type="hidden" id="goodsJan" value='<?= $goodsJan;?>' name="drop[goodsJan]">
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">商品プラン・オプション並び変え設定</h2>
    </div>
    <!-- /page title -->
    <div class="mBoxitem_table">
        <?php if (Yii::$app->session->hasFlash('error_drop')) : ?>
            <p class="txtWarning"><?= Yii::$app->session->getFlash('error_drop') ?></p>
        <?php endif; ?>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>プラン</th>
                    <td>
                        <!--list can be move-->
                        <?php if (count($planList) > 0) : ?>
                        <input type="hidden" id="listPlan" value="<?= $listPlanId;?>" name="drop[listPlan]">
                        <ul id="sortableTvalu1" class="sortableTvalu ui-sortable">
                            <?php foreach ($planList as $key => $value) : ?>
                            <li class="ui-state-default ui-sortable-handle" plan_code="<?= "'" . $value['plan_code'] . "'";?>" plan_order="<?= $value['goods_plan_order'];?>">
                                <?= Html::encode($value['plan_name']); ?>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <?php endif;?>
                        <!--e:list can be move-->
                    </td>
                </tr>
                <tr>
                    <th>オプション</th>
                    <td>
                        <?php if (count($listOption) > 0) : ?>
                        <?php
                        $packName = 'パック無し';
                             foreach ($listOption as $key => $value) {
                                 if ($key != '000' && $key != 'special') {
                                     $packName = $value['opt_packname'];
                                     break;
                                 }
                             }
                        ?>
                        <div class="tvaluHideList">
                            <label>パック名</label>
                            <span><?= $packName; ?></span>
                        </div>
                        <?php $i = 1;?>
                        <?php foreach ($listOption as $key => $value) : ?>
                        <?php
                            $i++;
                            $listOption = [];
                        ?>
                        <ul id="sortableTvalu<?=$i?>" class="sortableTvalu ui-sortable magirnBotton">
                            <?php if (count($value['option_childrent']) > 0) : ?>
                                <?php foreach ($value['option_childrent'] as $key1 => $value1) : ?>
                                    <?php
                                        if ($key == 'special') {
                                            $opt = "('000'".','."'".$key1."')";
                                        } else {
                                            $opt = "('".$key."'".','."'".$key1."')";
                                        }
                                        $listOption[] = $opt;
                                    ?>
                                    <li class="ui-state-default ui-sortable-handle" opt="<?= $opt;?>">
                                        <?= Html::encode($value1['opt_name']); ?>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                            <?php $listOption = implode(',',$listOption);?>
                            <input type="hidden" id="opt_<?=$i;?>" value="<?= $listOption;?>" name="drop[opt_<?=$i;?>]">
                        </ul>
                        <?php endforeach;?>
                        <?php endif;?>
                    </td>
                </tr>
            </tbody></table>
    </div>
    <div class="BtnArea">
        <?= Html::submitButton('変更を保存', ['class' => 'btnGray', 'id' => 'btnDrop']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</td>
<script type="text/javascript" src="<?= Yii::$app->request->baseUrl; ?>/js/jquery-ui.js"></script>