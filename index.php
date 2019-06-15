
<?php

$dir = 'DropsuiteTest';
$files = scanContentDir($dir);
$result = checkSameContent($files);



echo "<pre>";
print_r($result);



function checkSameContent($files) {
    foreach ($files as $key => $file) {
      
        echo "<pre>";
        print_r(sha1_file($file));
        
    }


}
function scanContentDir($dir, &$results = []) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if (!is_dir($path)) {
            if (filesize($path) >= 0 && $value !== ".DS_Store") {
                $results[] = $path;
            }
        } else if ($value != "." && $value != "..") {
            scanContentDir($path, $results);
        }
    }

    return $results;
}
?>