<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\StaffMst;

$this->title ='ユーザ情報詳細';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">ユーザ情報詳細</h2>
    </div>
    <!-- /page title -->
    <?php if (Yii::$app->session->hasFlash('message_success')) : ?>
        <!-- success message -->
        <p class="mBoxitem_txt txtWarning"><?= Yii::$app->session->getFlash('message_success') ?></p>
    <?php endif; ?>
    <div class="mBoxitem_table">
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>ユーザーID</th>
                    <td><?= Html::encode($data['staff_id']);?></td>
                </tr>
                <tr>
                    <th>ユーザー名</th>
                    <td><?= Html::encode($data['staff_name'])?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?= $data['staff_mail']?></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                        <a href="<?= Url::to(['/staff/default/changepass', 'staffId' => $data['staff_id']]) ;?>">
                            パスワードを変更する
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>権限</th>
                    <td><?= array_key_exists($data['staff_auth_level'], StaffMst::$STAFF_AUTH) ?
                                StaffMst::$STAFF_AUTH[$data['staff_auth_level']] : $data['staff_auth_level'];?>
                    </td>
                </tr>
                <tr>
                    <th>登録日時</th>
                    <td>
                        <?php
                        if (!empty($data['staff_reg_date']) &&
                                    $data['staff_reg_date'] != '0000-00-00 00:00:00') {
                            echo date('Y/m/d H:i', strtotime($data['staff_reg_date']));
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>更新日時</th>
                    <td>
                        <?php
                        if (!empty($data['staff_last_upd_date']) &&
                                    $data['staff_last_upd_date'] != '0000-00-00 00:00:00') {
                            echo date('Y/m/d H:i', strtotime($data['staff_last_upd_date']));
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>アカウントの状態</th>
                    <td><?= array_key_exists($data['staff_status'], StaffMst::$LABEL_STATUS) ?
                                StaffMst::$LABEL_STATUS[$data['staff_status']] : $data['staff_status'];?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="BtnArea">
        <div class="BtnAreaitem"> <a class="btnGray" href="<?= Url::to(['/staff/default/update',
            'staffId' => $data['staff_id']]); ?>">編集する</a></div>
    </div>

</td>
