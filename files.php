
<?php

Class Files {

    protected $db;
    /**
     * [__construct description]
     *
     * @param   PDO  $db  
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * [main description]
     *
     * @param   [string]  $dir 
     *
     * @return  [string]
     */
    public function main($dir) {
        if (is_dir($dir)) {
            $this->db->query("truncate files");
            $files = $this->scanContentDir($dir);
          
            $insertData = $this->insertDataContent($files);
            $getHighestSameContene = $this->getHighestSameContent();
            return $getHighestSameContene;
        }
        return "Directory Not Found";
    }
    
    protected function getHighestSameContent() {
        // query get highest file same content by sha1_file
        $stmt = $this->db->query("SELECT path, count(sha1_file) as total FROM files group by sha1_file order by count(*) desc LIMIT 1;");
        $data = $stmt->fetch();
        if (!empty($data)) {
            $readContent = file_get_contents($data['path']);
            return $readContent . " " . $data['total']; 
        }
        return "Data not found";
    }
    
    /**
     * [insertDataContent description]
     *
     * @param   [array] $data
     *
     * @return  [string|boolean]
     */
    protected function insertDataContent($data) {
        $values_ = implode(",", $data);
        // insert to db
        $sql = "INSERT INTO files (path, file_name, sha1_file, created_at) VALUES " . $values_ . " ";
        $stmt = $this->db->prepare($sql);
        if (!$stmt->execute()) {
            return "Error insert data";
        }
    }
    
    /**
     * [scanContentDir description]
     *
     * @param   [string] $dir   
     * @param   [array] &$results
     *
     * @return  [array]  
     */
    protected function scanContentDir($dir, &$results = []) {
        // scan dir all directory inside
        $files = scandir($dir);
        $now = time();
        foreach ($files as $key => $value) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (!is_dir($path)) {
                //should be faster hashing file rather can compare content inside file
                if (filesize($path) >= 0 && substr($value, 0, 1) !== ".") {
                    $results[] = "('$path', '$value', '" . sha1_file($path) . "', " . $now .  ")";
                }
            } else if ($value != "." && $value != "..") {
                $this->scanContentDir($path, $results);
            }
        }
        return $results;
    }

}


?>