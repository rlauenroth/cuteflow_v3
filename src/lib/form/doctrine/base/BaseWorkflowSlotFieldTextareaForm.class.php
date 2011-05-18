<?php

/**
 * WorkflowSlotFieldTextarea form base class.
 *
 * @method WorkflowSlotFieldTextarea getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldTextareaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'workflow_slot_field_id' => new sfWidgetFormInputText(),
      'value'                  => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'workflow_slot_field_id' => new sfValidatorInteger(array('required' => false)),
      'value'                  => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_textarea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldTextarea';
  }

}
