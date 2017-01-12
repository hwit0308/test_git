<?php
use yii\helpers\Url;
use common\models\OptMst;
use common\models\AeonbbApplyTbl;
use common\models\PlanMst;
use yii\helpers\Html;

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
?>
<?= $data['apply_surname'] ?><?= $data['apply_givenname'] ?>様


このたびは、イオンデジタルワールドをご利用いただき、誠にありがとうございます。
お客さまのお申込みを下記の内容で承りました。

※このメールは重要な情報を含んでおりますので、大切に保管してください。


---------------------------------------------------------------
[お申込み番号]  <?= $data['apply_id'] ?>

[お申込み日時] <?= $data['apply_date'] ?>

【プラン】
<?= $data['plan_name'] ?> 

【オプション】
<?= $data['sim_opt_text'];?>

<?php if (count($optionShare) > 0): ?>
<?php foreach ($optionShare as $key => $value) : ?>
【シェアプランオプション<?= ($key+1)?>】
SIM電話番号:<?= $value->sim_tel?>
<?php 
    $simOpt = $optMst->renderSimOpt($value->sim_opt, $data['apply_jan']);
    $optText = '';
    if (count($simOpt) > 0) {
        $indent = '';
        
        foreach ($simOpt as $key => $value) {
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
?>
<?= $optText;?>
<?php endforeach;?>
<?php endif;?>
ご不明な点やご要望がございましたら、「イオンデジタルワールド」ページ上部の
「お問い合わせ」より、お気軽にご連絡ください。

こちらのメールは送信専用です。こちらのメールにご返信いただいてもご回答できませんのでご了承ください。

イオンデジタルワールド