<?php
    if(!preg_match("/islander/",$_SERVER['HTTP_USER_AGENT']))header("Location:island://");
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>Mins Island</title>
    <meta name="viewport" content="user-scalable=no, width=device-width,initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="island.css">
    <script src="https://minstreams.com/JQuery/jquery-3.4.1.min.js"></script>
    <?php
    if(isset($_COOKIE["idMark"])&&($_COOKIE["idMark"]=='U'||$_COOKIE["idMark"]=='A')){
        //已经登陆
        echo "<script>
            $.ajax({
                url: 'loginCheck.php?login=true',
                success: function (res) {
                    document.write(res);
                }
            });
        </script>";
    }
    ?>
</head>

<body>
    <div style='flex-grow:1;'></div>
    <iframe name="nullFrame" width="1px" height="1px" style="display: none;"></iframe>
    <form target='nullFrame' action=''>
        <input id='password' type='password' name='password'>
        <input id='confirm' class='button' type='submit' value='确定'>
    </form>
    <div style='flex-grow:1;'></div>
    <script>
        $('form').submit(function(){
            $.ajax({
                url: 'loginCheck.php?password=' + $('#password').val(),
                success: function (res) {
                    document.write(res);
                }
            });
        });
    </script>
</body>