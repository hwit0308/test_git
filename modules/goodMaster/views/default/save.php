<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\ApplyTbl;
use common\models\OptMst;
use common\models\PlanMst;

if ($flag == 1) {
    $textBtn = '変更を保存';
    $title = '商品情報編集';
    $textChange = '編集';
} else {
    $textBtn = '登録する';
    $title = '新規商品追加';
    $textChange = '作成';
}
$this->title = $title;
$optMst = new OptMst();
$planMst = \common\models\PlanMst::find()->all();
$optPackParent = $optMst::find()->where('opt_packcode != 000')->groupBy(['opt_packcode'])->all();
$optPack = $optMst::find()->where('opt_packcode = 000')->all();
$listPlanButton = [];
$listPlanLeft = [];
$listPlanRight = [];
$listPackParent = [];
$listPack = [];
$listPackSpecial = [];
if (count($planMst) > 0) {
    foreach ($planMst as $key => $value) {
        if (in_array($value->plan_code, PlanMst::$planCodeLeft)) {
            $listPlanLeft[$value->plan_code] = $value->plan_name;
        } elseif(in_array($value->plan_code, PlanMst::$planCodeRight)) {
            $listPlanRight[$value->plan_code] = $value->plan_name;
        } else {
            $listPlanButton[$value->plan_code] = $value->plan_name;
        }
    }
}
if (count($optPackParent) > 0) {
    foreach ($optPackParent as $key => $value) {
        $listPackParent[$value->opt_packcode] = $value->opt_packname;
    }
}
if (count($optPack) > 0) {
    foreach ($optPack as $key => $value) {
        if ($value->opt_flag == 0) {
            $listPack[$value->opt_code] = $value->opt_name;
        } else {
            $listPackSpecial[$value->opt_code] = $value->opt_name;
        }
    }
}
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon"><?= $title; ?></h2>
    </div>
    <!-- /page title -->
    <?php $form = ActiveForm::begin(); ?>
    <div class="mBoxitem_table">
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">商品情報を<?= $textChange;?>します。<br>必要事項を入力し、[<?=$textBtn?>]ボタンをクリックしてください。</div>
        </div>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th class="must">JANコード</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_jan', ['class'=>'txtbox fieldRequired ' .
                                $model->getClassField('goods_jan')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_jan']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="must">商品名 </th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_name', ['class'=>'txtbox fieldRequired ' .
                                $model->getClassField('goods_name')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_name']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>商品名２</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_name2', ['class'=>'txtbox fieldRequired ' .
                                $model->getClassField('goods_name2')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_name2']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>機種ID</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_model_id', ['class'=>'txtbox fieldRequired ' .
                                $model->getClassField('goods_model_id')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_model_id']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>SIMタイプ</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeDropDownList($model, 'goods_sim_type', ApplyTbl::$LABEL_SIM_SIZE, [
                                 'class'=>'txtbox fieldRequired '. $model->getClassField('goods_sim_type'),
                                'style' => 'width:150px', 'prompt'=>'--']); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_sim_type']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>SIM契約種別</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeDropDownList($model, 'goods_sim_class', ApplyTbl::$LABEL_SIM_TYPE, [
                                'class'=>'txtbox fieldRequired '. $model->getClassField('goods_sim_class'),
                                'style' => 'width:150px', 'prompt'=>'--']); ?>
                            <p class="fTextAssist_bottom txtWarning">
                            <?= $model->getMgsError(['goods_sim_class']); ?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>カラー</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_color', ['class'=>'txtbox fieldRequired '.
                                $model->getClassField('goods_color')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_color']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>サイズ</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_size', ['class'=>'txtbox fieldRequired '.
                                $model->getClassField('goods_size')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_size']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>メーカー名</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'goods_maker', ['class'=>'txtbox fieldRequired '.
                                $model->getClassField('goods_maker')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['goods_maker']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>商品説明</th>
                    <td><?= Html::activeTextarea($model, 'goods_decr', ['rows'=>10,
                        'cols'=>30, 'style' => 'width:600px']); ?></td>
                </tr>
            </tbody></table>
        <br>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>プラン</th>
                    <td>
                        <?php if (count($planMst)) :?>
                        <div class="itemPlan clearfix">
                            <div class="block w50">
                                <?php if(count($listPlanLeft) > 0) : ?>
                                <?= Html::activeCheckboxList($model, 'plan_code_left', $listPlanLeft, [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="item"><label>' . Html::checkbox($name, $checked, [
                                                'value' => $value, 'class' => 'sCheck' ]) .
                                                    '<span class="fLabel">' . Html::encode($label) .
                                                    '</span></label></div>';
                                        }
                                ])?> 
                                <?php endif; ?>
                            </div>
                            
                            <div class="block w50">
                                <?php if(count($listPlanRight) > 0) : ?>
                                <?= Html::activeCheckboxList($model, 'plan_code_right', $listPlanRight, [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="item"><label>' . Html::checkbox($name, $checked, [
                                                'value' => $value, 'class' => 'sCheck' ]) .
                                                    '<span class="fLabel">' . Html::encode($label) .
                                                    '</span></label></div>';
                                        }
                                ])?> 
                                <?php endif; ?>
                            </div>
                            
                            <div class="block w100">
                                <?php if(count($listPlanButton) > 0) : ?>
                                <?= Html::activeCheckboxList($model, 'plan_code_button', $listPlanButton, [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="item"><label>' . Html::checkbox($name, $checked, [
                                                'value' => $value, 'class' => 'sCheck' ]) .
                                                    '<span class="fLabel">' . Html::encode($label) .
                                                    '</span></label></div>';
                                        }
                                ])?> 
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_code']); ?></p>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>オプション</th>
                    <td class="pack">
                        <span class="fTextAssist_left" style="width:60px;">パック名：</span>
                        <?= Html::activeDropDownList($model, 'opt_packcode', $listPackParent, [
                            'class'=>'packName fieldRequired '. $model->getClassField('opt_packcode'),
                            'prompt'=>'パック無し']); ?>
                        <div>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_packcode']); ?></p>
                            <br>
                            <?php if (count($optPack) > 0) :?>
                            <div class="table">
                                <?php if ($model->opt_packcode) : ?>
                                <?= Html::activeCheckboxList($model, 'opt_code', $listPack, [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="row"><div class="cel"><label>' .
                                                    Html::checkbox($name, $checked, [
                                                        'value' => $value, 'class' => 'sCheck opt',
                                                        'disabled' => 'disabled']) . '<span class="fLabel opt disable">' .
                                                    Html::encode($label) .
                                                    '</span></label></div></div>';
                                        }
                                ])?> 
                                <?php else : ?>
                                <?= Html::activeCheckboxList($model, 'opt_code', $listPack, [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="row"><div class="cel"><label>' .
                                                    Html::checkbox($name, $checked, ['value' => $value,
                                                        'class' => 'sCheck opt' ]) . '<span class="fLabel opt">' .
                                                    Html::encode($label) .
                                                    '</span></label></div></div>';
                                        }
                                ])?> 
                                <?php endif;?>
                                <?= Html::activeCheckboxList($model, 'opt_code_special', $listPackSpecial, [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="row"><div class="cel"><label>' .
                                                    Html::checkbox($name, $checked, ['value' => $value,
                                                        'class' => 'sCheck' ]) . '<span class="fLabel">' .
                                                    Html::encode($label) .
                                                    '</span></label></div></div>';
                                        }
                                ])?> 
                                <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_code', 'opt_code_special']); ?></p>
                            </div>
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </tbody></table>
    </div>

    <div class="BtnArea">
        <?= Html::submitButton($textBtn, ['class' => 'btnGray']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</td>
