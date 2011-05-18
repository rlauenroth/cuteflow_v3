<?php

/**
 * WorkflowVersion form base class.
 *
 * @method WorkflowVersion getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWorkflowVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'workflow_template_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'additional_text_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdditionalText'), 'add_empty' => true)),
      'active_version'       => new sfWidgetFormInputText(),
      'version'              => new sfWidgetFormInputText(),
      'end_reason'           => new sfWidgetFormTextarea(),
      'content'              => new sfWidgetFormTextarea(),
      'content_type'         => new sfWidgetFormInputText(),
      'start_workflow_at'    => new sfWidgetFormInputText(),
      'workflow_is_started'  => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'workflow_template_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'required' => false)),
      'additional_text_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AdditionalText'), 'required' => false)),
      'active_version'       => new sfValidatorInteger(array('required' => false)),
      'version'              => new sfValidatorInteger(array('required' => false)),
      'end_reason'           => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'content'              => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'content_type'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'start_workflow_at'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'workflow_is_started'  => new sfValidatorInteger(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('workflow_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowVersion';
  }

}
