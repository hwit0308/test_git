
function importCSV(){
  // set filename to the label import file CSV
    $('#importCSV').bind("change",function() {
        if($('#importCSV').val() == ''){
            $('#pathCSV').text($('#importCSV').val().replace('', '選択されていません。'))
        }else {
            var size = parseInt(this.files[0].size/1024/1024);
            if (size > 8) {
                $('.mBoxitem_txt.txtWarning').html('');
                $('#txt-error').html('CSVファイルのサイズを8Mb以下しか許可されていません。ファイルをご確認ください。');
                $("#w0").find("button[type=submit]").attr("disabled","disabled");
            } else {
                $('#txt-error').html('');
                $("#w0").find("button[type=submit]").removeAttr("disabled");
            }
            $('#pathCSV').text($('#importCSV').val().replace(/C:\\fakepath\\/i, ''))
        }
        return false;
    });
}

// datepicker
function datepickerTrigger(){
  $( ".datepicker" ).datepicker({
    showOn: "button",
    buttonImage: baseUrl + "/css/datepicker/images/calendar.jpg",
	buttonImageOnly: true,
	buttonText: "Select date",
    dateFormat: "yy/mm/dd"
  });
  $(".datepicker").click(function(e){
    $(this).next(".ui-datepicker-trigger").trigger('click');
  })
  $.datepicker.regional['ja'] = {
    closeText: '閉じる',
    prevText: '<前',
    nextText: '次>',
    currentText: '今日',
    monthNames: ['1月','2月','3月','4月','5月','6月',
    '7月','8月','9月','10月','11月','12月'],
    monthNamesShort: ['1月','2月','3月','4月','5月','6月',
    '7月','8月','9月','10月','11月','12月'],
    dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
    dayNamesShort: ['日','月','火','水','木','金','土'],
    dayNamesMin: ['日','月','火','水','木','金','土'],
    weekHeader: '週',
    dateFormat: 'yy/mm/dd',
    firstDay: 0,
    isRTL: false,
    showMonthAfterYear: true,
    yearSuffix: '年'};
    $.datepicker.setDefaults($.datepicker.regional['ja']);
}
$(document).on("click", ".fCheckAll", function () {
    var fCheckAll = $('.fCheckAll'),
    deleteBtn = $('.deleteBtn');
    fCheck = $('.fCheck');
    if(fCheckAll.is(":checked")){
      fCheck.prop("checked", true);
      fCheck.attr('checked','checked');
      deleteBtn.removeClass('disable');
    } else {
      fCheck.prop("checked", false);
      fCheck.removeAttr('checked');
      deleteBtn.addClass('disable');
    }
});
$(document).on("click", ".fCheck", function () {
        var checked = $(".fCheck:checked").length > 0;
        deleteBtn = $('.deleteBtn');
        if (checked){
            deleteBtn.removeClass('disable');
            }else{
            deleteBtn.addClass('disable');
            }
});
// delete records
function deleteRecord(){
    var fCheckAll = $('.fCheckAll'),
    fCheck = $('.fCheck'),
    deleteBtn = $('.deleteBtn');
    if(fCheckAll.is(":checked")){
        fCheck.attr('checked','checked');
    }
//  $(document).on("click", ".fCheckAll", function () {
//    if(fCheckAll.is(":checked")){
//      fCheck.prop("checked", true);
//      fCheck.attr('checked','checked');
//      deleteBtn.removeClass('disable');
//
//    } else {
//      fCheck.prop("checked", false);
//      fCheck.removeAttr('checked');
//      deleteBtn.addClass('disable');
//    }
//  });
    $(document).on("change", ".fCheck", function () {
        var checkCount = $('.mBoxitem_table').find('.fCheck:checked').length;
        itemCount = fCheck.length;
        if(checkCount>0){
            if(checkCount == itemCount ){
            fCheckAll.prop("checked", true);
            //CheckAll.attr('checked','checked');   
        }else {
            fCheckAll.prop("checked", false);
            fCheckAll.removeAttr('checked');
        }
        deleteBtn.removeClass('disable');
        }else {
            fCheckAll.prop("checked", false);
            fCheckAll.removeAttr('checked');
            deleteBtn.addClass('disable');
        }
    });
//  deleteBtn.on('click', function (e) {
//    e.preventDefault();
//    if(!$(this).hasClass('disable')) {
//      confirmDeleteContents();
//    } 
//  })
}

// start app
$(function(){
  importCSV();
  datepickerTrigger();
  deleteRecord();
});