<?php
if(!array_key_exists('password',$_GET))die();
$password=$_GET['password'];
if ($password=='559992') {
    echo true;
} else {
    echo false;
}
?>