<?php

/**
 * UserWorkflowConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserWorkflowConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'field_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'column_text' => new sfWidgetFormFilterInput(),
      'is_active'   => new sfWidgetFormFilterInput(),
      'position'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'field_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'column_text' => new sfValidatorPass(array('required' => false)),
      'is_active'   => new sfValidatorPass(array('required' => false)),
      'position'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('user_workflow_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserWorkflowConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'user_id'     => 'ForeignKey',
      'field_id'    => 'ForeignKey',
      'column_text' => 'Text',
      'is_active'   => 'Text',
      'position'    => 'Number',
    );
  }
}
