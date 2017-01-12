<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\models\FormImportCSV;

$this->title = '商品情報CSVインポート';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">商品情報CSVインポート</h2>
    </div>
    <!-- /page title -->
       
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
        <div class="mBoxitem_table">
            <div title="担当ケアマネージャー選択"> 
                <!-- result table-->
                <div class="mBoxitem_table"> 
                    <!-- info -->
                    <div class="mBoxitem_listinfo">
                        <div>商品情報のデータをCSVファイルから一括でインポートします。<br>CSVを選択して、[データインポート実行]ボタンをクリックしてください。</div>
                    </div>
                    <!-- /info --> 
                </div>
              <!-- /result table -->
            </div>
            
            <div class="statusBox mb15">
                <ul class="listDot">
                    <li>JANコードが同一のデータが存在する場合、CSVファイルの内容で上書きします。</li>
                    <li>CSVファイル内でJANコードが重複する場合、後から登録されるデータのみが有効となります。</li>
                </ul>
            </div>
            
            <!-- errors message -->
            <?php
            $err = $model->getErrors();
            if (Yii::$app->session->hasFlash('error_number_csv')) {
                $err['error_number_csv'] = [0 => Yii::$app->session->getFlash('error_number_csv')];
            }
            ?>
            <?php if ($err) : ?>
                <div class = "mBoxitem_txt txtWarning">
                    <ul>
                        <?php foreach ($err as $key => $value) : ?>
                            <li><?php echo $value[0] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <!-- /errors message -->
            <p id="txt-error"></p>
            <div title="担当ケアマネージャー選択"> 
              <!-- search -->
                <div class="mBoxitem_table">
                    <table cellspacing="0" cellpadding="0" border="0" class="tableTate tableDetail">
                        <tbody>
                            <tr>
                            <th class="must">CSVファイル</th>
                            <td>
                                <div class="fAssist_row">
                                    <?= Html::activeFileInput($model, 'file', ['class' => 'fFile', 'id' => 'importCSV',
                                        ])?>
                                    <label for="importCSV" class="simpleBtn">ファイル選択</label>
                                    <span id="pathCSV">選択されていません。</span>
                                </div>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              <!-- /search --> 
            </div>
        </div>
        <div class="BtnArea">
            <?= Html::submitButton('データインポート実行', ['class' => 'btnGray', 'id' => 'btnSubmitCsv'])?>
        </div>
    <?php ActiveForm::end(); ?>
</td>
