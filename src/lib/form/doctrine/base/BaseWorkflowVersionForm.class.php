<?php

/**
 * WorkflowVersion form base class.
 *
 * @method WorkflowVersion getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'workflowtemplate_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'additionaltext_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AdditionalText'), 'add_empty' => true)),
      'activeversion'       => new sfWidgetFormInputText(),
      'version'             => new sfWidgetFormInputText(),
      'endreason'           => new sfWidgetFormTextarea(),
      'content'             => new sfWidgetFormTextarea(),
      'contenttype'         => new sfWidgetFormInputText(),
      'startworkflow_at'    => new sfWidgetFormInputText(),
      'workflowisstarted'   => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'workflowtemplate_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'required' => false)),
      'additionaltext_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AdditionalText'), 'required' => false)),
      'activeversion'       => new sfValidatorInteger(array('required' => false)),
      'version'             => new sfValidatorInteger(array('required' => false)),
      'endreason'           => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'content'             => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'contenttype'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'startworkflow_at'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'workflowisstarted'   => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
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
