<?php

/**
 * installer actions.
 *
 * @package    cf
 * @subpackage installer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class installerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request) {
        return sfView::SUCCESS;
    }


    /**
     * check if the current database settings are correct and can be used to install CF
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeCheckConnection(sfWebRequest $request) {
        $data = $request->getPostParameters();

        $dsn = $data['productive_database'] . ':dbname='.$data['productive_databasename'].';host='.$data['productive_host'];
        $user = $data['productive_username'];
        $password = $data['productive_password'];
        
        try {
            $dbh = new PDO($dsn, $user, $password);
            $conn = Doctrine_Manager::connection($dbh);
            $this->renderText('{success:true}');
        }
        catch(Exception $e) {
            $this->renderText('{success:false}');
        }
        return sfView::NONE;
    }


    /**
     * Change the culture of the user
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeChangeLanguage(sfWebRequest $request) {
        $this->getUser()->setCulture($request->getParameter('value'));
        return sfView::NONE;
    }


    /**
     * check if cuteflow is already installed or not
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeCheckLogin(sfWebRequest $request) {
        $loginObj = new Login();
        if ($loginObj->checkInstaller() == false) {
            $this->redirect('installer/index');
        }
        else {
            $this->redirect('login/index');
        }
        return sfView::NONE;
    }

    /**
     * Create the config file with the database settings and write email settings
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveData(sfWebRequest $request) {
        $sysObj = new SystemSetting();
        $installer = new Installer();
        $data = $request->getPostParameters();
        $installer->createConfigFile($data); // write settings in database.yml
        // create DB
        $task = new sfDoctrineBuildAllReLoadTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
        chdir(sfConfig::get('sf_root_dir'));
        $task->run(array(),array('--no-confirmation', '--env=all', '--dir='.sfConfig::get('sf_root_dir').'/data/fixtures/'.$data['productive_data'].''));
        $data = $sysObj->buildEmailSetting($data);
        UserLoginTable::instance()->updateEmail($data['productive_emailadresse']);
        EmailConfigurationTable::instance()->updateEmailConfiguration($data);
        // clear cache
        $taskCC = new sfCacheClearTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
        $taskCC->run(array(), array());
        // create JS Cache
        $ccCache = new TemplateCaching();
        $ccCache->checkCacheDir();
        $ccCache->setFiles();
        $lastModified = $ccCache->getLastModifiedFile();
        $cacheCreated = $ccCache->getCurrentCacheStamp();

        if($lastModified > $cacheCreated OR $cacheCreated == '') {
            if($cacheCreated == '') {
                $cacheCreated = $lastModified;
            }
            $ccCache->createCache($lastModified, $cacheCreated);
        }
        // return success, then JS redirect
        $this->renderText('{success:true}');
        return sfView::NONE;
    }
}
