<?php

/**
 * WorkflowSlotFieldCombobox filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldComboboxFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_slot_field_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'add_empty' => true)),
      'field_combobox_id'      => new sfWidgetFormFilterInput(),
      'value'                  => new sfWidgetFormFilterInput(),
      'position'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'workflow_slot_field_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlotField'), 'column' => 'id')),
      'field_combobox_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'value'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_combobox_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldCombobox';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'workflow_slot_field_id' => 'ForeignKey',
      'field_combobox_id'      => 'Number',
      'value'                  => 'Number',
      'position'               => 'Number',
    );
  }
}
