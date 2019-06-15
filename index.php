
<?php
require 'db.php';
require './files.php';

$connection = new Db();
$db = $connection->connect();
$dir = 'DropsuiteTest';;
$files = new Files($db);
echo $files->main($dir);


?>