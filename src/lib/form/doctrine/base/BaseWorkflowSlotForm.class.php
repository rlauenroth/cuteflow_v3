<?php

/**
 * WorkflowSlot form base class.
 *
 * @method WorkflowSlot getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'workflowversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'add_empty' => true)),
      'slot_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'add_empty' => true)),
      'position'           => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowversion_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'required' => false)),
      'slot_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'required' => false)),
      'position'           => new sfValidatorInteger(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlot';
  }

}
