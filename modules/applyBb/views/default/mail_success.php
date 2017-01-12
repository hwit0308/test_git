<?php
use yii\helpers\Url;

$this->title = 'メール再送信完了';
?>
<td id="main"><!-- main contents -->
    <!-- page title -->
    <div class="titlebarMain_bg">
        <h2 class="titlebarMain_icon">メール再送信完了</h2>
    </div>
    <!-- /page title -->
    <div class="mBoxitem_table boxAppDetail">
        <p class="title">申込完了メールを再送しました。</p>
        
        <div class="mBoxitem_listinfo">
            <div class="btnGroup btnGroupMail" style="margin-top: 80px;">
                <a href="<?= Url::to(['/applyBb/default/detail', 'applyId' => $applyId]);?>"
                   type="submit" class="btnGray" value="プラン変更・オプション追加申込内容詳細画面へ">プラン変更・オプション追加申込内容詳細画面へ</a>
            </div>
        </div>
    </div>
</td>
