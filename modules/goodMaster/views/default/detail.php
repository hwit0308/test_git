<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\ApplyTbl;
use common\components\Utility;
use common\models\OptMst;

$optMst = new OptMst();
$listOptMst = $optMst->getListOption($goodsItem->goods_jan, true);
$listOption = $optMst->renderListOption($listOptMst);
$this->title = '商品情報詳細';
?>
            <td id="main"><!-- main contents -->
                <!-- page title -->
                <div class="titlebarMain_bg">
                      <h2 class="titlebarMain_icon">商品情報詳細</h2>
                </div>
                <!-- /page title -->
                <?php if (Yii::$app->session->hasFlash('message_success')) : ?>
                    <p class="mBoxitem_txt txtWarning"><?= Yii::$app->session->getFlash('message_success') ?></p>
                <?php endif; ?>
                    <div class="mBoxitem_table">
                        <div class="mBoxitem_listinfo">
                            <div class="pageList_data" style="font-size: 17px;">商品名 ：
                                <strong><?= Html::encode($goodsItem->goods_name) ?></strong></div>
                        </div>
                    <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
                        <tbody>
                            <tr>
                                <th>JANコード</th>
                                <td><?= Html::encode($goodsItem->goods_jan) ?></td>
                            </tr>
                            <tr>
                                <th>商品名２</th>
                                <td><?= Html::encode($goodsItem->goods_name2) ?></td>
                            </tr>
                            <tr>
                                <th>機種ID</th>
                                <td><?= Html::encode($goodsItem->goods_model_id) ?></td>
                            </tr>
                            <tr>
                                <th>SIMタイプ</th>
                                <td><?= array_key_exists($goodsItem->goods_sim_type, ApplyTbl::$LABEL_SIM_SIZE) ?
                                ApplyTbl::$LABEL_SIM_SIZE[$goodsItem->goods_sim_type] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>SIM契約種別</th>
                                <td><?= array_key_exists($goodsItem->goods_sim_class, ApplyTbl::$LABEL_SIM_TYPE) ?
                                ApplyTbl::$LABEL_SIM_TYPE[$goodsItem->goods_sim_class] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>カラー</th>
                                <td><?= Html::encode($goodsItem->goods_color) ?></td>
                            </tr>
                            <tr>
                                <th>サイズ</th>
                                <td><?= Html::encode($goodsItem->goods_size) ?></td>
                            </tr>
                            <tr>
                                <th>メーカー名</th>
                                <td><?= Html::encode($goodsItem->goods_maker) ?></td>
                            </tr>
                            <tr>
                                <th>商品説明</th>
                                <td><?= nl2br(Html::encode($goodsItem->goods_decr)) ?></td>
                            </tr>
                            <tr>
                                <th>最終更新者</th>
                                <td><?= Html::encode($goodsItem->goods_last_upd_id) ?></td>
                            </tr>
                            <tr>
                                <th>最終更新日時</th>
                                <td><?php
                                if (!empty($goodsItem->last_upd_date) &&
                                        $goodsItem->last_upd_date != '0000-00-00 00:00:00') {
                                    echo date('Y/m/d H:i', strtotime($goodsItem->last_upd_date));
                                } else {
                                    echo '';
                                } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
                        <tbody>
                            <tr>
                                <th>プラン</th>
                                <td>
                                    <div class="mBox_plan">
                                        <?php if ((count($goodsItem->plan_name) > 0) || (count($listOption) > 0)) : ?>
                                        <a href="<?= Url::to(['/goodMaster/default/drop', 'goodsJan' => $goodsItem['goods_jan']]); ?>" class="btnGray">商品プラン・オプショイン並び変え設定画面へ</a>
                                        <?php endif;?>
                                        <?= Utility::convertHtml($goodsItem->plan_name) ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>オプション</th>
                                <td>
                                    <?php if (count($listOption) > 0) : ?>
                                    <?php foreach ($listOption as $key => $value) : ?>
                                        <?php $indent = ''; ?>
                                        <span><?= Html::encode($value['opt_packname']); ?></span>
                                        <br>
                                        <?php $indent = "&nbsp&nbsp&nbsp"; ?>
                                        <?php if(!empty($value['option_childrent'])) : ?>
                                            <?php foreach ($value['option_childrent'] as $child) : ?>
                                            <span><?= $indent . Html::encode($child['opt_name']); ?></span>
                                            <br>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="BtnArea">
                    <div class="BtnAreaitem">
                        <a href="<?= Url::to(['/goodMaster/default/save', 'goodsJan' => $goodsItem['goods_jan']]); ?>"
                           class="btnGray">編集する</a>
                    </div>
                </div>
            </td>
        <!-- /#main -->
        </tr>
    </table>
<!-- /#contents --> 
</div>

