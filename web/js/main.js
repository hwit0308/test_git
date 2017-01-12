function clearForm(value,object){
        return window.location.href = baseUrl + value;
}

// select pack item
$(document).on("change", ".packName", function () {
    $('.pack').find('.sCheck.opt').attr("disabled", true);
    $('.pack').find('.fLabel.opt').addClass('disable');
    if($(this).val() == ''){
      $('.pack').find('.sCheck').removeAttr("disabled", true);
      $('.pack').find('.fLabel').removeClass('disable');
    }
});

$(document).on("click", ".fCheckAllOpt", function () {
    var fCheckAll = $('.fCheckAllOpt'),
    deleteBtn = $('.deleteBtn');
    fCheck = $('.fCheck');
    if(fCheckAll.is(":checked")){
        if (fCheck.hasClass('disabled') === false) {
            fCheck.prop("checked", true);
            fCheck.attr('checked','checked');
        }
        var opt = $(".fCheck");
        var i = 0;
        opt.each(function( index ) {
            if($(this).hasClass('disabled') === false ) {
                i++;
            }
        });
        if (i > 0) {
            deleteBtn.removeClass('disable');
        }
    } else {
      fCheck.prop("checked", false);
      fCheck.removeAttr('checked');
      deleteBtn.addClass('disable');
    }
});

$(function() {
    
    $("#sortableTvalu1").sortable({
        stop: function(event, ui) {
            var listPlan = [];
            var plan = $("#sortableTvalu1 li");
            plan.each(function( index ) {
                listPlan.push($(this).attr('plan_code'));
            });
            $('#listPlan').val(listPlan);
        }
    });
    $( "#sortableTvalu1" ).disableSelection();

    $( "#sortableTvalu2" ).sortable({
        stop: function(event, ui) {
            var listOpt2 = [];
            var Opt2 = $("#sortableTvalu2 li");
            Opt2.each(function( index ) {
                listOpt2.push($(this).attr('opt'));
            });
            $('#opt_2').val(listOpt2);
        }
    });
    $( "#sortableTvalu2" ).disableSelection();

    $( "#sortableTvalu3" ).sortable({
        stop: function(event, ui) {
            var listOpt3 = [];
            var Opt3 = $("#sortableTvalu3 li");
            Opt3.each(function( index ) {
                listOpt3.push($(this).attr('opt'));
            });
            $('#opt_3').val(listOpt3);
        }
    });
    $( "#sortableTvalu3" ).disableSelection();
});