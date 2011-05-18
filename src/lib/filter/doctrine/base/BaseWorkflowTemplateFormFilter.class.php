<?php

/**
 * WorkflowTemplate filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowTemplateFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglist_template_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'document_template_version_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'add_empty' => true)),
      'sender_id'                       => new sfWidgetFormFilterInput(),
      'name'                            => new sfWidgetFormFilterInput(),
      'is_stopped'                      => new sfWidgetFormFilterInput(),
      'stopped_at'                      => new sfWidgetFormFilterInput(),
      'stopped_by'                      => new sfWidgetFormFilterInput(),
      'completed_at'                    => new sfWidgetFormFilterInput(),
      'is_completed'                    => new sfWidgetFormFilterInput(),
      'is_archived'                     => new sfWidgetFormFilterInput(),
      'archived_at'                     => new sfWidgetFormFilterInput(),
      'archived_by'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'end_action'                      => new sfWidgetFormFilterInput(),
      'deleted_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'mailinglist_template_version_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistVersion'), 'column' => 'id')),
      'document_template_version_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'column' => 'id')),
      'sender_id'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'                            => new sfValidatorPass(array('required' => false)),
      'is_stopped'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stopped_at'                      => new sfValidatorPass(array('required' => false)),
      'stopped_by'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'completed_at'                    => new sfValidatorPass(array('required' => false)),
      'is_completed'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_archived'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archived_at'                     => new sfValidatorPass(array('required' => false)),
      'archived_by'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'end_action'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'deleted_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('workflow_template_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowTemplate';
  }

  public function getFields()
  {
    return array(
      'id'                              => 'Number',
      'mailinglist_template_version_id' => 'ForeignKey',
      'document_template_version_id'    => 'ForeignKey',
      'sender_id'                       => 'Number',
      'name'                            => 'Text',
      'is_stopped'                      => 'Number',
      'stopped_at'                      => 'Text',
      'stopped_by'                      => 'Number',
      'completed_at'                    => 'Text',
      'is_completed'                    => 'Number',
      'is_archived'                     => 'Number',
      'archived_at'                     => 'Text',
      'archived_by'                     => 'ForeignKey',
      'end_action'                      => 'Number',
      'deleted_at'                      => 'Date',
      'created_at'                      => 'Date',
      'updated_at'                      => 'Date',
    );
  }
}
