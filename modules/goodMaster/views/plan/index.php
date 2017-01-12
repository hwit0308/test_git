<?php
    use yii\helpers\Url;
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;

    Yii::$app->view->title = 'プランマスタ管理';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">プランマスタ管理</h2>
    </div>
    <!-- /page title -->

    <div class="mBoxitem_table">
        <!-- info -->
        <div class="mBoxitem_listinfo">
            <div class="pageList_data">
                <div class="pageList_del_item">
                    <a class="simpleBtn" title="新規商品追加" href="<?= Url::to(['/goodMaster/plan/save']) ?>">新規プラン追加</a>
                </div>
            </div>
        </div>
        <!-- /info --> 
    </div>
<?php if (Yii::$app->session->hasFlash('message_delete')) : ?>
    <!-- complete message -->
    <p class="mBoxitem_txt txtWarning"><?= Yii::$app->session->getFlash('message_delete') ?></p>
    <!-- /complete message -->
<?php endif; ?>
    <div class="mBoxitem_table boxSearch"> 
        <!-- title3 -->
        <h4 class="iconTableTitle">検索条件</h4>
        <!-- /title3 -->

        <!-- search -->
        <?php $form = ActiveForm::begin([
            'action' => ['/goodMaster/plan/index'],
            'method' => 'get'
        ]); ?>
            <div class="bgSearch">
                <table cellspacing="0" cellpadding="0" border="0" class="tableTate">
                    <tbody><tr>
                            <td>プラン名</td>
                            <td><div class="fAssist_row">
                                    <?= Html::activeTextInput($formSearch, 'plan_name', ['class' => 'txtbox']); ?>
                                </div></td>
                        </tr>
                    </tbody></table>
            </div>

            <div class="mBoxitem_listinfo">
                <div class="btnGroup">
                    <?= Html::submitButton('検索する', ['class' => 'simpleBtn']) ?>
                    <?= Html::button('クリア', ['class' => 'simpleBtn' ,'onclick' => 'clearForm("/plan",this)']) ?>
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
        <!-- result -->
        <?php ActiveForm::begin([
            'options' => ['id' => 'form']
        ]);?>
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '<div class="pageList_data"><strong>全 {totalCount} 件中  {begin} 件～{end} 件を表示</strong>'
            . '</div><div class="pageList_del"><div class="pageList_del_item"><input type="button"'
            . ' onclick = "ConfirmDelete()" value="選択したデータを削除" id="delete" class="simpleBtn deleteBtn disable"'
            . ' title="選択したデータを削除"></div></div>',
            'layout' => '<div class="mBoxitem_listinfo">{summary}</div>{items}<div class="mBoxitem_listinfo">'
            . '<div id="paging" class="light-theme simple-pagination">{pager}</div></div>',
            'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',
             'header' => Html::checkBox('selection_all', false, ['class' => 'fCheckAll']),
             'checkboxOptions' => ['class' => 'fCheck'],
             'headerOptions' => ['class' => 'thYoko_Check'],
             'contentOptions' => ['class' => 'td_center']
            ],
                [
                    'attribute' => 'plan_code',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<a class="desc" data-pjax="0" href="'.Url::to(['/goodMaster/plan/detail',
                            'planId' => $model["plan_code"]]).'">'.$model['plan_code'].'</a>';
                    }
                ],
                [
                    'attribute' => 'plan_name',
                    'label' => 'プラン名',
                    'content' => function ($data) {
                        return Html::encode($data['plan_name']);
                    }
                ],
                [
                    'attribute' => 'plan_last_upd_user',
                    'label' => '最終更新者',
                    'content' => function ($data) {
                        return Html::encode($data['plan_last_upd_user']);
                    }
                ],
                [
                    'attribute' => 'plan_last_upd_date',
                    'value' => function ($model) {
                        if (!empty($model['plan_last_upd_date']) &&
                                $model['plan_last_upd_date'] != '0000-00-00 00:00:00') {
                            return date('Y/m/d H:i', strtotime($model['plan_last_upd_date']));
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
    <?php endif;?>
    <!-- /result -->
</td>
