<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Yii::$app->view->title = '新規ユーザ追加';
?>
<td id="main"><!-- main contents -->
    <?php $form = ActiveForm::begin(['errorCssClass' => 'error']); ?>
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">新規ユーザ追加</h2>
    </div>
    <!-- /page title -->
    <div class="mBoxitem_table">
        
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">ユーザ情報を作成します。<br />必要事項を入力し、[登録する]ボタンをクリックしてください。</div>
        </div>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th class="must">ユーザID</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeTextInput($model, 'staff_id', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_id')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_id']); ?></p>
                            <p><br />6文字以上32文字以内の半角英数で入力してください。<br />例） aeon_link001</p>
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
                    <th class="must">パスワード</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activePasswordInput($model, 'staff_password', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_password')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_password']); ?></p>
                            <p><br />8文字以上32文字以内の半角英数で入力してください。<br />ユーザIDと同じものは登録できません。また、必ず英数字が混ざるようにしてください<br />例） aeon1234</p>
                        </div>
                    </td>
                </tr>
                <tr>
                <th class="must">パスワード（確認）</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activePasswordInput($model, 'staff_password_repeat', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_password_repeat')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_password_repeat']); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="must">権限</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activeDropDownList($model, 'staff_auth_level', common\models\StaffMst::$STAFF_AUTH, ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_auth_level'), 'style' => 'width: 150px;']); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_auth_level']); ?></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="BtnArea">
        <?= Html::submitButton('登録する', ['class' => 'btnGray', 'title'=>'登録する']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</td>
<!-- /#main --> 
