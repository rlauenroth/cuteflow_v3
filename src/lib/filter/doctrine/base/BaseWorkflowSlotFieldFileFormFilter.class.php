<?php

/**
 * WorkflowSlotFieldFile filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowSlotFieldFileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflowslotfield_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotField'), 'add_empty' => true)),
      'filename'             => new sfWidgetFormFilterInput(),
      'hashname'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'workflowslotfield_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlotField'), 'column' => 'id')),
      'filename'             => new sfValidatorPass(array('required' => false)),
      'hashname'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workflow_slot_field_file_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowSlotFieldFile';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'workflowslotfield_id' => 'ForeignKey',
      'filename'             => 'Text',
      'hashname'             => 'Text',
    );
  }
}
