<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\models\GoodsPlan;
use common\models\GoodsMst;
use yii\helpers\ArrayHelper;
use common\components\Utility;
use arturoliveira\ExcelView;

$this->title = '商品情報照会';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">商品情報照会</h2>
    </div>
    <!-- /page title -->

    <div class="mBoxitem_table">
        <!-- info -->
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">
                <div class="pageList_del_item">
                    <a class="simpleBtn" title="新規商品追加" href="<?= Url::to(['/goodMaster/default/save']) ?>">新規商品追加</a>
                </div>
                <div class="pageList_del_item">
                    <?= Html::a('CSVインポート', ['import'], ['class' => 'simpleBtn'])?>
                </div>
            </div>
        </div>
        <!-- /info -->
    </div>

    <!-- complete message -->
    <?php if (Yii::$app->session->hasFlash('message_delete')) : ?>
        <p class="mBoxitem_txt txtWarning"><?= Yii::$app->session->getFlash('message_delete') ?></p>
    <?php endif; ?>
    <!-- /complete message -->

    <div class="mBoxitem_table boxSearch">
        <!-- title3 -->
        <h4 class="iconTableTitle">検索条件</h4>
        <!-- /title3 -->

        <!-- search -->
        <?php $form = ActiveForm::begin([
            'action' => ['/goodMaster/default/index'],
            'method' => 'get'
        ]); ?>
        <div class="bgSearch">
           <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                <tbody>
                    <tr>
                        <td>商品名</td>
                        <td>
                            <div class="fAssist_row">
                                <?= Html::activeTextInput($goodsMst, 'goods_name', ['class' => 'txtbox']); ?>
                            </div>
                        </td>
                        <td>メーカー</td>
                        <?php
                        $goodsName = ArrayHelper::map(GoodsMst::find()->where('goods_maker != ""')
                                ->groupBy('goods_maker')->asArray()->all(), 'goods_maker', 'goods_maker');
                        ?>
                        <td>
                            <div class="fAssist_row">
                                <?= Html::activeDropDownList($goodsMst, 'goods_maker', $goodsName, [
                                    'prompt'=>'--'], ['class' => 'txtbox']); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
           </table>
        </div>

        <div class="mBoxitem_listinfo">
            <div class="btnGroup">
                <?= Html::submitButton('検索する', ['class' => 'simpleBtn']) ?>
                <?= Html::button('クリア', ['class' => 'simpleBtn' ,'onclick' => 'clearForm("/goods",this)']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <!-- /search -->
    </div>

    <?php if ($dataProvider->getTotalCount() == 0) :?>
    <div class="mBoxitem_listinfo">
        <div class="searchNoData">
            <p class="txtWarning"><span class="iconNo">該当するデータが見つかりませんでした。</span></p>
        </div>
    </div>
    <?php else : ?>

    <div class="mBoxitem_table">
        <!-- result -->
        <?php ActiveForm::begin([
            'options' => ['id' => 'form']
        ]); ?>
        <?= Html::hiddenInput('csv', 'export', ['id' => 'hidden_submit']) ?>
        <?php Pjax::begin();?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '<div class="mBoxitem_listinfo">{summary}</div>{items}<div class="mBoxitem_listinfo">'
            . '<div id="paging" class="light-theme simple-pagination">{pager}</div></div>',
            'summary' => '<div class="pageList_data"><strong>全 {totalCount} 件中 {begin} 件～{end} 件を表示</strong></div>'
            . '<div class="pageList_del"><div class="pageList_del_item"><input type="submit" class="simpleBtn" '
            . 'title="" value="全データCSV出力" name="export"></div> <div class="pageList_del_item"><input type="button"'
            . ' onclick="ConfirmDeleteGoods()" value="選択したデータを削除" '
            . 'id="delete" class="simpleBtn deleteBtn disable" title="選択したデータを削除"></div></div>',
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'thYoko_Check'],
                    'header' => Html::checkBox('selection_all', false, [
                        'class' => 'fCheckAll',
                    ]),

                    'contentOptions' => function ($model, $key, $index, $column) {
                        return ['class' => 'td_center'];
                    },
                    'checkboxOptions' => ['class' => 'fCheck', 'onchange' => 'deleteRecord()', 'check' => 'false']
                ],
                [
                    'attribute' => 'goods_jan',
                    'label' => 'JANコード',
                    'contentOptions' => function ($model, $key, $index, $column) {
                        return ['class' => ''];
                    },
                    'content' => function ($data) {
                        return '<a class="desc" data-pjax="0" href="'.Url::to(['/goodMaster/default/detail',
                            'goodsJan' => $data["goods_jan"]]).'">'.$data['goods_jan'].'</a>';
                    }
                ],
                [
                    'attribute' => 'goods_name',
                    'label' => '商品名',
                    'content' => function ($data) {
                        return Html::encode($data['goods_name']);
                    }
                ],
                [
                    'attribute' => 'plan_name',
                    'label' => 'プラン',
                    'content' => function ($data) {
                        $listPlanName = GoodsPlan::getPlanName($data['goods_jan']);
                        return Utility::convertHtml($listPlanName);
                    }
                ],
                [
                    'attribute'=>'last_upd_date',
                    'label'=>'追加日付',
                    'content'=> function ($data) {
                        if (!empty($data['last_upd_date']) && $data['last_upd_date'] != '0000-00-00 00:00:00') {
                            return date('Y/m/d H:i', strtotime($data['last_upd_date']));
                        } else {
                            return '';
                        }
                    }
                ]
            ],
            'tableOptions' => ['class' => 'tableYoko'],
            'pager' => [
                'prevPageLabel'=>'前へ',
                'nextPageLabel'=>'次へ',
                'firstPageLabel'=>'最初',
                'lastPageLabel' => '最後',
                'activePageCssClass' => 'current',
                'disabledPageCssClass' => 'forward current',
                'maxButtonCount'=> Yii::$app->params['maxButton'],
                'options' => [
                    'class' => 'pager-wrapper',
                    'id' => 'pager-container',
                ],
            ],

        ]); ?>
    <?php Pjax::end(); ?>
    <?php ActiveForm::end(); ?>
    </div>
    <!-- /result -->
    <?php endif;?>
</td>
