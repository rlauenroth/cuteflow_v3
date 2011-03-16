<?php
/**
 * Class builds some kind of tree for the role management
 *
 * @author Manuel Schaefer
 */
class CredentialRolemanagement extends MenueCredential {

        /**
         *
         * @param Doctrine_Collection $data_in, records from database
         */
	public function __construct() {
            sfLoader::loadHelpers('I18N');
            $this->moduleCounter = 0;
            $this->groupCounter = 0;
            $this->rightCounter = 0;
            $this->firstRun = true;
        }

        
        /**
         *
         * Function builds out of the data, a tree to display all tabs, groups and rights
         * to the extjs popwindow
         *
         * @param array $credentials, array is set in editmode
         * 
         * @return array $result, resultset
         */
        public function buildTree(array $credentials = NULL) {
            $result = array();
            $a=1;
            foreach($this->records as $item) {
                $module = '';
                $module = $this->checkModule($result,$item->getUserModule());
                if($module != '') {
                    $result[$this->moduleCounter]['usermodule']['title'] = $module;
                    $result[$this->moduleCounter]['usermodule']['id'] = 'usermodule_' . $module;
                    $result[$this->moduleCounter]['usermodule']['server_id'] = $module;
                    $result[$this->moduleCounter]['usermodule']['usermodule'] = $module;
                    $result[$this->moduleCounter]['usermodule']['translation'] = $this->context->getI18N()->__($module ,null,'credential');
                    $result[$this->moduleCounter]['usermodule']['usergroup'] = '';
                }

                $group = '';
                $group = $this->checkGroup($result[$this->moduleCounter],$item->getUserGroup());
                if($group != ''){
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['title'] = $group;
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['id'] = $result[$this->moduleCounter]['usermodule']['id'] . '_usergroup_' . $group;
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['icon'] = $result[$this->moduleCounter]['usermodule']['id'] . '_usergroupIcon_' . $group;
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['server_id'] = $group;
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['usergroupe'] = $group;
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['translation'] = $this->context->getI18N()->__($group ,null,'credential');
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'] = '';
                }

               
                $right = $item->getUserRight();
                $id = $item->getId();
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['title'] = $right;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['id'] =  $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['id'] . '_userright_' . $right;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['server_id'] = $right;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['userright'] = $right;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['name'] = $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['id'];
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['parent'] = $this->checkParent($right);
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['translation'] = $this->context->getI18N()->__($right ,null,'credential');
                if ($credentials == NULL) {
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['checked'] = 0;
                }
                else {
                    $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter]['checked'] = $this->checkChecked($id, $credentials);
                }
                
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['userright'][$this->rightCounter++]['database_id'] = $id;
                

            }
            $result = $this->sortGroup($result);
            return $result;
        }




}