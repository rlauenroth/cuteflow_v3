<?php

/**
 * WorkflowProcess form base class.
 *
 * @method WorkflowProcess getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'workflow_template_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'workflow_version_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'add_empty' => true)),
      'workflow_slot_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlot'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'workflow_template_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'required' => false)),
      'workflow_version_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'required' => false)),
      'workflow_slot_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlot'), 'required' => false)),
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
