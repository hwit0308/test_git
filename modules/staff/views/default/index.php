<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\models\StaffMst;

$this->title ='ユーザ情報照会';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">ユーザ情報照会</h2>
    </div>
    <!-- /page title -->
    <?php if (Yii::$app->session->hasFlash('message_delete')) :?>
        <p class="mBoxitem_txt txtWarning"><?= Yii::$app->session->getFlash('message_delete') ?></p>
    <?php endif;?>
    <div class="mBoxitem_table boxSearch"> 
        <!-- title3 -->
        <h4 class="iconTableTitle">検索条件</h4>
        <!-- /title3 -->

        <!-- search -->
        <?php $form = ActiveForm::begin([
            'action' => ['/staff/default/index'],
            'method' => 'get'
        ]); ?>
            <div class="bgSearch">
                <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                    <tbody><tr>
                            <td>ユーザID</td>
                            <td><div class="fAssist_row">
                                    <?= Html::activeTextInput($model, 'staff_id', ['class' => 'txtbox']); ?>
                                </div></td>
                            <td>ユーザ名</td>
                            <td><div class="fAssist_row">
                                    <?= Html::activeTextInput($model, 'staff_name', ['class' => 'txtbox']); ?>
                                </div></td>
                        </tr>
                    </tbody></table>
            </div>

            <div class="mBoxitem_listinfo">
                <div class="btnGroup">
                    <?= Html::submitButton('検索する', ['class' => 'simpleBtn']) ?>
                    <?= Html::button('クリア', ['class' => 'simpleBtn' ,'onclick' => 'clearForm("/staff",this)']) ?>
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
    <?php else :?>
    <div class="mBoxitem_table">
        <?php ActiveForm::begin([
            'options' => ['id' => 'form']
        ]); ?>
        <?php Pjax::begin();?>
        <!-- result -->
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '<div class="mBoxitem_listinfo">{summary}</div>{items}<div class="mBoxitem_listinfo">'
                        . '<div id="paging" class="light-theme simple-pagination">{pager}</div></div>',
            'summary' => '<div class="pageList_data"><strong>全 {totalCount} 件中 {begin} 件～{end} 件を表示</strong>'
                        . '</div><div class="pageList_del"><div class="pageList_del_item">'
                        . '<div class="pageList_del_item">'
                        . '<input type="button" onclick="ConfirmDelete()" value="選択したデータを削除" id="delete" '
                        . 'class="simpleBtn deleteBtn disable" title="選択したデータを削除"></div></div></div>',
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
                    'checkboxOptions' => function ($model, $key, $index, $widget) {
                        return ["value" => $model['staff_id'] ,'class' => 'fCheck' ,'name' => 'staff_id'];
                    },
                ],
                [
                    'attribute' => 'staff_id',
                    'label' => 'ユーザID',
                    'content' => function ($data) {
                        return '<a class="desc" data-pjax="0" href="'.Url::to(['/staff/default/detail',
                            'staffId' => $data["staff_id"]]).'">'.
                                Html::encode($data['staff_id']).'</a>';
                    }
                ],
                [
                    'attribute' => 'staff_name',
                    'label' => 'ユーザ名',
                    'content' => function ($data) {
                        return Html::encode($data['staff_name']);
                    }
                ],
                [
                    'attribute' => 'staff_auth_level',
                    'label' => '権限',
                    'content' => function ($data) {
                        return array_key_exists($data['staff_auth_level'], StaffMst::$STAFF_AUTH) ?
                                StaffMst::$STAFF_AUTH[$data['staff_auth_level']] : $data['staff_auth_level'];
                    }
                ],
                [
                    'attribute' => 'staff_status',
                    'label' => 'アカウントの状態',
                    'content' => function ($data) {
                        return array_key_exists($data['staff_status'], StaffMst::$LABEL_STATUS) ?
                                StaffMst::$LABEL_STATUS[$data['staff_status']] : $data['staff_status'];
                    }
                ],
                [
                    'attribute' => 'staff_reg_date',
                    'label' => '登録日時',
                    'content' => function ($data) {
                        if (!empty($data['staff_reg_date']) &&
                                $data['staff_reg_date'] != '0000-00-00 00:00:00') {
                            return date('Y/m/d H:i', strtotime($data['staff_reg_date']));
                        } else {
                            return '';
                        }
                    }
                ],
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
        <?php ActiveForm::end(); ?>
    </div>
    <!-- /result -->
    <?php endif;?>
</td>
