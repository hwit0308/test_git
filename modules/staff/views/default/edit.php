<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

Yii::$app->view->title = 'ユーザ情報編集';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">ユーザ情報編集</h2>
    </div>
    <!-- /page title -->
    <?php $form = ActiveForm::begin(); ?>
    <div class="mBoxitem_table">
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">ユーザ情報を編集します。<br />必要事項を入力し、[変更を保存]ボタンをクリックしてください。</div>
        </div>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>ユーザID</th>
                    <td>
                        <div class="fAssist_row">
                            <?= $model->staff_id; ?> <span class="txtWarning">※変更不可</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="must">ユーザ名 </th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'staff_name', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_name')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_name']); ?></p>
                            <p><br />例） 山田太郎</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'staff_mail', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_mail')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_mail']); ?></p>
                            <p><br />例） aeon_yamada@aeonpeople.biz</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                        <a href="<?= Url::to(['/staff/default/changepass', 'staffId' => $model['staff_id']]) ;?>" title="パスワードを変更する">パスワードを変更する</a>
                    </td>
                </tr>
                <tr>
                    <th class="must">権限</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeDropDownList($model, 'staff_auth_level', common\models\StaffMst::$STAFF_AUTH, ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_auth_level')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_auth_level']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="must">アカウントの状態</th>
                    <td>
                        <div class="fAssist_row">
                            <p>アカウントを無効にした場合、情報は削除されませんが申込管理サイトにアクセスできなくなります。</p>
                            <?= Html::activeDropDownList($model, 'staff_status', common\models\StaffMst::$LABEL_STATUS, ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_status'), 'style' => 'width: 150px;']); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_status']); ?></p>
                        </div>
                    </td>
                </tr>
            </tbody></table>
    </div>

    <div class="BtnArea">
        <?= Html::submitButton('変更を保存', ['class' => 'btnGray']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</td>
<!-- /#main --> 
