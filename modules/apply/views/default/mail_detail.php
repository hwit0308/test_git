<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\OptMst;
use common\models\ApplyTbl;
use common\models\PlanMst;

$this->title = 'メール再送信確認';
$data = $dataDb->toArray();
if ($data['apply_sim_audiotype'] == '11') {
    $data['apply_sim_audiotype_text'] = ApplyTbl::$LABEL_SIM_AUDIOTYPE['10'] . "<br/>"
                                        . ApplyTbl::$LABEL_SIM_AUDIOTYPE['01'];
} elseif ($data['apply_sim_audiotype'] == '00') {
    $data['apply_sim_audiotype_text'] = '';
} else {
    $data['apply_sim_audiotype_text'] = array_key_exists($data['apply_sim_audiotype'], ApplyTbl::$LABEL_SIM_AUDIOTYPE) ?
                                    ApplyTbl::$LABEL_SIM_AUDIOTYPE[$data['apply_sim_audiotype']] : '';
}
$optMst = new OptMst();
$planMst = PlanMst::findOne(['plan_code' => $data['apply_planid']]);
$data['plan_name'] = !empty($planMst) ? $planMst->plan_name : '';
$data['sim_opt'] = $optMst->renderSimOpt($data['apply_sim_opt'], $data['apply_jan']);
$applyModel = new ApplyTbl();
$simOpt = $applyModel->renderSimOptFromData($data['apply_sim_opt'], $data['apply_jan']);
$data['option_child_special'] = $simOpt['option_child_special'];
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">メール再送信確認</h2>
    </div>
    <?php $form = ActiveForm::begin();?>
    <!-- /page title -->
    <div class="mBoxitem_table boxAppDetail">
        <p class="title">申込者へ申込完了メールを再送します。<br/>
        送信内容を確認し、[送信する]ボタンをクリックしてください。</p>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>会員ID</th>
                    <td><?= $data['apply_memberid']; ?></td>
                </tr>
                <tr>
                    <th>契約者氏名</th>
                    <td><?= Html::encode($data['apply_surname']) .
                            Html::encode($data['apply_givenname']); ?></td>
                </tr>
            </tbody>
        </table>
        <h4 class="iconTableTitle">送信メール内容</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th class="must">送信先メールアドレス</th>
                    <td><?= Html::activeTextInput($dataDb, 'apply_mail_resend', [
                        'class' => 'txtbox fieldRequired '.$dataDb->getClassField('apply_mail_resend'),
                        'value' => $data['apply_mail']]); ?>
                        <p class="fTextAssist_bottom txtWarning"><?= $dataDb->getMgsError(['apply_mail_resend']); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>メール件名</th>
                    <td>お申し込み内容を確認ください</td>
                </tr>
                <tr>
                    <th>メール本文</th>
                    <td>
                        <div class="description_mail">
                            <?= Html::encode($data['apply_surname']) ?>
                                <?= Html::encode($data['apply_givenname']) ?>様
                            <br/><br/>
                            <p>このたびは、イオンデジタルワールドをご利用いただき、誠にありがとうございます。</p>
                            <p>お客さまのお申込みを下記の内容で承りました。</p>
                            <br/>
                            <p>※このメールは重要な情報を含んでおりますので、大切に保管してください。</p>
                            <br/>
                            <p>---------------------------------------------------------------</p>
                            [申込ID]  <?= $data['apply_id'] ?><br/>
                            [お申込み日時] <?= $data['apply_date'] ?><br/>
                            [オーダーID] <?= $data['apply_orderid'] ?><br/><br/>
                            【プラン】<br/>
                            <?= Html::encode($data['plan_name']) ?><br/><br/>
                            <?php if ($data['apply_sim_type'] == ApplyTbl::APPLY_SIM_TYPE_VOICE &&
                                    $data['apply_mnp_flg'] == ApplyTbl::APPLY_MNP_FLG_NOT_EXIT) : ?>
                            【MNP情報】<br/>
                            <?= ApplyTbl::$LABEL_MNP_FLG[$data['apply_mnp_flg']]; ?><br/>
                            [MNP予約番号] <?= $data['apply_mnp_no']; ?><br/>
                            <?php if (!empty($data['apply_mnp_limit'])) :?>
                            [MNP予約番号の有効期間] <?= date("Y/m/d", strtotime($data['apply_mnp_limit'])); ?><br/><br/>
                            <?php else :?>
                            [MNP予約番号の有効期間]<br/><br/>
                            <?php endif;?>
                            <?php endif;?>
                            <?php if ($data['apply_sim_type'] == ApplyTbl::APPLY_SIM_TYPE_VOICE) : ?>
                            【音声オプション】<br/>
                            <?= $data['apply_sim_audiotype_text'] ?><br/><br/>
                            <?php endif;?>
                            【オプション】<br/>
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
                            <br/>
                            <?php if ($data['apply_sim_type'] == ApplyTbl::APPLY_SIM_TYPE_VOICE ||
                                (!empty($data['option_child_special']) && in_array(OptMst::$OPT_050FREECALL, $data['option_child_special']))) :?>
                            <p>音声SIMをお申し込みのお客さまで本人確認書類の画像が未登録の場合、または不足している場合は</p>
                            <p>下記のURLからアクセスして画像をアップロードしてください。</p><br/>
                            <?= Yii::$app->params['domain'].'step3_2?order_id='.$data['apply_orderid'].'&value='.
                                    $data['apply_key']?>
                            <br/><br/>
                            <p>※お申し込み後1週間以内にアップロードされた画像を確認できない場合は</p>
                            <p>お申し込みをキャンセルさせていただきますのでご注意ください。</p>
                            <?php endif;?>
                            <br/>
                            <p>ご不明な点やご要望がございましたら、「イオンデジタルワールド」ページ上部の</p>
                            <p>「お問い合わせ」より、お気軽にご連絡ください。</p>
                            <br/>
                            <p>こちらのメールは送信専用です。こちらのメールにご返信いただいてもご回答できませんのでご了承ください。</p>
                            <br/>
                            <p>イオンデジタルワールド</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mBoxitem_listinfo">
            <div class="btnGroup btnGroupMail">
                <a href="<?= Url::to(['/apply/default/detail', 'applyId' => $data["apply_id"]]);?>" 
                   type="submit" class="simpleBtn" value="戻る">戻る</a>
                <a href="javascript:void(0)" onclick="$('form').submit();return false;" 
                   class="simpleBtn" title="送信する">送信する</a>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</td>