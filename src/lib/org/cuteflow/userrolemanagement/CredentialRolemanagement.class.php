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
                    $result[$this->moduleCounter]['user_module']['title'] = $module;
                    $result[$this->moduleCounter]['user_module']['id'] = 'user_module_' . $module;
                    $result[$this->moduleCounter]['user_module']['server_id'] = $module;
                    $result[$this->moduleCounter]['user_module']['user_module'] = $module;
                    $result[$this->moduleCounter]['user_module']['translation'] = $this->context->getI18N()->__($module ,null,'credential');
                    $result[$this->moduleCounter]['user_module']['user_group'] = '';
                }

                $group = '';
                $group = $this->checkGroup($result[$this->moduleCounter],$item->getUserGroup());
                if($group != ''){
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['title'] = $group;
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['id'] = $result[$this->moduleCounter]['user_module']['id'] . '_user_group_' . $group;
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['icon'] = $result[$this->moduleCounter]['user_module']['id'] . '_user_groupIcon_' . $group;
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['server_id'] = $group;
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_group'] = $group;
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['translation'] = $this->context->getI18N()->__($group ,null,'credential');
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'] = '';
                }

               
                $right = $item->getUserRight();
                $id = $item->getId();
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['title'] = $right;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['id'] =  $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['id'] . '_user_right_' . $right;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['server_id'] = $right;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['user_right'] = $right;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['name'] = $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['id'];
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['parent'] = $this->checkParent($right);
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['translation'] = $this->context->getI18N()->__($right ,null,'credential');
                if ($credentials == NULL) {
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['checked'] = 0;
                }
                else {
                    $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter]['checked'] = $this->checkChecked($id, $credentials);
                }
                
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_right'][$this->rightCounter++]['database_id'] = $id;
                

            }
            $result = $this->sortGroup($result);
            return $result;
        }




}