$(function() {
    $("#show_button").click(function(){
        $("#input_form").css("display", "block");
    });
});

$(function() {
    $("#hide_button").click(function(){
        $("#input_form").css("display", "none");
    });
});

$(function() {
    $("#delete_button").click(function(){
        $("#delete_form").css("display", "block");
    });
});

$(function() {
    $("#delete_ajax_cancel").click(function(){
        $("#delete_form").css("display", "none");
    });
});

//
//ajax処理 追加
$(function() {
    $('#ajax_button').click(function() {
        var data = {
            date : $('#new_date').val(),
            client : $('#new_client').val(),
            vehicle_id : $('[name=new_vehicle]:checked').val(),
            _from : $('#new_from').val(),
            _to : $('#new_to').val(),
            cost : $('#new_cost').val(),
            overview : $('#new_overview').val(),
            staff_id : $('#staff_id_hidden').val()
        };
        $.ajax({
            type: "POST",
            url: "add.php",
            data : data,
            success: function(data, dataType){
                alert(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('Error: ' + errorThrown);
            }
        });
        location.reload();
        return false;
    });
});

//ajax処理 削除
$(function() {
    $('#delete_ajax_button').click(function() {
        var data = {
            delete_id : $('#delete_id').val(),
        };
        $.ajax({
            type: "POST",
            url: "Delete.php",
            data : data,
            success: function(data, dataType){
                alert(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('Error: ' + errorThrown);
            }
        });
        location.reload();
        return false;
    });
});

$(function() {
    $("#filter_button").click(function(){
        var test = $('#month_filter').val();
        console.log(test);
    });
});
