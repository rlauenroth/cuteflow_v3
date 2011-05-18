<?php

/**
 * WorkflowProcess filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_template_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'workflow_version_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'add_empty' => true)),
      'workflow_slot_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlot'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'workflow_template_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowTemplate'), 'column' => 'id')),
      'workflow_version_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowVersion'), 'column' => 'id')),
      'workflow_slot_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlot'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('workflow_process_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowProcess';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'workflow_template_id' => 'ForeignKey',
      'workflow_version_id'  => 'ForeignKey',
      'workflow_slot_id'     => 'ForeignKey',
    );
  }
}
