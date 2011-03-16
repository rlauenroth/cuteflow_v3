<?php

/**
 * WorkflowTemplate form base class.
 *
 * @method WorkflowTemplate getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowTemplateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'mailinglisttemplateversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'documenttemplateversion_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'add_empty' => true)),
      'sender_id'                     => new sfWidgetFormInputText(),
      'name'                          => new sfWidgetFormInputText(),
      'isstopped'                     => new sfWidgetFormInputText(),
      'stopped_at'                    => new sfWidgetFormInputText(),
      'stopped_by'                    => new sfWidgetFormInputText(),
      'completed_at'                  => new sfWidgetFormInputText(),
      'iscompleted'                   => new sfWidgetFormInputText(),
      'isarchived'                    => new sfWidgetFormInputText(),
      'archived_at'                   => new sfWidgetFormInputText(),
      'archived_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'endaction'                     => new sfWidgetFormInputText(),
      'deleted_at'                    => new sfWidgetFormDateTime(),
      'created_at'                    => new sfWidgetFormDateTime(),
      'updated_at'                    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'mailinglisttemplateversion_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'required' => false)),
      'documenttemplateversion_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'required' => false)),
      'sender_id'                     => new sfValidatorInteger(array('required' => false)),
      'name'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'isstopped'                     => new sfValidatorInteger(array('required' => false)),
      'stopped_at'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'stopped_by'                    => new sfValidatorInteger(array('required' => false)),
      'completed_at'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'iscompleted'                   => new sfValidatorInteger(array('required' => false)),
      'isarchived'                    => new sfValidatorInteger(array('required' => false)),
      'archived_at'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'archived_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'required' => false)),
      'endaction'                     => new sfValidatorInteger(array('required' => false)),
      'deleted_at'                    => new sfValidatorDateTime(array('required' => false)),
      'created_at'                    => new sfValidatorDateTime(),
      'updated_at'                    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('workflow_template[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowTemplate';
  }

}
