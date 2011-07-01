<?php



class Workflow {

    private $context;

    public function  __construct() {
    }

    public function setContext(sfContext $context_in) {
        $this->context = $context_in;
    }

    /**
     *
     * Load Slots and Fields for a template
     *
     * @param array $data
     * @return array $result
     */
    public function buildSlots(array $data) {
        $slots = DocumentTemplateSlotTable::instance()->getSlotByDocumentTemplateId($data[0]['id']);
        $result = array();
        $a = 0;
        $columns = 0;
        $colCounter = 0;
        foreach ($slots as $item) {
            $result[$a]['slot_id'] = $item->getId();
            $result[$a]['slot_name'] = $item->getName();
            $result[$a++]['fields'] = $this->buildFields($item->getId());
            
        }
        return $result;
    }


    /**
     * Add all fields to a slot. The Fields contain also LEFT and RIGHT to set them to the right column
     * in the overview
     *
     * @param int $slot_id, id of the slot
     * @return array $result, Slotdata
     */
    public function buildFields($slot_id) {
        $fields = DocumenttemplateFieldTable::instance()->getAllFieldsBySlotId($slot_id);
        $result = array();
        $a = 0;
        $assign = 'LEFT';
        $colCounter = 1;
        foreach($fields as $field) {
            $fieldItem = $field->getField()->toArray();
            $result[$a]['id'] = $field->getId();
            $result[$a]['field_name'] = $fieldItem[0]['title'];
            $result[$a]['type'] = $fieldItem[0]['type'];
            $result[$a]['write_protected'] = $fieldItem[0]['write_protected'];
            $result[$a]['color'] = $fieldItem[0]['color'];
            $result[$a]['field_id'] = $fieldItem[0]['id'];
            $result[$a]['assign'] = $assign;
            $result[$a++]['items'] = $this->buildItems($fieldItem[0]['id'], $fieldItem[0]['type']);
            if($colCounter == 0) {
                $colCounter = 1;
                $assign = 'LEFT';
            }
            else {
                $colCounter = 0;
                $assign = 'RIGHT';
            }

        }
        return $result;
    }

    /**
     * Load the values for fields
     *
     * @param int $field_id, field id
     * @param String $type, typ des feldes
     * @return array $result
     */
    public function buildItems($field_id, $type) {
        $result = array();
        switch ($type) {
            case 'TEXTFIELD':
                $result = $this->getTextfield($field_id);
                break;
            case 'CHECKBOX':
                $result = $this->getCheckbox($field_id);
                break;
            case 'NUMBER':
                $result = $this->getNumber($field_id);
                break;
            case 'DATE':
                $result = $this->getDate($field_id);
                break;
            case 'TEXTAREA':
                $result = $this->getTextarea($field_id);
                break;
            case 'RADIOGROUP':
                $result = $this->getRadiogroup($field_id);
                break;
            case 'CHECKBOXGROUP':
                $result = $this->getCheckboxgroup($field_id);
                break;
            case 'COMBOBOX':
                $result = $this->getCombobox($field_id);
                break;
            case 'FILE':
                $result = $this->getFile($field_id);
                break;
        }
        return $result;
    }


    public function getTextfield($field_id) {
        $result = array();
        $result = FieldTextfieldTable::instance()->getTextfieldByFieldId($field_id)->toArray();
        return $result[0];
    }


    public function getCheckbox($field_id) {
        $result = array();
        return $result;
    }

    public function getNumber($field_id) {
        $result = array();
        $result = FieldNumberTable::instance()->getNumberByFieldId($field_id)->toArray();
        if($result[0]['combobox_value'] != 'EMPTY') {
            $result[0]['comboboxtext'] = $this->context->getI18N()->__($result[0]['combobox_value'] ,null,'field');
        }
        else {
            $result[0]['combobox_value'] = $result[0]['regex'];
        }
        return $result[0];
    }



    public function getDate($field_id) {
        $result = array();
        $result = FieldDateTable::instance()->getDateByFieldId($field_id)->toArray();
        return $result[0];
    }


    public function getTextarea($field_id) {
        $result = array();
        $result = FieldTextareaTable::instance()->getTextareaByFieldId($field_id)->toArray();
        return $result[0];
        
    }

    public function getRadiogroup($field_id) {
        $result = array();
        $result = FieldRadiogroupTable::instance()->findRadiogroupByFieldId($field_id)->toArray();
        return $result;
    }

    public function getCheckboxgroup($field_id) {
        $result = array();
        $result = FieldCheckboxgroupTable::instance()->findCheckboxgroupByFieldId($field_id)->toArray();
        return $result;
    }


    public function getCombobox($field_id) {
        $result = array();
        $result = FieldComboboxTable::instance()->findComboboxByFieldId($field_id)->toArray();
        return $result;
    }



    public function getFile($field_id) {
        $result = array();
        $result = FieldFileTable::instance()->findFileByFieldId($field_id)->toArray();
        return $result[0];
    }




}
?>