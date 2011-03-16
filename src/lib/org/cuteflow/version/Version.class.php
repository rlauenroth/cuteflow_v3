<?php

class Version {


    public function __construct() {
        
    }

    /**
     *
     * @return String version of CuteFlow
     */
    public static function getVersion() {
        $filepath = sfConfig::get('sf_app_dir') . '/config/version.yml';
        $array = sfYAML::Load($filepath);
        return $array['version'];
    }

}

?>