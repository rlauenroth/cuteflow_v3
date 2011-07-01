<?php



class File {


    public function  __construct() {

    }

    /**
     *
     * @param String $filepath, path to file
     * @return $fc, filecontent
     */
    public function getFileContent($filepath) {
        $fc = @file_get_contents($filepath);
        return $fc;
    }


    /**
     * Get contenttype of the file
     *
     * @param String $file, filename
     */
    public function getContentType($file) {
        $data = array();
        $data = explode('.', $file);
        $type =  strtolower($data[count($data)-1]);

    }

    
}
?>