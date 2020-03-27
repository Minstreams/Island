<?php
// 遍历获取一个文件夹下的所有子文件（夹）
function getSubDir($dir)
{
    $files = [];
    if (@$handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false) {
            if ($file != ".." && $file != ".") {
                $files[] = $file;
            }
        }
        closedir($handle);
    }
    return $files;
}

// 获取所有表情
function getEmoji()
{
    return getSubDir("./emoji");
}

echo "<div id='uploadEmoji' onclick=\"$('#uploadEmojiHide').click()\">+</div>";
$emojies = getEmoji();
$emCnt = count($emojies);
for ($x=0;$x<$emCnt;$x++) {
    if (substr($emojies[$x], mb_strrpos($emojies[$x], '.')+1)!='txt') {
        echo "<img alt=\"[x]\" src=\"emoji/".$emojies[$x]."\" onclick=\"update(undefined,$(this).attr('src'))\"></img>";
    }
}
