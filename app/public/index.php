<?php
include("../fileInfo.php");

define("PICTURE_EXTENSIONS", array('jpg', 'files', 'gif', 'bmp', 'jpeg', 'png'));


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
                    <input class="btn" type="submit" value="look" />
                </form>

            </div>
            <!-- ./basic__inner -->
        </div>
        <!-- ./container -->
    </div>

    <?php
    $directory = $file_path;
    $is_submit = $_SERVER['REQUEST_METHOD'] === 'POST';
    if ($is_submit) {
        if (ctype_alpha(substr($file_path, 0, 1))) {
            if (is_dir($file_path) || file_exists($file_path)) {
                $arrayPaths =  getDirContents($directory);
                outputPropertiiesFiles($arrayPaths, $directory);
            } else {
                echo "<div class='error'<h1>Каталога/файла= " . $file_path . " нет на диске!</h1></div>";
            }
        } else {
            echo "<div class='error'<h1>Путь должен быть абсолютным!!!</h1></div>";
        }
    }

    ?>

</body>

</html>