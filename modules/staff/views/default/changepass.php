<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'パスワード変更';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">パスワード変更</h2>
    </div>
    <!-- /page title -->
    <?php $form = ActiveForm::begin(); ?>
    <div class="mBoxitem_table">
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">パスワードを変更します。<br />必要事項を入力し、[変更を保存]ボタンをクリックしてください。</div>
        </div>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th class="must">新しいパスワード</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activePasswordInput($model, 'staff_password_new', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_password_new')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_password_new']); ?></p>
                            <p><br />8文字以上32文字以内の半角英数で入力してください。<br />ユーザIDと同じものは登録できません。また、必ず英数字が混ざるようにしてください<br />例） aeon1234</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="must">新しいパスワード（確認）</th>
                    <td>
                        <div class="fAssist_row">
                            <?= Html::activePasswordInput($model, 'staff_password_new_repeat', ['class' => 'txtbox fieldRequired ' . $model->getClassField('staff_password_new_repeat')]); ?>
                            <p class="fTextAssist_bottom txtWarning"><?= $model->getMgsError(['staff_password_new_repeat']); ?></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="BtnArea">
        <?= Html::submitButton('変更を保存', ['class' => 'btnGray', 'title' => '変更を保存', 'value' => '変更を保存']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</td><!-- /#main -->
