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
            one_way_or_round : $("[name=new_one_way_or_round]:checked").val(),
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
            staff_id : $("#staff_id_hidden").val(),
            delete_id : $('#delete_id').val()
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
        var month = $('#month_filter').val();
        month = month + "月分";
        $("#request_month").text(month);
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
                console.log(data);
                var array_data = JSON.parse(data);

                var cost = Number(0);

                $(".reset").empty();
                for(var i = 0; i < array_data.length; i++){
		    
		    var cost_each = delimit(array_data[i]['cost']);

                    cost += Number(array_data[i]['cost']);
		    cost2 = delimit(cost);

		    overview_zwei = SelectorEscape(array_data[i]['overview']);

                    var str = "";
                    str = "<td>" + array_data[i]['id'] + "</td>"
                            + "<td>" + array_data[i]['date'] + "</td>"
                            + "<td>" + array_data[i]['client'] + "</td>"
                            + "<td>" + array_data[i]['vehicle_type'] + "</td>"
                            + "<td>" + array_data[i]['_from'] + "</td>"
                            + "<td>" + array_data[i]['_to'] + "</td>"
                            + "<td>¥" + cost_each + "</td>"
                            + "<td>" + array_data[i]['one_way_or_round'] + "</td>"
                            + "<td>" + overview_zwei + "</td>";

                    str = "<tr class='reset'>" + str + "</tr>";
                    $("#add_row").after(str);
                }
                cost2 = "¥" + cost2;
                $("#total_cost").html(cost2);
                $(".data_all").css("display", "none");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('Error: ' + errorThrown);
            }
        });
        return false;
    });
});

function disp(){

	// 「OK」時の処理開始 ＋ 確認ダイアログの表示
	if(window.confirm('実行しますか？')){
		window.aleat('処理を実行しました。')
	}
	// 「OK」時の処理終了

	// 「キャンセル」時の処理開始
	else{
		window.alert('キャンセルされました'); // 警告ダイアログを表示
	}
	// 「キャンセル」時の処理終了
}

var delimit = function(n) {  
  return String(n).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
};

function SelectorEscape(val){
    return val.replace(/[ !"#$%&'()*+,.\/:;<=>?@\[\\\]^`{|}~]/g, "\\$&");
};
