<?php


class Documenttemplate {

    public function  __construct() {
       sfLoader::loadHelpers('Date');
       sfLoader::loadHelpers('i18n');
    }


    /**
     * Load all templates for grid
     * @param array $data, data
     * @return array $data, resultset
     */
    public function buildAllDocumenttemplates(array $data) {
        $result = array();
        $a = 0;
        for($a=0;$a<count($data);$a++) {
            $data[$a]['#'] = $a+1;
        }
        return $data;
    }


    /**
     * Function loads a single documenttemplate by an id with fields, slots
     *
     * @param Doctrine_Collection $data
     * @param int $id, id to laod
     * @param string $type, type can be FIELDS -> load fields to a slot, SLOTONLY -> load nothing
     * @return array $result
     */
    public function buildSingleDocumenttemplates(Doctrine_Collection $data, $id, $type) {
        $item = $data[0];
        $slots = $item->getDocumenttemplateVersion()->toArray();
        $result['documenttemplate_id'] = $item->getId();
        $result['name'] = $item->getName();
        $result['id'] = $slots['id'];
        $result['activeversion_id'] = $id;
        //$result['documenttemplate_id'] = $slots['documenttemplate_id'];
        $result['slots'] = $this->buildSlots($id, $type);
        return $result;
    }

    /**
     * Load all slots for a template
     * @param int $template_id, template id
     * @param string $type, type can be FIELDS -> load fields to a slot, users to a slot, SLOTONLY -> load nothing
     * @return array $result
     */
    public function buildSlots($template_id, $type) {
        $slots = DocumenttemplateSlotTable::instance()->getSlotByDocumentTemplateId($template_id);
        $result = array();
        $a = 0;
        foreach ($slots as $slot) {
            $result[$a]['slot_id'] = $slot->getId();
            $result[$a]['name'] = $slot->getName();
            $result[$a]['receiver'] = $slot->getSendtoallreceivers();
            switch ($type) {
            case 'FIELDS':
                $result[$a]['fields'] = $this->buildFields($slot->getId());
                break;
            case 'SLOTSONLY':
                break;
            }
            $a++;
        }
        return $result;
    }


    /**
     * Load all fields for a slot
     * @param int $slot_id, slot id
     * @return array $result
     */
    public function buildFields($slot_id) {
        
        $result = array();
        $a = 0;
        $fields = DocumenttemplateFieldTable::instance()->getAllFieldsBySlotId($slot_id);
        foreach($fields as $item) {
            $fieldname = $item->getField();
            $result[$a]['id'] = $item->getId();
            $result[$a]['title'] = $fieldname[0]->getTitle();
            $result[$a]['slot_id'] = $item->getDocumenttemplateslotId();
            $result[$a++]['field_id'] = $item->getFieldId();
        }
        return $result;
    }


    /**
     * Creates all Versions for the grid popup
     * @param Doctrine_Collection $data, data
     * @param string $culture, current culture of user
     * @param sfContext, $context
     * @return array $result, data
     */
    public function buildAllVersion(Doctrine_Collection $data, $culture, sfContext $context) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $template = $item->getDocumenttemplateTemplate();
            $result[$a]['#'] = $a+1;
            $result[$a]['id'] = $item->getId();
            $result[$a]['activeversion'] = $item->getActiveversion() == 1 ? '<font color="green">' . $context->getI18N()->__('Yes' ,null,'documenttemplate') . '</font>' : '<font color="red">' . $context->getI18N()->__('No',null,'documenttemplate') . '</font>';
            $result[$a]['created_at'] = format_date($item->getCreatedAt(), 'g', $culture);
            $result[$a]['name'] = $template[0]->getName();
            $result[$a++]['documenttemplate_id'] = $item->getDocumenttemplateId();
        }
        return $result;
    }


    /**
     * Create Slots and Fields for a new record
     *
     * @param array $slots, Slots and fields to store
     * @param int $version_id, id of the version to store
     * @return <type>
     */
    public function storeData(array $slots, $version_id) {
        $fields = array();
        $slotPosition = 1;
        foreach($slots as $slot) {
            $slotTemplate = new DocumenttemplateSlot();
            $slotTemplate->setDocumenttemplateversionId($version_id);
            $slotTemplate->setName($slot['title']);
            $slotTemplate->setSendtoallreceivers($slot['receiver']);
            $slotTemplate->setPosition($slotPosition++);
            $slotTemplate->save();
            $slot_id = $slotTemplate->getId();
            $fields = isset($slot['grid']) ? $slot['grid'] : array();
            $fieldPosition = 1;
            foreach ($fields as $field) {
                $fieldTemplate = new DocumenttemplateField();
                $fieldTemplate->setDocumenttemplateslotId($slot_id);
                $fieldTemplate->setFieldId($field['id']);
                $fieldTemplate->setPosition($fieldPosition++);
                $fieldTemplate->save();
            }
        }

        return true;
    }

    /**
     * Store a version 
     * @param int $template_id, template id
     * @param int $version, the verion to save
     * @return int $version_id, version id
     */
    public function storeVersion($template_id, $version) {
        $versionTemplate = new DocumenttemplateVersion();
        $versionTemplate->setDocumenttemplateId($template_id);
        $versionTemplate->setActiveversion(1);
        $versionTemplate->setVersion($version);
        $versionTemplate->save();
        $version_id = $versionTemplate->getId();
        return $version_id;
    }



}
?>