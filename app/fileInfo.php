<?php
include("../fileIcon.php");

function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}


function outputPropertiiesFiles($dir, $directory)
{
    $count = 0;
    echo "    <div class=\"tableFiles\">
        <table>
        <caption>A summary of the UK's most famous punk bands</caption>
            <thead>
                <tr>
                    <th scope=\"col\">Count</th>
                    <th scope=\"col\">Path</th>
                    <th scope=\"col\">Size</th>
                    <th scope=\"col\">Time of creation</th>
                    <th scope=\"col\">Last change</th>
                    <th scope=\"col\">Last appeal</th>
                    <th scope=\"col\">Icon</th>
                    <th scope=\"col\">Content</th>
                </tr>
            </thead>";
    echo "<tbody>";
    $pos =  strrpos($directory, "\\") + 1;
    // echo "$directory<br>";
    // echo "POS: $pos";
    foreach ($dir as $key => $path) {
        $count++;
        echo "<tr>";
        echo "<td>$count</td>";
        $pathLine = substr($path, $pos, -1);
        echo "<td><p class=\"pathLine\">$pathLine<p></td>";
        infoFile($path);
        echo "</tr>";
    }
    echo "  </tbody>
        </table>
    </div>";
}

function infoFile($f)
{
    if (!file_exists($f)) {
        echo "$f не найден!";
        return;
    }

    // echo "$f - " . (is_file($f) ? "" : "не ") . "файл<br>";
    // echo "$f - " . (is_dir($f) ? "" : "не ") . "каталог<br>";
    echo "<td>" . (round(filesize($f) / 1024 * 100) / 100) . "KB</td>";
    echo "<td>" . (date("d M Y H:i", filectime($f))) . "</td>";
    echo "<td>" . (date("d M Y H:i", filemtime($f))) . "</td>";
    echo "<td>" . (date("d M Y H:i", fileatime($f))) . "<td>";
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
                    echo "<td>$content</td>";
                }
            } else {
                echo "File is not readable!";
            }
        } else {
            echo "<td>-</td>";
        }
    } else {
        echo "<td>-</td>";
    }
}

function get_parameter($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
