<?php

/**
 * WorkflowVersion filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_template_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'additional_text_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdditionalText'), 'add_empty' => true)),
      'active_version'       => new sfWidgetFormFilterInput(),
      'version'              => new sfWidgetFormFilterInput(),
      'end_reason'           => new sfWidgetFormFilterInput(),
      'content'              => new sfWidgetFormFilterInput(),
      'content_type'         => new sfWidgetFormFilterInput(),
      'start_workflow_at'    => new sfWidgetFormFilterInput(),
      'workflow_is_started'  => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'workflow_template_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowTemplate'), 'column' => 'id')),
      'additional_text_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AdditionalText'), 'column' => 'id')),
      'active_version'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'version'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'end_reason'           => new sfValidatorPass(array('required' => false)),
      'content'              => new sfValidatorPass(array('required' => false)),
      'content_type'         => new sfValidatorPass(array('required' => false)),
      'start_workflow_at'    => new sfValidatorPass(array('required' => false)),
      'workflow_is_started'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('workflow_version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowVersion';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'workflow_template_id' => 'ForeignKey',
      'additional_text_id'   => 'ForeignKey',
      'active_version'       => 'Number',
      'version'              => 'Number',
      'end_reason'           => 'Text',
      'content'              => 'Text',
      'content_type'         => 'Text',
      'start_workflow_at'    => 'Text',
      'workflow_is_started'  => 'Number',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
