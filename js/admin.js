$(function() {
    $('#filter').click(function() {
        var data = {
            month : $("#filter_month").val()
        };
        $.ajax({
            type: "POST",
            url: "_ajax.php",
            data : data,
            success: function(data, dataType){
                $(".all_term_info").css('display', 'none');

                //全部繋がった文字列で返ってきているので配列にする
                console.log(data);
                var array_data = JSON.parse(data);

            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('Error: ' + errorThrown);
            }
        });
        return false;
    });
});

$(function() {
    $("#all_term").click(function(){
        location.reload();
    });
});
