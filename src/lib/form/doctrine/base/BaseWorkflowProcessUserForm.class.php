<?php

/**
 * WorkflowProcessUser form base class.
 *
 * @method WorkflowProcessUser getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowProcessUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'workflowprocess_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcess'), 'add_empty' => true)),
      'workflowslotuser_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotUser'), 'add_empty' => true)),
      'user_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'inprogresssince'       => new sfWidgetFormInputText(),
      'decissionstate'        => new sfWidgetFormInputText(),
      'dateofdecission'       => new sfWidgetFormInputText(),
      'isuseragentof'         => new sfWidgetFormInputText(),
      'useragentsetbycronjob' => new sfWidgetFormInputText(),
      'resendet'              => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowprocess_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcess'), 'required' => false)),
      'workflowslotuser_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowSlotUser'), 'required' => false)),
      'user_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'required' => false)),
      'inprogresssince'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'decissionstate'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dateofdecission'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'isuseragentof'         => new sfValidatorInteger(array('required' => false)),
      'useragentsetbycronjob' => new sfValidatorInteger(array('required' => false)),
      'resendet'              => new sfValidatorInteger(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
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
