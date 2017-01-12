<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PlanMst;

if (!$model->isNewRecord) {
    $textBtn = '変更を保存';
    $textChange = '編集';
    $titleBar = 'プラン情報編集';
} else {
    $textBtn = '登録する';
    $textChange = '作成';
    $titleBar = '新規プラン追加';
}
if (common\models\BaseModel::isDate($model->plan_start_date)) {
    $planStartdate = date('Y/m/d', strtotime($model->plan_start_date));
} elseif (!Yii::$app->request->post() && $model->plan_start_date == '0000-00-00 00:00:00') {
    $planStartdate = "";
} elseif (!empty($model->plan_start_date)) {
    $planStartdate = $model->plan_start_date;
} else {
    $planStartdate = "";
}
if (common\models\BaseModel::isDate($model->plan_end_date)) {
    $planEnddate = date('Y/m/d', strtotime($model->plan_end_date));
} elseif (!Yii::$app->request->post() && $model->plan_end_date == '0000-00-00 00:00:00') {
    $planEnddate = "";
} elseif (!empty($model->plan_end_date)) {
    $planEnddate = $model->plan_end_date;
} else {
    $planEnddate = "";
}
Yii::$app->view->title = $titleBar;
?>
<td id="main"><!-- main contents -->
    <?php $form = ActiveForm::begin(['options' => ['class' => '', 'role' => 'form'],]); ?>
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon"><?= $titleBar ?></h2>
    </div>
    <!-- /page title -->
    <div class="mBoxitem_table">
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">
                プラン情報を<?= $textChange ?>します。<br />必要事項を入力し、[<?= $textBtn; ?>]ボタンをクリックしてください。
            </div>
        </div>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th class="must">プランID</th>
                    <td>
                        <?= Html::activeTextInput($model, 'plan_code', ['class' => 'txtbox fieldRequired ' . $model->getClassField('plan_code')]); ?>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_code']); ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="must">プラン名</th>
                    <td>
                        <?= Html::activeTextInput($model, 'plan_name', ['class' => 'txtbox fieldRequired ' . $model->getClassField('plan_name')]); ?>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_name']); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>プラン説明</th>
                    <td>
                        <?= Html::activeTextarea($model, 'plan_desc', ['rows' => 5, 'cols' => 60]); ?>
                    </td>
                </tr>
                <tr>
                    <th>プラン区分</th>
                    <td>
                        <?= Html::activeDropDownList($model, 'plan_class', PlanMst::$ClASS_PLAN, ['prompt' => '--', 'class' => 'txtbox fieldRequired ' . $model->getClassField('plan_class')]); ?>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_class']); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>初回値引金額</th>
                    <td>
                        <?= Html::activeTextInput($model, 'plan_initial_dis', ['class' => 'txtbox fieldRequired ' . $model->getClassField('plan_initial_dis')]); ?>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_initial_dis']); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>プラン表示期間</th>
                    <td>
                        <div class="fAssist_row">
                            <label>
                                <span class="fLabel">開始日：</span>
                                <?= Html::activeTextInput($model, 'plan_start_date', ['class' => 'txtbox datepicker fieldRequired ' . $model->getClassField('plan_start_date'), 'value' => $planStartdate]); ?>
                            </label>
                            -
                            <label>
                                <span class="fLabel">終了日：</span>
                                <?= Html::activeTextInput($model, 'plan_end_date', ['class' => 'txtbox datepicker fieldRequired ' . $model->getClassField('plan_end_date'), 'value' => $planEnddate]); ?>
                            </label>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_start_date']); ?></p>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['plan_end_date']); ?></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="BtnArea">
            <?= Html::submitButton($textBtn, ['class' => 'btnGray', 'title' => $textBtn]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</td>

