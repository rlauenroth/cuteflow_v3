<?php

/**
 * WorkflowVersionAttachment filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowVersionAttachmentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_template_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'workflow_version_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'add_empty' => true)),
      'filename'             => new sfWidgetFormFilterInput(),
      'hashname'             => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'workflow_template_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowTemplate'), 'column' => 'id')),
      'workflow_version_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowVersion'), 'column' => 'id')),
      'filename'             => new sfValidatorPass(array('required' => false)),
      'hashname'             => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('workflow_version_attachment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowVersionAttachment';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'workflow_template_id' => 'ForeignKey',
      'workflow_version_id'  => 'ForeignKey',
      'filename'             => 'Text',
      'hashname'             => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
