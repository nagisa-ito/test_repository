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
                $("#test").prepend("<th>あああ</th>");
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

//ajax処理 絞り込み
$(function() {
    $('#filter_button').click(function() {
        var data = {
            filtering_id : $("#filter_req_id").val(),
            month : $('#month_filter').val()
        };
        $.ajax({
            type: "POST",
            url: "filter.php",
            data : data,
            success: function(data, dataType){
                //全部繋がった文字列で返ってきているので配列にする
                var array_data = JSON.parse(data);
                console.log(array_data);

                var cost = Number(0);

                $(".reset").empty();
                for(var i = 0; i < array_data.length; i++){
                    cost += Number(array_data[i]['cost']);

                    var str = "";
                    str = "<th>" + array_data[i]['id'] + "</th>"
                            + "<th>" + array_data[i]['date'] + "</th>"
                            + "<th>" + array_data[i]['client'] + "</th>"
                            + "<th>" + array_data[i]['vehicle_id'] + "</th>"
                            + "<th>" + array_data[i]['_from'] + "</th>"
                            + "<th>" + array_data[i]['_to'] + "</th>"
                            + "<th>" + array_data[i]['cost'] + "</th>"
                            + "<th>" + array_data[i]['overview'] + "</th>";

                    str = "<tr class='reset'>" + str + "</tr>";
                    $("#add_row").after(str);
                }
                $("#total_cost").html(cost);
                $(".hide").css("display", "none");
                alert("データを絞り込みました");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('Error: ' + errorThrown);
            }
        });
        return false;
    });
});
