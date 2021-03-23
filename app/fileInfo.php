<?php
include("../fileIcon.php");

use FFI\Exception;


set_error_handler("warning_handler", E_WARNING);

function warning_handler($errno, $errstr)
{
    $message = "";
    switch ($errno) {
        case 2:
            $message = "ERROR: processing some files (no access or not found)! ";
            break;
        case UPLOAD_ERR_INI_SIZE:
            $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            break;
        case UPLOAD_ERR_PARTIAL:
            $message = "The uploaded file was only partially uploaded";
            break;
        case UPLOAD_ERR_NO_FILE:
            $message = "No file was uploaded";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $message = "Missing a temporary folder";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $message = "Failed to write file to disk";
            break;
        case UPLOAD_ERR_EXTENSION:
            $message = "File upload stopped by extension";
            break;
        default:
            $message = "ERROR: processing some files";
            break;
    }
    echo "<div class='error'<h3> $message </h3></div>";
}

function getDirContents($dir, &$results = array())
{
    try {
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
    } catch (Exception $e) {
        echo "<div class='error'<h1> ERROR: $e->getCode()!</h1></div>";
    }

    return $results;
}


function outputPropertiiesFiles($dir, $directory)
{
    $count = 0;
    echo "    <div class=\"tableFiles\">
        <table>
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
    if ($directory[2] === '\\')
        $pos =  strrpos($directory, "\\") + 1;
    else
        $pos =  strrpos($directory, "/") + 1;

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
