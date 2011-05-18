<?php

/**
 * WorkflowSlotField filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_slot_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlot'), 'add_empty' => true)),
      'field_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'position'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'workflow_slot_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlot'), 'column' => 'id')),
      'field_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'position'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotField';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'workflow_slot_id' => 'ForeignKey',
      'field_id'         => 'ForeignKey',
      'position'         => 'Number',
    );
  }
}
