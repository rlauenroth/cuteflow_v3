<?php

/**
 * WorkflowVersion filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflowtemplate_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'additionaltext_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdditionalText'), 'add_empty' => true)),
      'activeversion'       => new sfWidgetFormFilterInput(),
      'version'             => new sfWidgetFormFilterInput(),
      'endreason'           => new sfWidgetFormFilterInput(),
      'content'             => new sfWidgetFormFilterInput(),
      'contenttype'         => new sfWidgetFormFilterInput(),
      'startworkflow_at'    => new sfWidgetFormFilterInput(),
      'workflowisstarted'   => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'workflowtemplate_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowTemplate'), 'column' => 'id')),
      'additionaltext_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AdditionalText'), 'column' => 'id')),
      'activeversion'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'version'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'endreason'           => new sfValidatorPass(array('required' => false)),
      'content'             => new sfValidatorPass(array('required' => false)),
      'contenttype'         => new sfValidatorPass(array('required' => false)),
      'startworkflow_at'    => new sfValidatorPass(array('required' => false)),
      'workflowisstarted'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'                  => 'Number',
      'workflowtemplate_id' => 'ForeignKey',
      'additionaltext_id'   => 'ForeignKey',
      'activeversion'       => 'Number',
      'version'             => 'Number',
      'endreason'           => 'Text',
      'content'             => 'Text',
      'contenttype'         => 'Text',
      'startworkflow_at'    => 'Text',
      'workflowisstarted'   => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
