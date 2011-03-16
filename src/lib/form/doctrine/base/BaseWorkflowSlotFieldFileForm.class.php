<?php

/**
 * WorkflowSlotFieldFile form base class.
 *
 * @method WorkflowSlotFieldFile getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldFileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'workflowslotfield_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'add_empty' => true)),
      'filename'             => new sfWidgetFormInputText(),
      'hashname'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowslotfield_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'required' => false)),
      'filename'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'hashname'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_file[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldFile';
  }

}
