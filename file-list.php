<?php

$key = ""; // Put any key for the security

//--Histed URL
// https://www.yourdomain.com/
// File List Link: https://www.yourdomain.com/?key=$key&action=listoffiles&dir=[Your Directory Path]
// File Content Link: https://www.yourdomain.com/?key=$key&action=getfile&file=[Your File Path]

if ($_GET['key'] != "") {
    exit();
}

function getAllFiles($dir)
{
    $root = scandir($dir);
    foreach ($root as $value) {
        if ($value === '.' || $value === '..') {
            continue;
        }

        if (is_file("$dir/$value")) {
            $result[] = "$dir/$value";
            continue;
        }

        foreach (getAllFiles("$dir/$value") as $val) {
            $result[] = $val;
        }
    }
    return $result;
}

if ($_GET['action'] == "listoffiles" & $_GET['dir']) {
    $files = getAllFiles($_GET['dir']);
    echo json_encode($files);
}

if ($_GET['action'] == "getfile" && $_GET['file'] && is_file($_GET['file'])) {
    //--Read File
    echo file_get_contents($_GET['file']);
}