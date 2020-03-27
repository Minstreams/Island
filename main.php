<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>Mins Island</title>
    <meta name="viewport" content="user-scalable=no, width=device-width,initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="island.css">
    <script src="https://minstreams.com/JQuery/jquery-3.4.1.min.js"></script>
</head>

<body>
    <h1>Mins Island</h1>
    <h3>欢迎 <?php include('getUserName.php'); ?><div style='flex-grow:1;'></div><button id='logout'>logout</button></h3>
    <input id='uploadEmojiHide' type='file' accept="image/png,image/jpeg,image/gif">
    <div id='textDiv'></div>
    <div id='footerPlaceholder'></div>
    <div id='footerDiv'>
        <div id='inputFlex'>
            <div contenteditable='plaintext-only' id="inputDiv"></div>
            <div id='emoji' class='inputButton'>😀</div>
            <div id='publish' class='inputButton'>发布</div>
        </div>
        <div id='emojiPool'>
        </div>
    </div>
    <script>
        let emojiMode = false;
        $('#textDiv').html('加载中...');
        function update(text,img) {
            $.ajax({
                url: 'update.php' + 
                (img ? '?img=' + img : '')+
                (text ? '?text=' + text : ''),
                success: function (res) {
                    //返回为false，代表数据无需更新
                    if (res == false) return;
                    $('#textDiv').html(res);
                    if (text||img) bottom();
                }
            });
        }
        function bottom(delay) {
            setTimeout(function () {
                $('#footerPlaceholder').css('height', ($('#footerDiv').height() + 16) + 'px');
                scroll({ top: document.body.clientHeight, left: 0, behavior: 'auto' }); }, delay||0);
        }
        update();
        setInterval(update, 2500);
        $('#publish').click(function (e) {
            // e.preventDefault();
            $('#inputDiv').focus();
            if (!$('#inputDiv').text()) return;
            update($('#inputDiv').text());
            $('#inputDiv').text('');
        });
        $('#logout').click(function () {
            window.location.replace("logout.php");
        });
        function focusOnInputDiv(){
            if(emojiMode){
                emojiMode=false;
                $('#emojiPool').css('height','0');
            }
            bottom(200);
        }
        $('#inputDiv').on('focus', focusOnInputDiv).click(focusOnInputDiv);
        $('#inputDiv').keydown(function (e) {
            if (e.which == 13) {
                // 阻止回车事件，从而阻止换行
                e.preventDefault();
                if (!$('#inputDiv').text()) return;
                update($('#inputDiv').text());
                $('#inputDiv').text('');
            }
        });
        
        $('#inputDiv').on('input', function () {
            let targetHeight = ($('#footerDiv').height() + 16) + 'px';
            if (targetHeight != $('#footerPlaceholder').css('height')) {
                console.log('change');
                $('#footerPlaceholder').css('height', targetHeight);
                scroll({ top: document.body.clientHeight, left: 0, behavior: 'auto' });
            }
        });

        function loadEmoji() {
            $.ajax({
                url: 'getEmoji.php',
                success: function (res) {
                    $('#emojiPool').html(res);
                    $('#footerPlaceholder').css('height', ($('#footerDiv').height() + 16) + 'px');
                }
            });
        }
        loadEmoji();

        $('#uploadEmojiHide').change(function () {
            if ($('#uploadEmojiHide').val() == '') return;
            var formData = new FormData();
            formData.append('file', document.getElementById('uploadEmojiHide').files[0]);
            $.ajax({
                url: "uploadEmoji.php",
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (msg) {
                    let msgs = "sda";
                    if (msg.substr(0, 4) !== '<img') {
                        alert(msg);
                    }
                    else {
                        $('#emojiPool').append(msg);
                        $('#footerPlaceholder').css('height', ($('#footerDiv').height() + 16) + 'px');
                    }
                }
            });
        });

        $('#emojiPool').css('height','0');
        $('#footerPlaceholder').css('height', ($('#footerDiv').height() + 16) + 'px');
        $('#emoji').click(function(){
            if(emojiMode){
                emojiMode=false;
                $('#emojiPool').css('height','0');
                bottom(200);
            }
            else{
                emojiMode=true;
                $('#emojiPool').css('height','fit-content');
                bottom(200);
            }
        });
    </script>
</body>