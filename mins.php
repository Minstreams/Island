<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>Mins Island</title>
    <link rel="stylesheet" type="text/css" href="/island.css">
    <script src="https://minstreams.com/JQuery/jquery-3.4.1.min.js"></script>
</head>

<body>
    <h1>Mins Island</h1>
    <div id='textDiv'></div>
    <div id='inputDiv' contenteditable='plaintext-only'></div>
    <button id='confirm'>发布</button>
    <script>
        $('#textDiv').html('加载中...');
        function refresh() {
            $.ajax({
                url: 'minsInsertText.php?',
                success: function (res) {
                    $('#textDiv').html(res);
                }
            });
        }
        refresh();
        setInterval(refresh,2000);
        $('#confirm').click(function () {
            if (!$('#inputDiv').text()) return;
            $('#textDiv').html('发布中...');
            let tt = $('#inputDiv').text();
            $('#inputDiv').text('');
            $.ajax({
                url: 'minsInsertText.php?text=' + tt,
                success: function (res) {
                    $('#textDiv').html(res);
                }
            });
        });
    </script>
</body>