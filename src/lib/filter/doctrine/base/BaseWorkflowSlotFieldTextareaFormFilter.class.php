<?php

/**
 * WorkflowSlotFieldTextarea filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldTextareaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_slot_field_id' => new sfWidgetFormFilterInput(),
      'value'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'workflow_slot_field_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'value'                  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_textarea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldTextarea';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'workflow_slot_field_id' => 'Number',
      'value'                  => 'Text',
    );
  }
}
