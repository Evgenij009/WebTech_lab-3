<?php

function displayFileIcon($f)
{
    switch (get_file_extension($f)) {
        case 'pdf':
            $img = "images/pdf.webp";
            break;
        case 'doc':
            $img = "images/doc.png";
            break;
        case 'docx':
            $img = "images/doc.png";
            break;
        case 'txt':
            $img = "images/txt.webp";
            break;
        case 'xls':
            $img = "images/xls.png";
            break;
        case 'xlsx':
            $img = "images/xls.png";
            break;
        case 'xlsm':
            $img = "images/xls.png";
            break;
        case 'ppt':
            $img = "images/ppt.webp";
            break;
        case 'pptx':
            $img = "images/ppt.webp";
            break;
        case 'mp3':
            $img = "mp3.webp";
            break;
        case 'css':
            $img = "images/css.png";
            break;
        case 'mp4':
            $img = "images/mp4.webp";
            break;
        case 'js':
            $img = "images/js.png";
            break;
        case 'html':
            $img = "images/html.webp";
            break;
        case 'rar':
            $img = "images/rar.webp";
            break;
        case 'xml':
            $img = "images/xml.webp";
            break;
        case 'jpg':
            $img = "images/jpg.png";
            break;
        case 'png':
            $img = "images/png.png";
            break;
        case 'svg':
            $img = "images/svg.png";
            break;
        case 'php':
            $img = "images/php.png";
            break;
        case 'folder':
            $img = "images/folder.webp";
            break;
        default:
            $img = "images/file.webp";
            break;
    }

    echo "<img src=\"$img\" title=\"Title of image\" width=\"128px\" height=\"auto\" alt=\"alt text here\" />";
}

function get_file_extension($f)
{
    $ftype = pathinfo($f);
    // echo "<h1><pre>";
    // echo print_r($ftype);
    // echo "</pre></h1>";
    $extension = "";
    if (array_key_exists('extension', $ftype)) {
        $extension = $ftype['extension'];
    } else {
        $extension = 'folder';
    }
    return $extension;
}
