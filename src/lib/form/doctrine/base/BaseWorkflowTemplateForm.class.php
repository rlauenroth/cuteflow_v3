<?php

/**
 * WorkflowTemplate form base class.
 *
 * @method WorkflowTemplate getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWorkflowTemplateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                              => new sfWidgetFormInputHidden(),
      'mailinglist_template_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'document_template_version_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'add_empty' => true)),
      'sender_id'                       => new sfWidgetFormInputText(),
      'name'                            => new sfWidgetFormInputText(),
      'is_stopped'                      => new sfWidgetFormInputText(),
      'stopped_at'                      => new sfWidgetFormInputText(),
      'stopped_by'                      => new sfWidgetFormInputText(),
      'completed_at'                    => new sfWidgetFormInputText(),
      'is_completed'                    => new sfWidgetFormInputText(),
      'is_archived'                     => new sfWidgetFormInputText(),
      'archived_at'                     => new sfWidgetFormInputText(),
      'archived_by'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'end_action'                      => new sfWidgetFormInputText(),
      'deleted_at'                      => new sfWidgetFormDateTime(),
      'created_at'                      => new sfWidgetFormDateTime(),
      'updated_at'                      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mailinglist_template_version_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'required' => false)),
      'document_template_version_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'required' => false)),
      'sender_id'                       => new sfValidatorInteger(array('required' => false)),
      'name'                            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_stopped'                      => new sfValidatorInteger(array('required' => false)),
      'stopped_at'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'stopped_by'                      => new sfValidatorInteger(array('required' => false)),
      'completed_at'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_completed'                    => new sfValidatorInteger(array('required' => false)),
      'is_archived'                     => new sfValidatorInteger(array('required' => false)),
      'archived_at'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'archived_by'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'required' => false)),
      'end_action'                      => new sfValidatorInteger(array('required' => false)),
      'deleted_at'                      => new sfValidatorDateTime(array('required' => false)),
      'created_at'                      => new sfValidatorDateTime(),
      'updated_at'                      => new sfValidatorDateTime(),
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
