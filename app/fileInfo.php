<?php
include("../fileIcon.php");


function infoFile($f)
{
    if (!file_exists($f)) {
        echo "$f не найден!";
        return;
    }

    // echo "$f - " . (is_file($f) ? "" : "не ") . "файл<br>";
    // echo "$f - " . (is_dir($f) ? "" : "не ") . "каталог<br>";
    echo "Size: " . (round(filesize($f) / 1024 * 100) / 100) . "KB<br>";
    echo "Time of creation: " . (date("d M Y H:i", filectime($f))) . "<br>";
    echo "Last change: " . (date("d M Y H:i", filemtime($f))) . "<br>";
    echo "last appeal: " . (date("d M Y H:i", fileatime($f))) . "<br>";
    displayFileIcon($f);
    $ftype = pathinfo($f);
    $extension = "";
    $handle = null;

    if (array_key_exists('extension', $ftype)) {
        if (($extension = $ftype['extension']) === 'txt') {
            if (is_readable($f)) {
                if (($handle = fopen($f, "r")) === FALSE) {
                    echo "Failed to open file!";
                } else {
                    $content = fread($handle, 100);
                    echo "<br>Content: $content";
                }
            } else {
                echo "File is not readable!";
            }
        }
    }
    echo "<br>";
}



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
