<?php
$temp = explode(".", $_FILES["file"]["name"]);
$extension =".".end($temp);     // 获取文件后缀名
$allowdExts=array(".jpg",".jpeg",".gif",".png");
if (!in_array($extension, $allowdExts)) {
    echo "上传错误：不支持 $extension 的文件类型";
} elseif ($_FILES["file"]["error"] > 0) {
    echo "上传错误：".$_FILES["file"]["error"];
} else {
    $index=0;
    if (@$handle = opendir('emoji')) {
        while (($file = readdir($handle)) !== false) {
            if ($file != ".." && $file != ".") {
                $index++;
            }
        }
        closedir($handle);
    }
    $newName="e".$index.$extension;
    while (file_exists("emoji/".$newName)) {
        $index++;
        $newName="e".$index.$extension;
    }
    move_uploaded_file($_FILES["file"]["tmp_name"], "emoji/".$newName);
    echo "<img alt=\"[x]\" src=\""."emoji/".$newName."\" onclick=\"update(undefined,$(this).attr('src'))\"></img>";
}
