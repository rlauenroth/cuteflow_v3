<?php

/**
 * WorkflowProcessUser filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'workflowprocess_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcess'), 'add_empty' => true)),
      'workflowslotuser_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotUser'), 'add_empty' => true)),
      'user_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'inprogresssince'       => new sfWidgetFormFilterInput(),
      'decissionstate'        => new sfWidgetFormFilterInput(),
      'dateofdecission'       => new sfWidgetFormFilterInput(),
      'isuseragentof'         => new sfWidgetFormFilterInput(),
      'useragentsetbycronjob' => new sfWidgetFormFilterInput(),
      'resendet'              => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'workflowprocess_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowProcess'), 'column' => 'id')),
      'workflowslotuser_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowSlotUser'), 'column' => 'id')),
      'user_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'inprogresssince'       => new sfValidatorPass(array('required' => false)),
      'decissionstate'        => new sfValidatorPass(array('required' => false)),
      'dateofdecission'       => new sfValidatorPass(array('required' => false)),
      'isuseragentof'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'useragentsetbycronjob' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'resendet'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'                    => 'Number',
      'workflowprocess_id'    => 'ForeignKey',
      'workflowslotuser_id'   => 'ForeignKey',
      'user_id'               => 'ForeignKey',
      'inprogresssince'       => 'Text',
      'decissionstate'        => 'Text',
      'dateofdecission'       => 'Text',
      'isuseragentof'         => 'Number',
      'useragentsetbycronjob' => 'Number',
      'resendet'              => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
