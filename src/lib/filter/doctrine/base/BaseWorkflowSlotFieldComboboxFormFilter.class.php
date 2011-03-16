<?php

/**
 * WorkflowSlotFieldCombobox filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldComboboxFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflowslotfield_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'add_empty' => true)),
      'fieldcombobox_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FieldCombobox'), 'add_empty' => true)),
      'value'                => new sfWidgetFormFilterInput(),
      'position'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'workflowslotfield_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlotField'), 'column' => 'id')),
      'fieldcombobox_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FieldCombobox'), 'column' => 'id')),
      'value'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'                   => 'Number',
      'workflowslotfield_id' => 'ForeignKey',
      'fieldcombobox_id'     => 'ForeignKey',
      'value'                => 'Number',
      'position'             => 'Number',
    );
  }
}
