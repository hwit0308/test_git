<?php
use common\models\AeonbbApplyTbl;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\widgets\ImageEditWidget;
use common\models\PlanMst;
use common\models\OptMst;
use backend\models\FormSearchApplyBb;

$this->title = 'プラン変更・オプション追加申込内容詳細';

$optMst = new OptMst();
$applyOld = AeonbbApplyTbl::getOldApply($data['apply_id']);
$optOld = $optMst->renderSimOpt($applyOld['apply_sim_opt'], $data['apply_jan']);

?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">プラン変更・オプション追加申込内容詳細</h2>
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
            <tbody>
                <tr>
                    <th>お客様ID</th>
                    <td><?= $data['apply_memberid'];?></td>
                </tr>
                <tr>
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
                        <a href="<?= Url::to(['/applyBb/default/mail-detail',
                            'applyId' => $data["apply_id"]])?>" class="simpleBtn">メールを再送する</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>画像有無</th>
                    <td><?= array_key_exists($data['apply_img_status'], AeonbbApplyTbl::$LABEL_APPLY_IMG_STATUS) ?
                                    AeonbbApplyTbl::$LABEL_APPLY_IMG_STATUS[$data['apply_img_status']] :
                                $data['apply_img_status'];?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?= $data['apply_tel']; ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?= $data['apply_mail']; ?></td>
                </tr>
            </tbody>
        </table>
        
        <h4 class="iconTableTitle">プラン</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>変更前</th>
                    <td>
                        <?php $planName = PlanMst::getPlanNameBeforeChange($data['apply_idx_before']);?>
                        <?= $planName['plan_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>変更後</th>
                    <td><?= Html::encode($data['plan_name'])?></td>
                </tr>
            </tbody>
        </table>
        
        <h4 class="iconTableTitle">オプション</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody>
                <tr>
                    <th>契約中オプション</th>
                    <td><?= FormSearchApplyBb::renderTextOption($optOld)?></td>
                </tr>
                <tr>
                    <th>追加オプション</th>
                    <td><?= FormSearchApplyBb::renderTextOption($data['sim_opt']);?></td>
                </tr>
            </tbody>
        </table>
        <?php if (count($optionShare) > 0): ?>
        <?php foreach ($optionShare as $key => $value) : ?>
        <h4 class="iconTableTitle">シェアプランのオプション<?= ($key +1); ?></h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>SIM電話番号</th>
                    <td><?= $value->sim_tel?></td>
                </tr>
                <tr>
                    <th>契約中オプション</th>
                    <td><?= FormSearchApplyBb::renderTextOption($optOld)?></td>
                </tr>
                <tr>
                    <th>追加オプション</th>
                    <td>
                        <?php $simOpt = $optMst->renderSimOpt($value->sim_opt, $data['apply_jan']);?>
                        <?= FormSearchApplyBb::renderTextOption($simOpt);?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php endforeach;?>
        <?php endif;?>
        
        <h4 class="iconTableTitle">本人確認書類</h4>
        <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
            <tbody><tr>
                    <th>本人確認書類</th>
                    <td>
                        <?= !empty($data['apply_doctype']) ?
                                AeonbbApplyTbl::$LABEL_DOCTYPE[$data['apply_doctype']] : '' ?></td>
                </tr>
            </tbody>
        </table>
        
        <h4 class="iconTableTitle">本人確認書類画像</h4>
        <div class="inner" style="width: 100%; display: inline-block">
            <?= ImageEditWidget::widget(['apply_id' => $data['apply_id'],
                'showFlag' => 1, 'flag' => true]) ?>
        </div>
        
    </div>
</td>
