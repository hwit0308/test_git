//form.js
    function ConfirmDelete() {
        var contents = "";
        contents += '<p class=confirm_text>選択したデータを削除しますが、よろしいですか？</p><div class=dialogItem>';
        contents += '<input class="confirm_ok" type="button" value="OK" onclick="submitform();"/>';
        contents += '<input type="button" value="キャンセル" class="confirm_cancel" onclick="hideDialog();"></div>';
        showDialog('削除確認', contents, 'prompt');
    }
    function submitform() {
        $('form#form').submit();
    }
    
    function ConfirmDeleteGoods(){
        var contents = "";
        contents += '<p class=confirm_text>選択したデータを削除しますが、よろしいですか？</p><div class=dialogItem>';
        contents += '<input class="confirm_ok" type="button" value="OK" onclick="submitformDelete();"/>';
        contents += '<input type="button" value="キャンセル" class="confirm_cancel" onclick="hideDialog();"></div>';
        showDialog('削除確認', contents, 'prompt');
    }
    function submitformDelete(){
        $('#hidden_submit').val('delete');
        $('form#form').submit();
    }
    $(document).ready( function() {
        $("form").submit(function(event) {
           var form = event.currentTarget;
           $("#" + form.id).find("button[type=submit]").attr("disabled","disabled");
        });
     })