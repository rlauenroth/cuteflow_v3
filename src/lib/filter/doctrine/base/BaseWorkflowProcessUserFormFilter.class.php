<?php

/**
 * WorkflowProcessUser filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflow_process_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcess'), 'add_empty' => true)),
      'workflow_slot_user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotUser'), 'add_empty' => true)),
      'user_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'in_progress_since'         => new sfWidgetFormFilterInput(),
      'decission_state'           => new sfWidgetFormFilterInput(),
      'date_of_decission'         => new sfWidgetFormFilterInput(),
      'is_user_agent_of'          => new sfWidgetFormFilterInput(),
      'user_agent_set_by_cronjob' => new sfWidgetFormFilterInput(),
      'resendet'                  => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'workflow_process_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowProcess'), 'column' => 'id')),
      'workflow_slot_user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlotUser'), 'column' => 'id')),
      'user_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'in_progress_since'         => new sfValidatorPass(array('required' => false)),
      'decission_state'           => new sfValidatorPass(array('required' => false)),
      'date_of_decission'         => new sfValidatorPass(array('required' => false)),
      'is_user_agent_of'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_agent_set_by_cronjob' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'resendet'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('workflow_process_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowProcessUser';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'workflow_process_id'       => 'ForeignKey',
      'workflow_slot_user_id'     => 'ForeignKey',
      'user_id'                   => 'ForeignKey',
      'in_progress_since'         => 'Text',
      'decission_state'           => 'Text',
      'date_of_decission'         => 'Text',
      'is_user_agent_of'          => 'Number',
      'user_agent_set_by_cronjob' => 'Number',
      'resendet'                  => 'Number',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
    );
  }
}
