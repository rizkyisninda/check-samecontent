<?php
require '../db.php';
require '../files.php';
 
use PHPunit\Framework\TestCase;

class TestFiles extends TestCase
{
    protected $db;

    public function __construct() {
        parent::__construct();
        $connection = new Db();
        $db = $connection->connect();
        $this->db = $db;
    }
     
    public function testDirectoryNotFound() {
        $files = new Files($this->db);
        print $files->main('null');
        $this->expectOutputString('Directory Not Found');
    }

    public function testDefaultContent() {
        $files = new Files($this->db);
        print $files->main('../DropsuiteTest');
        $this->expectOutputString('abcdef 4');
    }

    public function testBiggerNumberSameContent() {
        $files = new Files($this->db);
        print $files->main('testContent1');
        $this->expectOutputString('abcdefghijkl 7');
    }
  
 
}