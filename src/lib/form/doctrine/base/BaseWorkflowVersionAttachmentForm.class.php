<?php

/**
 * WorkflowVersionAttachment form base class.
 *
 * @method WorkflowVersionAttachment getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWorkflowVersionAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'workflow_template_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'add_empty' => true)),
      'workflow_version_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'add_empty' => true)),
      'filename'             => new sfWidgetFormInputText(),
      'hashname'             => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'workflow_template_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowTemplate'), 'required' => false)),
      'workflow_version_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowVersion'), 'required' => false)),
      'filename'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'hashname'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('workflow_version_attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowVersionAttachment';
  }

}
