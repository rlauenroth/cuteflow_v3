<?php

/**
 * WorkflowProcessUser form base class.
 *
 * @method WorkflowProcessUser getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'workflow_process_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcess'), 'add_empty' => true)),
      'workflow_slot_user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotUser'), 'add_empty' => true)),
      'user_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'in_progress_since'         => new sfWidgetFormInputText(),
      'decission_state'           => new sfWidgetFormInputText(),
      'date_of_decission'         => new sfWidgetFormInputText(),
      'is_user_agent_of'          => new sfWidgetFormInputText(),
      'user_agent_set_by_cronjob' => new sfWidgetFormInputText(),
      'resendet'                  => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'workflow_process_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcess'), 'required' => false)),
      'workflow_slot_user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotUser'), 'required' => false)),
      'user_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'required' => false)),
      'in_progress_since'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'decission_state'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_of_decission'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_user_agent_of'          => new sfValidatorInteger(array('required' => false)),
      'user_agent_set_by_cronjob' => new sfValidatorInteger(array('required' => false)),
      'resendet'                  => new sfValidatorInteger(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('workflow_process_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowProcessUser';
  }

}
