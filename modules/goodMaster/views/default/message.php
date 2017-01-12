<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '商品情報CSVインポート完了';
$error = '';
if (count($messageErrors) > 0) {
    foreach ($messageErrors as $key => $value) {
        $error .= '<li>'.$value.'行目 </li></br>';
    }
}
?>
            <td id="main"><!-- main contents -->
                <!-- page title -->
                <div class="titlebarMain_bg">
                    <h2 class="titlebarMain_icon">商品情報CSVインポート完了</h2>
                </div>
                <!-- /page title -->

                <div class="mBoxitem_table">
                    <div title="担当ケアマネージャー選択" id="jquery-ui-dialog"> 
                    <!-- result table-->
                        <div class="mBoxitem_table">
                            <div class="mBoxitem_listinfo">
                                <div class="pageList_data">商品情報のデータインポートが完了しました。</div>
                            </div>
                            <div class="mBoxitem_listinfo">
                                <div class="pageList_data"><strong>インポート結果</strong></div>
                            </div>
                        </div>
                    <!-- /result table -->
                    </div>

                    <div class="statusBox mb15">
                        <p>登録データ件数：　<?= $successCount ?> 件</p>
                        <p>エラー件数：　<span class="txtWarning"><?= $errorsCount ?></span> 件</p>
                        <ul class="txtWarning listDot lineError">
                            <?= $error ?>
                        </ul>
                    </div>
                </div>

                <div class="BtnArea">
                    <div class="BtnAreaitem">
                        <a href="<?= Url::to(['/goodMaster/default/index'])?>" class="btnGray">商品情報照会へ</a>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
  
