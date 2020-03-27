<?php
$servername = "localhost:3306";
$username = "islandOperator";
$password = "559992";
$dbname = "islandDb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

$other = $_COOKIE["idMark"]=='U'?'A':'U';
$otherChange = false;
$change=$conn->query("SELECT state from boolState where id=\"".$_COOKIE["idMark"]."change\"")->fetch_assoc()['state'];


//输入数据
if (isset($_GET['img'])) {
    $conn->query("insert into message(author,img) value('".$_COOKIE["idMark"]."',\"".$_GET['img']."\")");
    $otherChange = true;
}
if (isset($_GET['text'])) {
    $conn->query("insert into message(author,text) value('".$_COOKIE["idMark"]."',\"".preg_replace('/\"/', '\\"', $_GET['text'])."\")");
    $otherChange = true;
}
//已读状态
$result=$conn->query("SELECT isread from message where isread=0 and author=\"".$other."\"");
if ($result->num_rows > 0) {
    $conn->query("UPDATE message set isread=1 where isread=0 and author=\"".$other."\"");
    $otherChange = true;
}

//统一更新数据
if ($otherChange) {
    //记录change
    $conn->query("UPDATE boolState set state=1 where id=\"".$other."change\"");
}
if ($change || $otherChange) {
    $result=$conn->query("SELECT a.author as author,b.avater as avater,a.text as text,a.img as img,a.time as time,a.isread as isread from message as a left join user as b on a.author=b.id order by time");
    $ttime='';
    if ($result->num_rows > 0) {
        // 输出数据
        while ($row = $result->fetch_assoc()) {
            $newtime= substr($row["time"], 0, 15);
            if ($ttime!=$newtime) {
                $ttime=$newtime;
                echo "<timestamp>-".$row["time"]."-</timestamp>";
            }
            $outerBox = $row["author"]==$_COOKIE["idMark"]?"chat":"otherChat";
            echo
            "<$outerBox><author><img src=\"" . $row["avater"]. "\"></img></author><messageBox>".
            ($row["text"]?"<message>" . $row["text"]."</message>":"").
            ($row["img"]?"<img src=\"" . $row["img"]."\"></img>":"").
            "</messageBox><isread>".($row["isread"]?'':"  [未读]")."</isread>".
            "</$outerBox>";
        }
    }
    $conn->query("UPDATE boolState set state=0 where id=\"".$_COOKIE["idMark"]."change\"");
} else {
    echo false;
}

$conn->close();
