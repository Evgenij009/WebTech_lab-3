<?php
include("../fileException.php");
include("../fileInfo.php");

define("PICTURE_EXTENSIONS", array('jpg', 'files', 'gif', 'bmp', 'jpeg', 'png'));

function get_parameter($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}

$file_path = get_parameter("dir");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <title>lab-3</title>

</head>

<body>

    <header>Полный список файлов и подкатологов</header>

    <!--Basic-->
    <div class="basic">
        <div class="container">
            <div class="basic__inner">

                <form action="index.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="dir" id="" required>
                    <p><input class="btn" type="submit" value="look" /></p>
                </form>

            </div>
            <!-- ./basic__inner -->
        </div>
        <!-- ./container -->
    </div>



    <?php
    $directory = $file_path;

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


    function outputPropertiiesFiles($dir)
    {
        $count = 0;
        foreach ($dir as $key => $path) {

            $count++;
            echo "$count) Path: $path<br>";
            infoFile($path);
            echo "----------------------------------------------------------------------<br>";
        }
    }

    $arrayPaths =  getDirContents($directory);
    outputPropertiiesFiles($arrayPaths);
    ?>

</body>

</html>