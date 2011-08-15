<?php

class TemplateCaching {

    public $files;

    /**
     * Set the JS Files
     * TODO rela: überflüssig?
     */
    public function setFiles() {
        $files = new JavaScriptLoader();
        $files->addNameSpaceFiles();
        $this->files = $files->getAllFiles();
    }

    /**
     * Check if cache dir is exisitign, if not create it
     */
    public function checkCacheDir() {
        if(is_dir(sfConfig::get('sf_cache_dir')) == true) {
            if(is_dir(sfConfig::get('sf_cache_dir') . '/javaScriptCache') == false )  {
                mkdir(sfConfig::get('sf_cache_dir') . '/javaScriptCache');
            }
        }
        else {
            mkdir(sfConfig::get('sf_cache_dir'));
        }
    }

    /**
     * Return the last modified file
     *
     * @return string $lastModified, last modified file
     * TODO rela: rename (getLastModifiedIrgendwas)
     */
    public function getLastModifiedFile() {
        $loader = new JavaScriptLoader();
        $loader->addNameSpaceFiles();
        $files = $loader->getAllFiles();
        $mod = array();
        foreach($files as $file) {
            $mod[] =  filemtime($file);
        }
        asort($mod);
        return end($mod);
    }

    /**
     *
     * @return String, '' if no file is cached, return timestamp of the latest cache
     * 
     */
    public function getCurrentCacheStamp() {
        $dir = array_diff(scandir(sfConfig::get('sf_cache_dir') . '/javaScriptCache'), Array());
        if(!empty($dir)) {
            $lastIndex =  $dir[count($dir)-1];
        }
        else {
            return '';
        }
        if(substr_count($lastIndex, 'Success.php') == 1) {
            return str_replace('Success.php', '', $lastIndex);
        }
        return '';
    }

    /**
     *
     * @param String $lastModified, last modified file in timestampe
     * @param String acheStamp, created cache as timestamp
     * TODO rela: loader einbauen
     * @return true
     */
    public function createCache($lastModified, $cacheStamp) {
        @unlink (sfConfig::get('sf_cache_dir') . '/javaScriptCache/' . $cacheStamp); // delete old cache
        $js = '';
        foreach($this->files as $file) { // open all files and add content to a string
            $jsMin = JSMin::minify(file_get_contents($file));
            $js .= $jsMin;
        }
        $dir = sfConfig::get('sf_cache_dir') . '/javaScriptCache/'; // write file
        file_put_contents($dir . $lastModified .'Success.php',$js); // set js cache filename to lastModified filename
        return true;
    }
}

    
