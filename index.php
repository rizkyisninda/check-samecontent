
<?php

$dir = 'DropsuiteTest';
$file = scanContentDir($dir);

echo "<pre>";
print_r($file);



function scanContentDir($dir, &$results = []) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if (!is_dir($path)) {
            if (filesize($path) >= 0 && $value !== ".DS_Store") {
                
                echo "<pre>";
                print_r(strlen(file_get_contents($path)));
                $results[] = $path;
            }
        } else if($value != "." && $value != "..") {
            scanContentDir($path, $results);
        }
    }

    return $results;
}
?>