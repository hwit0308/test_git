<?php
use common\models\ApplyTbl;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\widgets\ImageWidget;

$this->title = '申込情報詳細';
if (!empty($data['apply_mnp_tel'])) {
    $mnpTel = substr_replace($data['apply_mnp_tel'], '-', 3, 0);
    $mnpTel = substr_replace($mnpTel, '-', 8, 0);
} else {
    $mnpTel = '';
}
if ($data['apply_sim_audiotype'] == '11') {
    $data['apply_sim_audiotype_text'] = ApplyTbl::$LABEL_SIM_AUDIOTYPE['10'] . '<br/>'
            . ApplyTbl::$LABEL_SIM_AUDIOTYPE['01'];
} elseif ($data['apply_sim_audiotype'] == '00') {
    $data['apply_sim_audiotype_text'] = '';
} else {
    $data['apply_sim_audiotype_text'] = array_key_exists($data['apply_sim_audiotype'], ApplyTbl::$LABEL_SIM_AUDIOTYPE) ?
                                    ApplyTbl::$LABEL_SIM_AUDIOTYPE[$data['apply_sim_audiotype']] : '';
}
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">申込内容詳細</h2>
    </div>
    <!-- /page title -->

    <div class="mBoxitem_table boxStatus">
        <span>申込ID ： <strong><?= $data['apply_id']?></strong></span>
        <?php $form = ActiveForm::begin([
             'options' => [
                'class' => 'flRight'
             ]
        ]);?>
            <table class="tableStatus">
                <tbody>
                    <tr>
                        <td>ステータス ：</td>
                        <td>
                            <?php $model->apply_sts = $data['apply_sts'];?>
                            <?= Html::activeDropDownList($model, 'apply_sts', $model::$LABEL_STS, [
                                'style' => 'width: 85px']); ?>
                            <input type="submit" value="変更を保存" class="simpleBtn">
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php ActiveForm::end(); ?>
        <div class="clearfix"></div>
    </div>

    <div class="mBoxitem_table boxAppDetail">
        <h4 class="iconTableTitle">申請状況に関する情報</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>申請日時</th>
                    <td><?= !empty($data['apply_date']) ? date("Y/m/d H:i", strtotime($data['apply_date'])) : '';?></td>
                </tr>
                <tr>
                    <th>メール送信日時</th>
                    <td><?= !empty($data['apply_notification_date']) ?
                            date("Y/m/d H:i", strtotime($data['apply_notification_date'])) : '';?></td>
                </tr>
                <tr>
                    <th>メール再送日時</th>
                    <td><?= !empty($data['apply_last_notification_date']) ?
                            date("Y/m/d H:i", strtotime($data['apply_last_notification_date'])) : '';?> 
                        <?php if (isset($data['apply_mail'])) : ?>
                        <a href="<?= Url::to(['/apply/default/mail-detail',
                            'applyId' => $data["apply_id"]])?>" class="simpleBtn">メールを再送する</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>画像有無</th>
                    <td><?= array_key_exists($data['apply_img_status'], ApplyTbl::$LABEL_APPLY_IMG_STATUS) ?
                                    ApplyTbl::$LABEL_APPLY_IMG_STATUS[$data['apply_img_status']] :
                                $data['apply_img_status'];?></td>
                </tr>
                <tr>
                    <th>キーコード</th>
                    <td><?= $data['apply_key'];?></td>
                </tr>
                <tr>
                    <th>キーコード連携日時</th>
                    <td><?= !empty($data['apply_key_date']) ?
                            date("Y/m/d H:i", strtotime($data['apply_key_date'])) : '';?></td>
                </tr>
                <tr>
                    <th>明細行ID</th>
                    <td><?= $data['apply_detail'];?></td>
                </tr>
                <tr>
                    <th>注文番号</th>
                    <td><?= $data['apply_sales'];?></td>
                </tr>
            </tbody>
        </table>
        
        <h4 class="iconTableTitle">商品情報</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>オーダーID</th>
                    <td><?= $data['apply_orderid']?></td>
                </tr>
                <tr>
                    <th>商品名</th>
                    <td><?= Html::encode($data['goods_name'])?></td>
                </tr>
            </tbody></table>
        <h4 class="iconTableTitle">プラン</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>プラン</th>
                    <td><?= Html::encode($data['plan_name'])?></td>
                </tr>
            </tbody></table>
        <h4 class="iconTableTitle">MNP情報</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>MNP利用有無</th>
                    <td>
                        <?php if (isset($data['apply_surname'])) : ?>
                        <?= array_key_exists($data['apply_mnp_flg'], ApplyTbl::$LABEL_MNP_FLG) ?
                                    ApplyTbl::$LABEL_MNP_FLG[$data['apply_mnp_flg']] :
                                $data['apply_mnp_flg'];?>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>MNP予約番号</th>
                    <td><?= $data['apply_mnp_no']; ?></td>
                </tr>
                <tr>
                    <th>予約番号の有効期限</th>
                    <td><?= empty($data['apply_mnp_limit']) ? '' :
                            date("Y/m/d", strtotime($data['apply_mnp_limit'])); ?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?= $mnpTel; ?></td>
                </tr>
            </tbody></table>
        <h4 class="iconTableTitle">SIM関連情報</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>SIMタイプ</th>
                    <td><?= array_key_exists($data['apply_sim_size'], ApplyTbl::$LABEL_SIM_SIZE) ?
                            ApplyTbl::$LABEL_SIM_SIZE[$data['apply_sim_size']] : $data['apply_sim_size']; ?></td>
                </tr>
                <tr>
                    <th>SIM契約種別</th>
                    <td><?= array_key_exists($data['apply_sim_type'], ApplyTbl::$LABEL_SIM_TYPE) ?
                            ApplyTbl::$LABEL_SIM_TYPE[$data['apply_sim_type']] : $data['apply_sim_type']; ?></td>
                </tr>
                <tr>
                    <th>SIM音声オプション情報</th>
                    <td><?= $data['apply_sim_audiotype_text'] ?></td>
                </tr>
                <tr>
                    <th>SIMセット端末機種ID</th>
                    <td><?= $data['apply_sim_serviceid'] ?></td>
                </tr>
                <tr>
                    <th>SIMセット端末オプション情報</th>
                    <td>
                        <?php if (!empty($data['sim_opt'])) : ?>
                            <?php foreach ($data['sim_opt'] as $key => $value) : ?>
                                <?php $indent = ''; ?>
                                <?php if ($value['flag'] == 1) : ?>
                                    <span><?= Html::encode($value['title']); ?></span>
                                    <br>
                                <?php $indent = "&nbsp&nbsp&nbsp"; ?>
                                <?php endif; ?>
                                <?php if(!empty($value['children'])) : ?>
                                    <?php if ($key === '000' || $key === 'special') : ?>
                                        <?php foreach ($value['children'] as $key1 => $child) : ?>
                                        <span><?= $indent . Html::encode($child['opt_name']); ?></span>
                                        <br>
                                        <?php endforeach;?>
                                    <?php else :?>
                                        <?php foreach ($value['children'] as $child) : ?>
                                        <span><?= $indent . Html::encode($child['opt_name']); ?></span>
                                        <br>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>SIMセット端末ID</th>
                    <td><?= $data['apply_sim_imeid'] ?></td>
                </tr>
            </tbody>
        </table>
        
        <h4 class="iconTableTitle">契約者情報</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>会員ID</th>
                    <td><?= $data['apply_memberid'];?></td>
                </tr>
                <tr>
                    <th>契約者氏名</th>
                    <td><?= Html::encode($data['apply_surname']) .
                            Html::encode($data['apply_givenname']); ?></td>
                </tr>
                <tr>
                    <th>契約者氏名（カナ）</th>
                    <td><?= Html::encode($data['apply_sname_kana']) .
                                    Html::encode($data['apply_gname_kana']); ?></td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>
                        <?php if (isset($data['apply_surname'])) : ?>
                            <?= !empty($data['apply_sex']) ?  ApplyTbl::$APPLY_SEX_ARR[$data['apply_sex']] : ''; ?>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>生年月日</th>
                    <td><?= $data['apply_birth']; ?></td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td><?= ($data['apply_zip']) ? substr_replace($data['apply_zip'], '-', 3, 0) : ''; ?></td>
                </tr>
                <tr>
                    <th>ご住所1&#12288;都道府県・市区町村</th>
                    <td><?= $data['zip_pref'] . $data['apply_address2'] . $data['apply_address3']; ?></td>
                </tr>
                <tr>
                    <th>ご住所2&#12288;番地</th>
                    <td><?= $data['apply_address4']; ?></td>
                </tr>
                <tr>
                    <th>ご住所3&#12288;建物名・マンション名</th>
                    <td><?= $data['apply_address5']; ?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?= $data['apply_tel']; ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?= $data['apply_mail']; ?></td>
                </tr>
            </tbody></table>
        <h4 class="iconTableTitle">本人確認書類</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>本人確認書類</th>
                    <td>
                        <?php if (isset($data['apply_surname'])) : ?>
                            <?= !empty($data['apply_doctype']) ?
                                    ApplyTbl::$LABEL_DOCTYPE[$data['apply_doctype']] : '' ?></td>
                        <?php endif;?>
                </tr>
            </tbody></table>
        <h4 class="iconTableTitle">本人確認書類画像</h4>
        <div class="inner" style="width: 100%; display: inline-block">
            <?= ImageWidget::widget(['orderId' => $data['apply_orderid'],
                                    'value' => $data['apply_key'], 'showFlag' => 1, 'flag' => true]) ?>
        </div>
        <h4 class="iconTableTitle">決済情報</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>加盟店ID</th>
                    <td><?= $data['apply_shop_id']; ?></td>
                </tr>
                <tr>
                    <th>加盟店注文番号</th>
                    <td><?= $data['apply_order_id']; ?></td>
                </tr>
                <tr>
                    <th>処理結果</th>
                    <td><?= $data['apply_result']; ?></td>
                </tr>
                <tr>
                    <th>AEONREGI注文番号</th>
                    <td><?= $data['apply_lid_m']; ?></td>
                </tr>
                <tr>
                    <th>取引年月日</th>
                    <td><?= empty($data['apply_auth_date']) ? '' :
                            date("Y/m/d", strtotime($data['apply_auth_date'])); ?></td>
                </tr>
                <tr>
                    <th>取引時刻</th>
                    <td><?= empty($data['apply_auth_time']) ? '' :
                                    date("H:i:s", strtotime($data['apply_auth_time'])); ?></td>
                </tr>
                <tr>
                    <th>イオンレジID</th>
                    <td><?= $data['apply_aeonregi_id']; ?></td>
                </tr>
                <tr>
                    <th>カード有効期限</th>
                    <td><?= $data['apply_cardexpiry']; ?></td>
                </tr>
                <tr>
                    <th>承認番号</th>
                    <td><?= $data['apply_approval_code']; ?></td>
                </tr>
                <tr>
                    <th>仕向先会社コード</th>
                    <td><?= $data['apply_cocode']; ?></td>
                </tr>
                <tr>
                    <th>仕向先会社サブコード</th>
                    <td><?= $data['apply_subcocode']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</td>
