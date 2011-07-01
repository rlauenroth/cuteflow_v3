<?php

class Installer {


    public function  __construct() {
        require_once sfConfig::get('sf_root_dir') . '/lib/vendor/symfony/helper/I18NHelper.php';   
    }

    /**
     * Create the config file for database
     *
     * @param array $data, database data
     * @return true
     */
    public function createConfigFile(array $data) {
        $all = 'all:' . "\n";
        $doctrine = '  doctrine:' . "\n";
        $class = '    class: sfDoctrineDatabase' . "\n";
        $param = '    param:' . "\n";
        $dsn = '      dsn: '.$data['productive_database'].':host='.$data['productive_host'].';dbname='.$data['productive_databasename'] . "\n";
        $username = '      username: '.$data['productive_username'].'' . "\n";
        $password = '      password: '.$data['productive_password'].'' . "\n";

        $string = $all . $doctrine . $class . $param . $dsn . $username . $password;
        $file = sfConfig::get('sf_root_dir') . '/config/databases.yml';
        $fileHanlder = fopen($file,"w+");
        fwrite($fileHanlder, $string);
        fclose($fileHanlder);

        $file = sfConfig::get('sf_root_dir') . '/config/installed';
        $fileHanlder = fopen($file,"w+");
        fclose($fileHanlder);
        return true;
    }

    /**
     * get the default system language
     *
     * @return string, the language as string e.g. englisch
     */
    public static function getInstallerLanguage() {
        $file = sfConfig::get('sf_app_dir') . '/config/i18n.yml';
        $array = sfYAML::Load($file);
        $ymlCulture = $array['all']['default_culture'];
        $result = array();
        $result = explode('_', $ymlCulture);
        return format_language($result[0]);
    }


    /**
     * get language shortcut, e.g. de en
     *
     * @param String $language, de_DE, en_US
     * @return String en, de
     */
    public static function getLanguage($language) {
        $result = array();
        $result = explode('_', $language);
        return format_language($result[0]);
    }
}
?>