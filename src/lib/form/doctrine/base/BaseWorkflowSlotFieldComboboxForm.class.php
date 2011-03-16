<?php

/**
 * WorkflowSlotFieldCombobox form base class.
 *
 * @method WorkflowSlotFieldCombobox getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldComboboxForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'workflowslotfield_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'add_empty' => true)),
      'fieldcombobox_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FieldCombobox'), 'add_empty' => true)),
      'value'                => new sfWidgetFormInputText(),
      'position'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowslotfield_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'required' => false)),
      'fieldcombobox_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FieldCombobox'), 'required' => false)),
      'value'                => new sfValidatorInteger(array('required' => false)),
      'position'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_combobox[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldCombobox';
  }

}
