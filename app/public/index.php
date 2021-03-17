<?php
include("../fileException.php");
define("PICTURE_EXTENSIONS", array('jpg', 'files', 'gif', 'bmp', 'jpeg', 'png'));



function get_parameter($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}

$file_path = get_parameter("file-path");
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
                    <input class="btn__file" type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" required>
                    <p><input class="btn" type="submit" value="Upload" /></p>
                </form>

            </div>
            <!-- ./basic__inner -->
        </div>
        <!-- ./container -->
    </div>

    <?php
    $allFiles = count($_FILES['files']['tmp_name']);
    echo "AAAAAAAAAAAAAAAAA: $allFiles";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    $arrayFiles = array();
    $count = 0;

    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            foreach ($_FILES['files']['name'] as $i => $name) {
                if (
                    strlen($_FILES['files']['name'][$i]) > 1
                ) {

                    echo $_FILES['files']['error'][$i];
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], '../files/' . $name)) {
                        $count++;
                        $arrayFiles[] = '../files/' . $name;
                    }
                } else {
                    throw new UploadException($_FILES['files']['error'][$i]);
                }
            }
    } catch (Exception $e) {
        error_log($e->getMessage(), 3, '../error_log');
    }

    echo "Count: $count";

    echo "<pre>";
    print_r($arrayFiles);
    echo "</pre>";


    // Use

    ?>


</body>

</html>