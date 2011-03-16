<?php

/**
 * WorkflowConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseWorkflowConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'columntext' => new sfWidgetFormFilterInput(),
      'isactive'   => new sfWidgetFormFilterInput(),
      'position'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'columntext' => new sfValidatorPass(array('required' => false)),
      'isactive'   => new sfValidatorPass(array('required' => false)),
      'position'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'         => 'Number',
      'columntext' => 'Text',
      'isactive'   => 'Text',
      'position'   => 'Number',
    );
  }
}
