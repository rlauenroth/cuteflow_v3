<?php
class BuildIFrameEmail {


    public function __construt() {

    }

    /**
     * Build the HTML Fields for an IFRAME email
     *
     * @param array $field, field data
     * @param int $fieldcounter, unique id of the next field
     * @param String $fileTranslation, contains LINK TO in different languages for file attachments
     * @param boolean $slotIsDisabled, flag if slot is editable or not
     * @return String $theField, contains html String for field
     */
    public function getField(array $field, $fieldcounter, $fileTranslation, $slotIsDisabled) {
        $hiddenField = $this->getHiddenField($field['type'], $fieldcounter);
        $hiddenIdField = '';
        if($slotIsDisabled == 1) {
            $disabled = 'disabled';
        }
        else {
            $disabled = $field['writeprotected'] == 1 ? 'disabled' : '';
        }
        
        $theField = '';
        switch ($field['type']) {
           case 'TEXTFIELD':
               $hiddenIdField = $this->getHiddenIdField($field['items']['id'], $fieldcounter);
               $regExfield = $this->getRegExField($field['items']['id'], $field['items']['regex'], $fieldcounter);
               $fieldName = $this->getFieldName($field['fieldname'], $fieldcounter);
               $theField = '<table><tr><td width="180">'.$regExfield . $fieldName . $field['fieldname'] . ': </td><td><input '.$disabled.' type="text" name="field['.$fieldcounter.'][value]" value="'.$field['items']['value'].'" /></td></tr></table>';
               break;
           case 'CHECKBOX':
               $hiddenIdField = $this->getHiddenIdField($field['items']['id'], $fieldcounter);
               $checked = $field['items']['value'] == 1 ? 'checked=checked' : '';
               $theField = '<table><tr><td width="180">' . $field['fieldname'] . ': </td><td><input '.$disabled.' type="checkbox" name="field['.$fieldcounter.'][value]" value="1" '.$checked.'/></td></tr></table>';
               break;
           case 'NUMBER':
               $hiddenIdField = $this->getHiddenIdField($field['items']['id'], $fieldcounter);
               $regExfield = $this->getRegExField($field['items']['id'], $field['items']['regex'], $fieldcounter);
               $fieldName = $this->getFieldName($field['fieldname'], $fieldcounter);
               $theField = '<table><tr><td width="180">'.$regExfield. $fieldName .$field['fieldname'] . ': </td><td><input '.$disabled.' type="text" name="field['.$fieldcounter.'][value]" value="'.$field['items']['value'].'" /></td></tr></table>';
               break;
           case 'DATE':
               $hiddenIdField = $this->getHiddenIdField($field['items']['id'], $fieldcounter);
               $regExfield = $this->getRegExField($field['items']['id'], $field['items']['regex'], $fieldcounter);
               $fieldName = $this->getFieldName($field['fieldname'], $fieldcounter);
               $theField = '<table><tr><td width="180">'. $regExfield . $fieldName . $field['fieldname'] . ': </td><td><input '.$disabled.' type="text" name="field['.$fieldcounter.'][value]" value="'.$field['items']['value'].'" /></td></tr></table>';
               break;
           case 'TEXTAREA':
               $hiddenIdField = $this->getHiddenIdField($field['items']['id'], $fieldcounter);
               $theField = '<table><tr><td width="180">' . $field['fieldname'] . ': </td><td><textarea '.$disabled.' name="field['.$fieldcounter.'][value]" cols="25" rows="6">'.$field['items']['value'].'</textarea></td></tr></table>';
               break;
           case 'RADIOGROUP':
               $theBox = '';
               $itemCounter = 0;
               $hiddenIdField = $this->getHiddenIdField($field['items'][0]['id'], $fieldcounter);
               foreach($field['items'] as $singleItem) {
                   $checked = $singleItem['value'] == 1 ? 'checked=checked' : '';
                   $theBox .= '<input '.$disabled.' type="radio" name="field['.$fieldcounter.'][id]" value="'.$singleItem['id'] .'" '.$checked.'>' . $singleItem['name'] . '<br />';
                   $itemCounter++;
               }
               $theField = '<table><tr><td width="180">' . $field['fieldname'] . ': </td><td>'.$theBox.'</td></tr></table>';
               break;
           case 'CHECKBOXGROUP':
               $theBox = '';
               $itemCounter = 0;
               $hiddenIdField = $this->getHiddenIdField($field['items'][0]['id'], $fieldcounter);
               foreach($field['items'] as $singleItem) {
                   $checked = $singleItem['value'] == 1 ? 'checked=checked' : '';
                   $theBox .= '<input '.$disabled.' type="checkbox" name="field['.$fieldcounter.'][items]['.$itemCounter.'][id]" value="'.$singleItem['id'].'" '.$checked.'>' . $singleItem['name'] . '<br />';
                   $itemCounter++;
               }
               $theField = '<table><tr><td width="180">' . $field['fieldname'] . ': </td><td>'.$theBox.'</td></tr></table>';
               break;
           case 'COMBOBOX':
               $theBox = '';
               $itemCounter = 0;
               $theBox = '<select name="field['.$fieldcounter.'][id]"  '.$disabled.'>';
               $theBox .= '<option></option>';
               $hiddenIdField = $this->getHiddenIdField($field['items'][0]['id'], $fieldcounter);
               foreach($field['items'] as $singleItem) {
                   $checked = $singleItem['value'] == 1 ? 'selected=selected' : '';
                   $theBox .= '<option '.$disabled.' value="'.$singleItem['id'].'" '.$checked.'>' . $singleItem['name'];
                   $itemCounter++;
               }
               $theBox .= '</select>';
               $theField = '<table><tr><td width="180">' . $field['fieldname'] . ': </td><td>'.$theBox.'</td></tr></table>';
               break;
           case 'FILE':
               $theField = '<table><tr><td width="180">' . $fileTranslation . ': </td><td><a href="'.$field['items']['plainurl'].'">Blubb</a></td></tr></table>';
           break;
        }
        return $theField . $hiddenField . $hiddenIdField;

    }

    /**
     * Build a hidden Field for the Name
     * @param String $name
     * @param int $fieldcounter, unique ID
     * @return $fieldString, html String
     */
    public function getFieldName($name, $fieldcounter) {
        $fieldString = '<input type="hidden" name="field['.$fieldcounter.'][name]" value="'.$name.'" />';
        return $fieldString;
        
    }

    /**
     * Add regex to a field
     *
     * @param int $fieldId
     * @param string $regEx
     * @param int $fieldcounter
     * @return $fieldString, html String
     */
    public function getRegExField($fieldId, $regEx, $fieldcounter) {
        $fieldString = '<input type="hidden" name="field['.$fieldcounter.'][regex]" value="'.$regEx.'" />';
        return $fieldString;
    }
    /**
     * Build a hidden Field for the type of the field
     * @param String $type, fieldtype
     * @param int $fieldcounter, unique ID
     * @return $fieldString, html String
     */
    public function getHiddenField($type, $fieldcounter) {
        $fieldString = '<input type="hidden" name="field['.$fieldcounter.'][type]" value="'.$type.'" />';
        return $fieldString;
    }

    /**
     * Build a hidden Field for the id of the field
     * @param int $id, id of the field
     * @param int $fieldcounter, unique ID
     * @return $fieldString, html String
     */
    public function getHiddenIdField($id, $fieldcounter) {
        $fieldString = '<input type="hidden" name="field['.$fieldcounter.'][field_id]" value="'.$id.'" />';
        return $fieldString;
    }





    




}
?>
