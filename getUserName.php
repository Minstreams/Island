<?php
$servername = "localhost:3306";
$username = "islandOperator";
$password = "559992";
$dbname = "islandDb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}
$conn->query("UPDATE boolState set state=1 where id=\"".$_COOKIE["idMark"]."change\"");

$result=$conn->query("SELECT name from user where id=\"".$_COOKIE["idMark"]."\"");
echo $row =$result->fetch_assoc()['name'];

$conn->close();