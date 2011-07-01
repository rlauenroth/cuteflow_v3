<?php

class ThemeManagement {

    private $context;
    
    public function setContext(sfContext $context_in) {
        $this->context = $context_in;
    }


    public function  __construct() {
    }


    /**
     *
     * get all themes and translate them
     *
     * @return array $result
     */
    public function getThemes() {
        $themeDir =  sfConfig::get('sf_web_dir') . '/themes';
        $result = array();
        $a = 1;
        $dir = array_diff(scandir($themeDir), Array( ".", "..",".svn"));
        $result[0]['plain'] = 'DEFAULT';
        $result[0]['translation'] =  $this->context->getI18N()->__('DEFAULT' ,null,'theme');
        foreach($dir AS $item) {
            $result[$a]['plain'] = $item;
            $result[$a++]['translation'] =  $this->context->getI18N()->__($item ,null,'theme');
        }
        return $result;
    }

    /**
     * Check which theme is default
     *
     * @param array $data
     * @param string $theme
     * @return <type>
     */
    public function checkDefault(array $data, $theme) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a] = $item;
            if($item['plain'] == $theme) {
                $result[$a]['isDefault'] = 1;
            }
            else {
                $result[$a]['isDefault'] = 0;
            }
            $a++;

        }
        return $result;
    }

    /**
     * get the path to the theme
     *
     * @param string $theme
     * @return string '' if blue theme, themepath if other
     */
    public function getThemePath($theme) {
        if($theme == 'DEFAULT') {
            return '';
        }
        else {
           return sfConfig::get('sf_web_dir') . '/themes/' . $theme;
        }

    }

}


?>