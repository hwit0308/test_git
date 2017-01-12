<?php
    use yii\helpers\Url;
    use yii\helpers\Html;

    Yii::$app->view->title = 'オプション詳細'
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">オプション詳細</h2>
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
                        <th>パックID</th>
                        <td><?= $model['opt_packcode']; ?></td>
                    </tr>
                    <tr>
                        <th>パック名称</th>
                        <td><?= Html::encode($model['opt_packname']); ?></td>
                    </tr>
                    <tr>
                        <th>パック説明</th>
                        <td><?= nl2br(Html::encode($model['opt_packdesc'])); ?></td>
                    </tr>
                    <tr>
                        <th>オプションID</th>
                        <td><?= $model['opt_code']; ?></td>
                    </tr>
                    <tr>
                        <th>オプション名称</th>
                        <td><?= Html::encode($model['opt_name']); ?></td>
                    </tr>
                    <tr>
                        <th>オプション説明</th>
                        <td><?= nl2br(Html::encode($model['opt_desc'])); ?></td>
                    </tr>
                    <tr>
                        <th>オプション区分</th>
                        <td>
                            <?= array_key_exists($model['opt_class'], \common\models\PlanMst::$ClASS_PLAN) ?
                                \common\models\PlanMst::$ClASS_PLAN[$model['opt_class']] : $model['opt_class'];?>
                        </td>
                    </tr>
                    <tr>
                        <th>オプション表示開始日</th>
                        <td>
                            <?php
                            if (!empty($model['opt_start_date']) &&
                                        $model['opt_start_date'] != '0000-00-00 00:00:00') {
                                echo date('Y/m/d', strtotime($model['opt_start_date']));
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>オプション表示終了日</th>
                        <td>
                            <?php
                            if (!empty($model['opt_end_date']) &&
                                        $model['opt_end_date'] != '0000-00-00 00:00:00') {
                                echo date('Y/m/d', strtotime($model['opt_end_date']));
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>最終更新者</th>
                        <td><?= Html::encode($model['last_upd_user']); ?></td>
                    </tr>
                    <tr>
                        <th>最終更新日時</th>
                        <td>
                            <?php
                            if (!empty($model['last_upd_date']) &&
                                        $model['last_upd_date'] != '0000-00-00 00:00:00') {
                                echo date('Y/m/d H:i', strtotime($model['last_upd_date']));
                            } else {
                                echo '';
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="BtnArea">
                <div class="BtnAreaitem"> <a href="<?= Url::to(['/goodMaster/option/save',
                    'packCode' => $model["opt_packcode"], 'code' => $model["opt_code"]]); ?>"
                    class="btnGray">編集する</a></div>
            </div>
        <div class="clearfix"></div>
    </div>
</td>
