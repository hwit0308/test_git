<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\models\ApplyTbl;

$this->title ='契約者申込照会';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">契約者申込照会</h2>
    </div>
    <!-- /page title -->

    <div class="mBoxitem_table boxSearch"> 
        <!-- title3 -->
        <h4 class="iconTableTitle">検索条件</h4>
        <!-- /title3 -->

        <!-- search -->
        <?php $form = ActiveForm::begin([
            'action' => ['/apply/default/index'],
            'method' => 'get'
        ]); ?>
            <div class="bgSearch">
                <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                    <tbody><tr>
                            <td>申込ID</td>
                            <td><div class="fAssist_row">
                                    <?= Html::activeTextInput($formSearch, 'apply_id', ['class' => 'txtbox']); ?>
                                </div></td>
                            <td>商品名</td>
                            <td><div class="fAssist_row">
                                    <?= Html::activeTextInput($formSearch, 'goods_name', ['class' => 'txtbox']); ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td>オーダーID</td>
                            <td>
                                <div class="fAssist_row">
                                    <?= Html::activeTextInput($formSearch, 'apply_orderid', ['class' => 'txtbox with50']); ?>
                                </div>
                                <span class="label-search">注文番号</span>
                                <div class="fAssist_row">
                                    <?= Html::activeTextInput($formSearch, 'apply_sales', ['class' => 'txtbox with50']); ?>
                                </div>
                            </td>
                            <td>お客様名</td>
                            <td><div class="fAssist_row">
                                    <?= Html::activeTextInput($formSearch, 'user_name', ['class' => 'txtbox']); ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td>申込日付</td>
                            <td><div class="fAssist_row">
                                <?= Html::activeTextInput($formSearch, 'date_1', ['class' => 'txtbox datepicker']); ?>
                                - <?= Html::activeTextInput($formSearch, 'date_2', ['class' => 'txtbox datepicker']); ?>
                                </div></td>
                            <td>ステータス</td>
                            <td><div class="fAssist_row">
                                <?=
                                Html::activeDropDownList($formSearch, 'status', ApplyTbl::$LABEL_STS, [
                                    'class' => 'txtbox' ,'prompt'=>'選択しない']);
                                ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td>画像有無</td>
                            <td>
                                <?=
                                Html::activeRadioList(
                                    $formSearch,
                                    'img_status',
                                    ApplyTbl::$LABEL_APPLY_IMG_STATUS,
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<label>'.Html::radio($name, $checked, [
                                                'value' => $value, 'id' => $value, 'class' => 'fRadio'])
                                                    . '<span class="fLabel">' . $label . '</span></label>';
                                        }
                                    ]
                                );
                                ?>
                            </td>
                        </tr>
                    </tbody></table>
            </div>

            <div class="mBoxitem_listinfo">
                <div class="btnGroup">
                    <?= Html::submitButton('検索する', ['class' => 'simpleBtn']) ?>
                    <?= Html::button('クリア', ['class' => 'simpleBtn' ,'onclick' => 'clearForm("/apply",this)']) ?>
                   
                </div>
            </div>
        <?php ActiveForm::end(); ?>
        <!-- search -->
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
        <?php Pjax::begin();?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '<div class="mBoxitem_listinfo">{summary}</div>{items}<div class="mBoxitem_listinfo">'
                        . '<div id="paging" class="light-theme simple-pagination">{pager}</div></div>',
            'summary' => '<div class="pageList_data"><strong>全 {totalCount} 件中 {begin} 件～{end} 件を表示</strong>'
                        .'</div><div class="pageList_del"><div class="pageList_del_item"></div></div>',
            'columns' => [
                [
                    'attribute'=>'apply_id',
                    'label'=>'申込ID',
                    'content' => function ($data) {
                        return '<a class="desc" data-pjax="0" href="'.Url::to(['/apply/default/detail',
                            'applyId' => $data["apply_id"]]).'">'.$data['apply_id'].'</a>';
                    }
                ],
                [
                    'attribute'=>'apply_orderid',
                    'label'=>'オーダーID',
                    'content' => function ($data) {
                        return $data['apply_orderid'];
                    }
                ],
                [
                    'attribute'=>'apply_sales',
                    'label'=>'注文番号',
                    'content' => function ($data) {
                        return $data['apply_sales'];
                    }
                ],
                [
                    'attribute'=>'goods_name',
                    'label'=>'商品名',
                    'content' => function ($data) {
                        return Html::encode($data['goods_name']);
                    }
                ],
                [
                    'attribute' => 'full_name',
                    'label' => 'お客様',
                    'content' => function ($data) {
                        return Html::encode($data['apply_surname']).
                                Html::encode($data['apply_givenname']);
                    }
                ],
                [
                    'attribute' => 'apply_sts',
                    'label' => 'ステータス',
                    'content' => function ($data) {
                        return array_key_exists($data['apply_sts'], ApplyTbl::$LABEL_STS) ?
                                ApplyTbl::$LABEL_STS[$data['apply_sts']] : $data['apply_sts'];
                    }
                ],
                [
                    'attribute' => 'apply_date',
                    'label' => '申請日時',
                    'content' => function ($data) {
                        if (!empty($data['apply_date']) && $data['apply_date'] != '0000-00-00 00:00:00') {
                            return date('Y/m/d H:i', strtotime($data['apply_date']));
                        } else {
                            return '';
                        }
                    }
                ]
            ],
            'tableOptions' =>['class' => 'tableYoko'],
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
    </div>
    <!-- /result -->
    <?php endif;?>

</td>
