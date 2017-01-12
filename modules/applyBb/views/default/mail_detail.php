<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\OptMst;
use common\models\AeonbbApplyTbl;
use common\models\PlanMst;
use backend\models\FormSearchApplyBb;

$this->title = 'メール再送信確認';
$data = $dataDb->toArray();
$optMst = new OptMst();
$planMst = PlanMst::findOne(['plan_code' => $data['apply_planid']]);
$data['plan_name'] = !empty($planMst) ? $planMst->plan_name : '';
$data['sim_opt'] = $optMst->renderSimOpt($data['apply_sim_opt'], $data['apply_jan']);
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
                    <th>電話番号</th>
                    <td><?= $data['apply_tel']; ?></td>
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
                            [お申込み番号]  <?= $data['apply_id'] ?><br/>
                            [お申込み日時] <?= $data['apply_date'] ?><br/><br/>
                            【プラン】<br/>
                            <?= Html::encode($data['plan_name']) ?><br/><br/>
                            【オプション】<br/>
                            <?= FormSearchApplyBb::renderTextOption($data['sim_opt']);?>
                            <br/>
                            
                            <?php if (count($optionShare) > 0): ?>
                            <?php foreach ($optionShare as $key => $value) : ?>
                            【シェアプランオプション<?= ($key+1)?>】<br/>
                            SIM電話番号:<?= $value->sim_tel?><br/>
                            <?php $simOpt = $optMst->renderSimOpt($value->sim_opt, $data['apply_jan']);?>
                            <?= FormSearchApplyBb::renderTextOption($simOpt);?>
                            <br/><br/>
                            <?php endforeach;?>
                            <?php endif;?>
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
                <a href="<?= Url::to(['/applyBb/default/detail', 'applyId' => $data["apply_id"]]);?>" 
                   type="submit" class="simpleBtn" value="戻る">戻る</a>
                <a href="javascript:void(0)" onclick="$('form').submit();return false;" 
                   class="simpleBtn" title="送信する">送信する</a>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</td>