<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>DatePickerウィジェット</title>
<link type="text/css" rel="stylesheet"
  href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<!--1国際化対応のライブラリをインポート-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript">
$(function() {
  // 2日本語を有効化
  $.datepicker.setDefaults($.datepicker.regional['ja']);
  // 3日付選択ボックスを生成
  $('#date').datepicker({ dateFormat: 'yy-mm' });
});
</script>
</head>
<body>
<form method="POST" action="">
  <label>
    <input type="text" id="date" size="10" />
  </label>
</form>
</body>
</html>
