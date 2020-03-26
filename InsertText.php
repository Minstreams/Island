<?php
$servername = "111.229.94.88:3306";
$username = "islandOperator";
$password = "559992";
$dbname = "islandDb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

if (array_key_exists('text', $_GET)) {
    $conn->query("insert into message(author,text) value('U','".$_GET['text']."')");
}

$result=$conn->query("SELECT b.name as name,a.text as text,a.time as time from message as a left join user as b on a.author=b.id order by time");
if ($result->num_rows > 0) {
    // 输出数据
    while ($row = $result->fetch_assoc()) {
        echo $row["time"]."-"."[" . $row["name"]. "]: " . $row["text"]. "<br>";
    }
}
$conn->close();
