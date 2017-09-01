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

//ajax処理
$(function() {
    $('#ajax_button').click(function() {
        var data = {
            date : $('#new_date').val(),
            client : $('#new_client').val(),
            vehicle : $('#new_vehicle').val(),
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
        return false;
    });
});
