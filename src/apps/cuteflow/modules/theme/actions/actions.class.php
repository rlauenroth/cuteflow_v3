<?php

/**
 * theme actions.
 *
 * @package    cf
 * @subpackage theme
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class themeActions extends sfActions {


    /**
     * Load all available themes in the system.
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllTheme(sfWebRequest $request) {
        $tm = new ThemeManagement();
        $defaultTheme = UserConfigurationTable::instance()->getUserConfiguration()->toArray();
        $tm->setContext($this->getContext());
        $data = $tm->getThemes();
        $data = $tm->checkDefault($data, $defaultTheme[0]['theme']);
        $this->renderText('({"result":'.json_encode($data).'})');
        return sfView::NONE;
    }

    /**
     * Load the theme a user wants to use
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadUserTheme(sfWebRequest $request) {
        $tm = new ThemeManagement();
        $defaultTheme = UserSettingTable::getInstance()->getUserSettingById($request->getParameter('id'))->toArray();
        $tm->setContext($this->getContext());
        $data = $tm->getThemes();
        $data = $tm->checkDefault($data, $defaultTheme[0]['theme']);
        $this->renderText('({"result":'.json_encode($data).'})');
        return sfView::NONE;
    }

}
