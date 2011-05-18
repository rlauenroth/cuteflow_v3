<?php

/**
 * WorkflowConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWorkflowConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'column_text' => new sfWidgetFormFilterInput(),
      'is_active'   => new sfWidgetFormFilterInput(),
      'position'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'column_text' => new sfValidatorPass(array('required' => false)),
      'is_active'   => new sfValidatorPass(array('required' => false)),
      'position'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('workflow_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WorkflowConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'column_text' => 'Text',
      'is_active'   => 'Text',
      'position'    => 'Number',
    );
  }
}
