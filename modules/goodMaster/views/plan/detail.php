<?php
use yii\helpers\Url;
use common\models\PlanMst;
use yii\helpers\Html;

Yii::$app->view->title = 'プラン詳細'

?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">プラン詳細</h2>
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
                        <th>プランID</th>
                        <td><?= $model['plan_code']; ?></td>
                    </tr>
                    <tr>
                        <th>プラン名</th>
                        <td><?= Html::encode($model['plan_name']); ?></td>
                    </tr>
                    <tr>
                        <th>プラン説明</th>
                        <td><?= nl2br(Html::encode($model['plan_desc'])); ?></td>
                    </tr>
                    <tr>
                        <th>プラン区分</th>
                        <td><?= array_key_exists($model['plan_class'], PlanMst::$ClASS_PLAN) ?
                                PlanMst::$ClASS_PLAN[$model['plan_class']] : $model['plan_class'];?>
                        </td>
                    </tr>
                    <tr>
                        <th>初回値引金額</th>
                        <td><?= Html::encode($model['plan_initial_dis']); ?></td>
                    </tr>
                    <tr>
                        <th>プラン表示開始日</th>
                        <td>
                            <?php
                            if (!empty($model['plan_start_date']) &&
                                        $model['plan_start_date'] != '0000-00-00 00:00:00') {
                                echo date('Y/m/d', strtotime($model['plan_start_date']));
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>プラン表示終了日</th>
                        <td>
                            <?php
                            if (!empty($model['plan_end_date']) &&
                                        $model['plan_end_date'] != '0000-00-00 00:00:00') {
                                echo date('Y/m/d', strtotime($model['plan_end_date']));
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>最終更新者</th>
                        <td><?= Html::encode($model['plan_last_upd_user']); ?></td>
                    </tr>
                    <tr>
                        <th>最終更新日時</th>
                        <td>
                            <?php
                            if (!empty($model['plan_last_upd_date']) &&
                                        $model['plan_last_upd_date'] != '0000-00-00 00:00:00') {
                                echo date('Y/m/d H:i', strtotime($model['plan_last_upd_date']));
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="BtnArea">
                <div class="BtnAreaitem"> <a href="<?= Url::to(['/goodMaster/plan/save',
                    'planId' => $model['plan_code']]); ?>" class="btnGray">編集する</a></div>
            </div>
        <div class="clearfix"></div>
    </div>
</td>
