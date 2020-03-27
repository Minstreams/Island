<?php
if (isset($_GET['login'])) {
    header("Location:main.php");
} elseif (isset($_GET['password'])) {
    $password=$_GET['password'];
    if ($password=='559992') {
        //xiaoyu
        setcookie("idMark", 'U', time()+60*60*24);
        header("Location:main.php");
    } elseif ($password==='559992A') {
        //yao
        setcookie("idMark", 'A', time()+60*60*24);
        header("Location:main.php");
    } else {
        echo '<h1>(ノへ￣、)</h1>';
    }
} else {
    echo '<h1>(ノへ￣、)</h1>';
}
