<?php


class Mailinglist {

    private $context;

    public function  __construct() {

    }

    public function setContext(sfContext $context) {
        $this->context = $context;
    }


    /**
     *  Builds data for the recevier gird and adds a icon
     *
     * @param Doctrine_Collection $data, data
     * @return array $result
     */
    public function buildReceiver(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['id'] = $item->getUserId();
            $result[$a]['unique_id'] = $a;
            $result[$a]['textwithoutimage'] = $item->getText();
            $result[$a++]['text'] = '<table><tr><td width="18"><img src="/images/icons/user.png" /></td><td>&nbsp;&nbsp;' . $item->getText() . '</td></tr></table>';
        }
        return $result;

    }

    /**
     *
     * @param int $id, template id
     * @return true
     */
    public function createAuthorizationEntry($id) {
        $setting = array('admin','thesender','sender','senderwithrights','receiver');
        foreach($setting as $item) {
            $mailingauth = new MailinglistAuthorizationSetting();
            $mailingauth->setMailinglistVersionId($id);
            $mailingauth->setType($item);
            $mailingauth->setDeleteWorkflow(0);
            $mailingauth->setArchiveWorkflow(0);
            $mailingauth->setStopNewWorkflow(0);
            $mailingauth->setDetailsWorkflow(0);
            $mailingauth->save();
        }
        return true;
    }

    /**
     * Add templatename and Version to resultset
     *
     * @param array $result, resultset
     * @param Doctrine_Collection $data, data
     * @return array $result
     */
    public function addNameToTemplateVersion(array $result, Doctrine_Collection $data) {
        $result['document_template_name'] = $data[0]->getName();
        $result['document_template_id'] = $data[0]->getId();
        return $result;
    }

    /**
     *
     * @param int $id, id of the mailinglist
     * @param array $data, data to activate
     */
    public function saveAuthorization($id, array $data) {
        foreach($data as $singleAuth) {
           $asObj = new MailinglistAuthorizationSetting();
           $asObj->setType($singleAuth['type']);
           $asObj->setMailinglistVersionId($id);
           $asObj->setDeleteWorkflow($singleAuth['delete_workflow']);
           $asObj->setArchiveWorkflow($singleAuth['archive_workflow']);
           $asObj->setStopNewWorkflow($singleAuth['stop_new_workflow']);
           $asObj->setDetailsWorkflow($singleAuth['details_workflow']);
           $asObj->save();
        }

    }

    /**
     *
     * @param int $id, id of the mailinglist
     * @param array $data, user to store
     * @return true
     */
    public function saveUser($id, array $data) {
        $position = 1;
        foreach($data as $item) {
            $mailuser = new MailinglistAllowedSender();
            $mailuser->setMailinglistVersionId($id);
            $mailuser->setUserId($item['id']);
            $mailuser->setPosition($position++);
            $mailuser->save();
        }
        return true;
    }


    /**
     * Creates all records for mailinglist grid
     * @param Doctrine_Collection $data, data
     * @return array $result
     */
    public function buildAllMailinglists(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $documenttemplate = $item->getDocumentTemplate()->toArray();
            $active_version = MailinglistVersionTable::instance()->getActiveVersionById($item->getId())->toArray();
            $result[$a]['#'] = $a+1;
            $result[$a]['id'] = $item->getId();
            $result[$a]['active_version'] = $active_version[0]['id'];
            $result[$a]['is_active'] = $item->getIsActive();
            $result[$a]['name'] = $item->getName();
            $result[$a++]['formtemplate_name'] = $documenttemplate[0]['name'];
        }
        return $result;
    }


    /**
     * Add unique_id to allowedsender for an template
     * @param array $data, data
     * @return array $data, data
     */
    public function buildAllowedSender(array $data) {
        $result = array();
        $a = 0;
        for($a=0;$a<count($data);$a++) {
            $data[$a]['unique_id'] = $a+1;
        }
        return $data;
    }


    /**
     * Function builds a single Mailinglist template, with all slots and users
     * calls build slot function to get all slots
     *
     * @param Doctrine_Collection $data
     * @return array $result, content of mailinglist
     */
    public function buildSingleMailinglist(Doctrine_Collection $data, $id) {
        $result = array();
        $a = 0;

        foreach($data as $item) {
            $documenttemplate = $item->getDocumentTemplate()->toArray();
            $versionData = $item->toArray();
            $result['document_template_id'] = $documenttemplate[0]['id'];
            $result['document_template_name'] = $documenttemplate[0]['name'];
            $result['send_to_all_slots_at_once'] = $versionData['MailinglistVersion']['send_to_all_slots_at_once'];
            $result['id'] = $item->getId();
            $result['name'] = $item->getName();
            $result['slots'] = $this->buildSlot($id);
        }
        return $result;

    }

    /**
     * Function adds slots to a mailinglist
     *
     * @param Doctrine_Collection $slots, slots to a correspondending mailinglist
     * @return array $result
     */
    private function buildSlot($mailinglist_id) {
        $result = array();
        $a = 0;
        $slots = MailinglistSlotTable::instance()->getSlotsByVersionId($mailinglist_id);
        foreach($slots as $slot) {
            $slotname = $slot->getDocumentTemplateSlot()->toArray();
            $result[$a]['slot_id'] = $slotname[0]['id'];
            $result[$a]['name'] = $slotname[0]['name'];
            $result[$a++]['users'] = $this->buildUser($slot->getId());
        }
        return $result;
    }

    /**
     * Function adds all users to a slot
     *
     * @param int $id, Slot id, to get all users
     * @return array $result, users for the slot
     */
    private function buildUser($id) {
        $result = array();
        $a = 0;
        $data = MailinglistUserTable::instance()->getAllUserBySlotId($id);
        foreach($data as $user) {
            $result[$a]['id'] = $user->getId();
            $result[$a]['user_id'] = $user->getUserId();
            $result[$a++]['name'] = $user->getUserId() == -2 ? $this->context->getI18N()->__('Sender of circulation' ,null,'mailinglist') : $user->getName();
        }
        return $result;
    }


    /**
     * Build all Version for undo operation for an template
     * @param Doctrine_Collection $data, data
     * @param String $culture, culture of the user
     * @param sfContext $context
     * @return array $result
     */
    public function buildAllVersion(Doctrine_Collection $data, $culture) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $template = $item->getMailinglistTemplate();
            $result[$a]['#'] = $a+1;
            $result[$a]['id'] = $item->getId();
            $result[$a]['active_version'] = $item->getActiveVersion() == 1 ? '<font color="green">' . $this->context->getI18N()->__('Yes' ,null,'documenttemplate') . '</font>' : '<font color="red">' . $this->context->getI18N()->__('No',null,'documenttemplate') . '</font>';
            $result[$a]['created_at'] = format_date($item->getCreatedAt(), 'g', $culture);
            $result[$a]['name'] = $template[0]->getName();
            $result[$a++]['mailinglist_template_id'] = $item->getMailinglistTemplateId();
        }
        return $result;
    }


    /**
     * Save a new Version of an record
     *
     * @param int $mailinglist_template_id, id of the template
     * @param int $version, current version to save
     * @param int $activeMailinglistId, current id of the active version
     * @return int $mailinglist_version_id, version id
     */
    public function storeVersion($mailinglist_template_id, $version, $activeMailinglistId, $sendToAll) {
        $mailinglistversion = new MailinglistVersion();
        $mailinglistversion->setMailinglistTemplateId($mailinglist_template_id);
        $mailinglistversion->setVersion($version);
        $mailinglistversion->setDocumentTemplateVersionId($activeMailinglistId);
        $mailinglistversion->setSendToAllSlotsAtOnce($sendToAll);
        $mailinglistversion->setActiveVersion(1);
        $mailinglistversion->save();
        $mailinglist_version_id = $mailinglistversion->getId();
        return $mailinglist_version_id;
    }

    /**
     * Save Slots and Users to database
     *
     * @param array $slots, array with slots and users
     * @param int mailinglist_version_id, mailinglistversion id
     * @return true;
     */
    public function storeMailinglist(array $slots,$mailinglist_version_id) {
        $slotposition = 1;
        foreach ($slots as $slot) {
            $mailinglistslot = new MailinglistSlot();
            $mailinglistslot->setMailinglistVersionId($mailinglist_version_id);
            $mailinglistslot->setSlotId($slot['slot_id']);
            $mailinglistslot->setPosition($slotposition++);
            $mailinglistslot->save();
            $mailinglist_slot_id = $mailinglistslot->getId();
            $records = isset($slot['grid']) ? $slot['grid'] : array();
            $userposition = 1;
            foreach($records as $row) {
                $mailinglistuser = new MailinglistUser();
                $mailinglistuser->setMailinglistSlotId($mailinglist_slot_id);
                $mailinglistuser->setUserId($row['id']);
                $mailinglistuser->setPosition($userposition++);
                $mailinglistuser->save();
            }
        }
        return true;
    }


    /**
     * Build array for to store allowed sender
     *
     * @param Doctrine_Collection $data
     * @return array $result
     */
    public function buildAllowedUser(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a++]['id'] = $item->getUserId();
        }
        return $result;
    }



    /**
     *
     * Adapt the Auth settings of active entry
     *
     * @param array $data, data to store
     * @param int $mailinglist_version_id, version id
     * @return true
     */
    public function adaptAuthorizationEntry(array $data, $mailinglist_version_id) {
        foreach($data as $item) {
            $auth = new MailinglistAuthorizationSetting();
            $auth->setMailinglistVersionId($mailinglist_version_id);
            $auth->setType($item['type']);
            $auth->setDeleteWorkflow($item['delete_workflow']);
            $auth->setArchiveWorkflow($item['archive_workflow']);
            $auth->setStopNewWorkflow($item['stop_new_workflow']);
            $auth->setDetailsWorkflow($item['details_workflow']);
            $auth->save();
        }
        return true;
    }


}

?>