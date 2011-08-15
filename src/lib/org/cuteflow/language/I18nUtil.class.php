<?php

/**
 * Class that handles the language operation
 *
 * @author Manuel Schaefer
 */
class I18nUtil
{

    public function __construct()
    {
        require_once sfConfig::get('sf_root_dir') . '/lib/vendor/symfony/helper/I18NHelper.php';
    }


    /**
     * Function extracts all language files from app Dir.
     *
     * @param array $languages
     * @return array $result
     */
    public function extractLanguages(array $languages)
    {
        
        $lang_text = array(
            'de'=>'Deutsch',
            'en'=>'Englisch',
        );
        
        $dir = array_diff(scandir(sfConfig::get('sf_app_i18n_dir')), Array(".", "..", ".svn"));
        $results = array();
        foreach ($dir AS $item) {
            list($lang_code) = explode('_', $item);
            $result = array();
            $result['value']=$item;
            $result['text']= $lang_text[$lang_code];
            $results[] = $result;
        }            
       
        return $results;        
    }

   

    /**
     *
     * Function that returns the defualt language
     *
     * @param String $language, e.g. en_US, de_DE
     * @return String, formated in correct language, e.g. English, German
     */
    public static function buildDefaultLanguage($language)
    {
        $result = explode('_', $language);
        return format_language($result[0]);
    }


    /**
     * Function loads all translations for the textfields and combobox
     *
     * @param user $conext
     * @return array $result
     */
    public function loadAjaxLanguage(sfContext $context)
    {
        $result = array();
        $result['login'] = $context->getI18N()->__('Login', null, 'login');
        $result['username'] = $context->getI18N()->__('Username', null, 'login');
        $result['password'] = $context->getI18N()->__('Password', null, 'login');
        $result['language'] = $context->getI18N()->__('Language', null, 'login');
        $result['close'] = $context->getI18N()->__('Close', null, 'login');
        return $result;
    }


}
