<?php

/**
 * WorkflowProcess form base class.
 *
 * @method WorkflowProcess getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'workflowtemplate_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'workflowversion_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'add_empty' => true)),
      'workflowslot_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlot'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowtemplate_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'required' => false)),
      'workflowversion_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'required' => false)),
      'workflowslot_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlot'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_process[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowProcess';
  }

}
