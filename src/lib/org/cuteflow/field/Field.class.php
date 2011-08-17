<?php
class FieldClass {



    public function  __construct() {
    }


    /**
     * Prepare data for displaxing in grid
     *
     * @param Doctrine_Collection $data, data from database
     * @param sfContext $context
     * @return array $result
     */
    public function buildField(Doctrine_Collection $data, sfContext $context) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['#'] = $a+1;
            $result[$a]['id'] = $item->getId();
            $result[$a]['title'] = $item->getTitle();
            $result[$a]['type'] = $context->getI18N()->__($item->getType(),null,'field');
            $write = $item->getWriteProtected() == 1 ? 'yes' : 'no';
            $result[$a++]['write_protected'] = $context->getI18N()->__($write,null,'field');
        }
        return $result;
    }

    /**
     * prepares data to save it
     * @param array $data, POST data
     * @return array $data, prepared data
     */
    public function prepareSaveData(array $data) {
        $data['createFileWindow_color'] = $data['createFileWindow_color'] == '' ? '#FFFFFF' : $data['createFileWindow_color'];
        $data['createFileWindow_writeprotected'] = isset($data['createFileWindow_writeprotected']) ? $data['createFileWindow_writeprotected'] : 0 ;
        return $data;
    }

    /**
     * Loads data from field table
     *
     * @param Doctrine_Collection $data
     * @return array $result, data
     */
    private function getFieldData(Doctrine_Collection $data) {
        $result = array();
        foreach($data as $item) {
            $result['id'] = $item->getId();
            $result['title'] = $item->getTitle();
            $result['type'] = $item->getType();
            $result['write_protected'] = $item->getWriteProtected();
            $result['color'] = $item->getColor();
        }
        return $result;
    }
    /**
     * Loads data for a textfield
     * 
     * @param Doctrine_Collection $data, to load
     * @return arrayy $result, data
     */
    public function buildTextfield(Doctrine_Collection $data) {
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $textfield = $item->getFieldTextfield();
            $result['regex'] = $textfield[0]->getRegex();
            $result['default_value'] = $textfield[0]->getDefaultValue();
        }
        return $result;
    }

    /**
     * Loads data for a checkbox
     *
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildCheckbox(Doctrine_Collection $data){
        $result = array();
        $result = $this->getFieldData($data);
        return $result;
    }

    /**
     * Load data for number
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildNumber(Doctrine_Collection $data) {
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $number = $item->getFieldNumber();
            $result['default_value'] = $number[0]->getDefaultValue();
            $result['regex'] = $number[0]->getRegex();
            $result['combobox_value'] = $number[0]->getComboboxValue();
        }
        return $result;
    }
    /**
     * Data for Date
     *
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildDate(Doctrine_Collection $data) {
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $date = $item->getFieldDate();
            $result['regex'] = $date[0]->getRegex();
            $result['date_format'] = $date[0]->getDateFormat();
        }
        return $result;
    }

    /**
     * Load data for textarea
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildTextarea(Doctrine_Collection $data) {
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $textarea = $item->getFieldTextarea();
            $result['content'] = $textarea[0]->getContent();
            $result['content_type'] = $textarea[0]->getContentType();
        }
        return $result;
    }

    /**
     * Load data for Radiogroup and grid
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildRadiogroup(Doctrine_Collection $data) {
        $radiogroup = FieldRadiogroupTable::instance()->findRadiogroupByFieldId($data[0]->getId());
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $result['items'] = $this->getItems($radiogroup);
        }
        return $result;
    }

    /**
     * Load data for Checkboxgroup and grid
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildCheckboxgroup(Doctrine_Collection $data) {
        $checkboxgroup = FieldCheckboxgroupTable::instance()->findCheckboxgroupByFieldId($data[0]->getId());
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $result['items'] = $this->getItems($checkboxgroup);
        }
        return $result;
    }

    /**
     * Load data for Combobox and grid
     * @param Doctrine_Collection $data, data to load
     * @return array $result, data
     */
    public function buildCombobox(Doctrine_Collection $data) {
        $checkboxgroup = FieldComboboxTable::instance()->findComboboxByFieldId($data[0]->getId());
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $result['items'] = $this->getItems($checkboxgroup);
        }
        return $result;
    }

    /**
     * Load data for file
     *
     * @param Doctrine_Collection $data, data to load
     * @return array $result,data
     */
    public function buildFile(Doctrine_Collection $data) {
        $result = array();
        $result = $this->getFieldData($data);
        foreach($data as $item) {
            $file = $item->getFieldFile();
            $result['regex'] = $file[0]->getRegex();
        }
        return $result;
    }

    /**
     * Load items for the grids
     *
     * @param Doctrine_Collection $data, items for grid
     * @return array $result, result
     */
    public function getItems(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['id'] = $item->getId();
            $result[$a]['field_id'] = $item->getFieldId();
            $result[$a]['value'] = $item->getValue();
            $result[$a++]['is_active'] = $item->getIsActive();
        }
        return $result;
    }

    /**
     * Saves Radiogroup
     *
     * @param int $id, id of the parent field
     * @param array $data, Post data
     */
    public function saveRadiogroup($id, $data) {
        FieldRadiogroupTable::instance()->setRadiogroupToNullById($id);
        if($data['removeItem'] != '') {
            $delted_fields = explode(',', $data['removeItem']);
            Doctrine::getTable('FieldRadiogroup')->createQuery('frg')->whereIn('frg.id', $delted_fields)->execute()->delete();
        }
        $records = $data['grid'];
        $position = 1;
        foreach($records as $item) {
            $radiogroup = $item['databseId'] == '' ? new FieldRadiogroup() : Doctrine::getTable('FieldRadiogroup')->find($item['databseId']);
            $radiogroup->setValue($item['value']);
            $radiogroup->setIsActive($item['checked']);
            $radiogroup->setFieldId($id);
            $radiogroup->setPosition($position++);
            $radiogroup->save();
        }
    }

    /**
     * Saves Checkboxdata
     * @param int $id, id of the parent field
     * @param array $data, POST data
     */
    public function saveCheckboxgroup($id, $data) {
        FieldCheckboxgroupTable::instance()->setCheckboxgroupToNullById($id);
        if($data['removeItem'] != '') {
            $delted_fields = explode(',', $data['removeItem']);
            Doctrine::getTable('FieldCheckboxgroup')->createQuery('fcbg')->whereIn('fcbg.id', $delted_fields)->execute()->delete();
        }
        $records = $data['grid'];
        $position = 1;
        foreach($records as $item) {
            $checkboxgroup = $item['databseId'] == '' ? new FieldCheckboxgroup() : Doctrine::getTable('FieldCheckboxgroup')->find($item['databseId']);
            $checkboxgroup->setValue($item['value']);
            $checkboxgroup->setIsActive($item['checked']);
            $checkboxgroup->setFieldId($id);
            $checkboxgroup->setPosition($position++);
            $checkboxgroup->save();
        }
    }

    /**
     * Save combobox
     * @param int $id, id of parent field
     * @param array $data, POST data
     */
    public function saveCombobox($id, $data) {
        FieldComboboxTable::instance()->setComboboxToNullById($id);
        if($data['removeItem'] != '') {
            $delted_fields = explode(',', $data['removeItem']);
            Doctrine::getTable('FieldCombobox')->createQuery('fcb')->whereIn('fcb.id', $delted_fields)->execute()->delete();
        }
        $records = $data['grid'];
        $position = 1;
        foreach($records as $item) {
            $combobox = $item['databseId'] == '' ? new FieldCombobox() : Doctrine::getTable('FieldCombobox')->find($item['databseId']);
            $combobox->setValue($item['value']);
            $combobox->setIsActive($item['checked']);
            $combobox->setFieldId($id);
            $combobox->setPosition($position++);
            $combobox->save();
        }
    }


}
?>