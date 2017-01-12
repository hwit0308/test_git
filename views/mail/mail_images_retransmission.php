<?php
use yii\helpers\Url;
use common\models\OptMst;
use common\models\ApplyTbl;
use common\models\PlanMst;
use yii\helpers\Html;

$plan = \common\models\PlanMst::findOne($data['apply_planid']);
$data['plan_name'] = !empty($plan) ? $plan->plan_name : '';
if ($data['apply_sim_audiotype'] == '11') {
    $data['apply_sim_audiotype_text'] = ApplyTbl::$LABEL_SIM_AUDIOTYPE['10'] . "\n"
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
$optText = '';
if (count($data['sim_opt']) > 0) {
    $indent = '';
    foreach ($data['sim_opt'] as $key => $value) {
        if ($value['flag'] == 1) {
            $optText .= $value['title']."\n";
            $indent = "   ";
        }
        if (!empty($value['children'])) {
            if ($key === '000' || $key === 'special') {
                foreach ($value['children'] as $child) {
                    $optText .= $indent . $child['opt_name'] ."\n";
                }
            } else {
                foreach ($value['children'] as $child) {
                    $optText .= $indent . $child['opt_name'] ."\n";
                }
            }
        }
    }
}
$data['sim_opt_text'] = $optText;
$applyModel = new ApplyTbl();
$simOpt = $applyModel->renderSimOptFromData($data['apply_sim_opt'], $data['apply_jan']);
$data['option_child_special'] = $simOpt['option_child_special'];
?>
<?= $data['apply_surname'] ?><?= $data['apply_givenname'] ?>様


このたびは、イオンデジタルワールドをご利用いただき、誠にありがとうございます。
お客さまのお申込みを下記の内容で承りました。

※このメールは重要な情報を含んでおりますので、大切に保管してください。


---------------------------------------------------------------
[申込ID]  <?= $data['apply_id'] ?>

[お申込み日時] <?= $data['apply_date'] ?>

[オーダーID] <?= $data['apply_orderid'] ?>


【プラン】
<?= $data['plan_name'] ?> 

<?php if ($data['apply_sim_type'] == ApplyTbl::APPLY_SIM_TYPE_VOICE &&
        $data['apply_mnp_flg'] == ApplyTbl::APPLY_MNP_FLG_NOT_EXIT) : ?>
【MNP情報】
<?= ApplyTbl::$LABEL_MNP_FLG[$data['apply_mnp_flg']]; ?>

[MNP予約番号] <?= $data['apply_mnp_no']; ?>

<?php if (!empty($data['apply_mnp_limit'])) :?>
[MNP予約番号の有効期間] <?= date("Y/m/d", strtotime($data['apply_mnp_limit'])); ?>

<?php else :?>
[MNP予約番号の有効期間] 

<?php endif;?>
<?php endif;?>
    
<?php if ($data['apply_sim_type'] == ApplyTbl::APPLY_SIM_TYPE_VOICE) : ?>
【音声オプション】
<?= $data['apply_sim_audiotype_text'] ?> 
<?php endif;?>

【オプション】
<?= $data['sim_opt_text'];?>

<?php if ($data['apply_sim_type'] == ApplyTbl::APPLY_SIM_TYPE_VOICE ||
    (!empty($data['option_child_special']) && in_array(OptMst::$OPT_050FREECALL, $data['option_child_special']))) :?>

音声SIMをお申し込みのお客さまで本人確認書類の画像が未登録の場合、または不足している場合は
下記のURLからアクセスして画像をアップロードしてください。

<?= Yii::$app->params['domain'].'step3_2?order_id='.$data['apply_orderid'].'&value='.$data['apply_key']?>


※お申し込み後1週間以内にアップロードされた画像を確認できない場合は
お申し込みをキャンセルさせていただきますのでご注意ください。
<?php endif;?>

ご不明な点やご要望がございましたら、「イオンデジタルワールド」ページ上部の
「お問い合わせ」より、お気軽にご連絡ください。

こちらのメールは送信専用です。こちらのメールにご返信いただいてもご回答できませんのでご了承ください。

イオンデジタルワールド