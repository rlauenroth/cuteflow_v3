<?php

/**
 * WorkflowSlotFieldCheckboxgroup form base class.
 *
 * @method WorkflowSlotFieldCheckboxgroup getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldCheckboxgroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'workflowslotfield_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'add_empty' => true)),
      'fieldcheckboxgroup_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FieldCheckboxgroup'), 'add_empty' => true)),
      'value'                 => new sfWidgetFormInputText(),
      'position'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowslotfield_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'required' => false)),
      'fieldcheckboxgroup_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FieldCheckboxgroup'), 'required' => false)),
      'value'                 => new sfValidatorInteger(array('required' => false)),
      'position'              => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_checkboxgroup[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldCheckboxgroup';
  }

}
