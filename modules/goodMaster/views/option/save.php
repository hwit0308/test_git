<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PlanMst;

if (!$model->isNewRecord) {
    $textBtn = '変更を保存';
    $textChange = '編集';
    $titleBar = 'オプション情報編集';
} else {
    $textBtn = '登録する';
    $textChange = '作成';
    $titleBar = '新規オプション追加';
}
if (common\models\BaseModel::isDate($model->opt_start_date)) {
    $optionStartdate = date('Y/m/d', strtotime($model->opt_start_date));
} elseif (!Yii::$app->request->post() && $model->opt_start_date == '0000-00-00 00:00:00') {
    $optionStartdate = "";
} elseif (!empty($model->opt_start_date)) {
    $optionStartdate = $model->opt_start_date;
} else {
    $optionStartdate = "";
}
if (common\models\BaseModel::isDate($model->opt_end_date)) {
    $optionEnddate = date('Y/m/d', strtotime($model->opt_end_date));
} elseif (!Yii::$app->request->post() && $model->opt_end_date == '0000-00-00 00:00:00') {
    $optionEnddate = "";
} elseif (!empty($model->opt_end_date)) {
    $optionEnddate = $model->opt_end_date;
} else {
    $optionEnddate = "";
}
Yii::$app->view->title = $titleBar
?>
<td id="main"><!-- main contents -->
    <?php $form = ActiveForm::begin(['options' => ['class' => '', 'role' => 'form']]); ?>
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon"><?= $titleBar ?></h2>
    </div>
    <div class="mBoxitem_table">
        <div class="mBoxitem_listinfo">
          <div class="pageList_data">オプション情報を<?= $textChange ?>します。<br />必要事項を入力し、[<?= $textBtn ?>]ボタンをクリックしてください。</div>
        </div>
        <?php if (Yii::$app->session->hasFlash('message_error')) : ?>
            <!-- success message -->
            <p class="mBoxitem_txt txtWarning" style="margin-left: 0px; margin-bottom: 10px;"><?= Yii::$app->session->getFlash('message_error') ?></p>
        <?php endif; ?>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th class="must">パックID</th>
                    <td>
                        <div class="fAssist_row">
                            <?php if ($model->opt_flag == 1) :?>
                            <?= Html::activeTextInput($model, 'opt_packcode', ['class' => 'txtbox disabled fieldRequired ' . $model->getClassField('opt_packcode'), 'disabled' => 'disabled']); ?>
                            <?php else : ?>
                            <?= Html::activeTextInput($model, 'opt_packcode', ['class' => 'txtbox fieldRequired ' . $model->getClassField('opt_packcode')]); ?>
                            <?php endif;?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_packcode']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>パック名称</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'opt_packname', ['class' => 'txtbox fieldRequired ' . $model->getClassField('opt_packname')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_packname']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>パック説明</th>
                    <td><?= Html::activeTextarea($model, 'opt_packdesc', ['style' => 'width:600px;', 'cols' => 30, 'rows' => 10]); ?></td>
                </tr>
                <tr>
                    <th class="must">オプションID</th>
                    <td>
                        <div class="fAssist_row">
                            <?php if ($model->opt_flag == 1) :?>
                            <?= Html::activeTextInput($model, 'opt_code', ['class' => 'txtbox disabled fieldRequired ' . $model->getClassField('opt_code'), 'disabled' => 'disabled']); ?>
                            <?php else : ?>
                            <?= Html::activeTextInput($model, 'opt_code', ['class' => 'txtbox fieldRequired ' . $model->getClassField('opt_code')]); ?>
                            <?php endif;?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_code']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="must">オプション名称</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'opt_name', ['class' => 'txtbox fieldRequired ' . $model->getClassField('opt_name')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_name']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>オプション説明</th>
                    <td><?= Html::activeTextarea($model, 'opt_desc', ['style' => 'width:600px;', 'cols' => 30, 'rows' => 10]) ?></td>
                </tr>
                <tr>
                    <th>オプション区分</th>
                    <td>
                        <?= Html::activeDropDownList($model, 'opt_class', PlanMst::$ClASS_PLAN, ['prompt' => '--', 'class' => 'txtbox fieldRequired ' . $model->getClassField('opt_class'), 'style' => 'width: 150px;']); ?>
                        <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_class']); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>オプション表示期間</th>
                    <td>
                        <div class="fAssist_row">
                            <label>
                                <span class="fLabel">開始日：</span>
                                <?= Html::activeTextInput($model, 'opt_start_date', ['class' => 'txtbox datepicker fieldRequired ' . $model->getClassField('opt_start_date'), 'value' => $optionStartdate]); ?>
                            </label>
                            -
                            <label>
                                <span class="fLabel">終了日：</span>
                                <?= Html::activeTextInput($model, 'opt_end_date', ['class' => 'txtbox datepicker fieldRequired ' . $model->getClassField('opt_end_date'), 'value' => $optionEnddate]); ?>
                            </label>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_start_date']); ?></p>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['opt_end_date']); ?></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="BtnArea">
        <?= Html::submitButton($textBtn, ['class' => 'btnGray', 'title'=>'変更を保存']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</td>
