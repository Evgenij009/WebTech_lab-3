<?php

function get_parameter($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}
