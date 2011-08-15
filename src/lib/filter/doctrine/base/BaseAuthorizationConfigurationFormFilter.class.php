<?php

/**
 * AuthorizationConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAuthorizationConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'type'             => new sfWidgetFormFilterInput(),
      'delete_workflow'  => new sfWidgetFormFilterInput(),
      'archive_workflow' => new sfWidgetFormFilterInput(),
      'stop_new_orkflow' => new sfWidgetFormFilterInput(),
      'details_workflow' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'type'             => new sfValidatorPass(array('required' => false)),
      'delete_workflow'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archive_workflow' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stop_new_orkflow' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'details_workflow' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('authorization_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthorizationConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'type'             => 'Text',
      'delete_workflow'  => 'Number',
      'archive_workflow' => 'Number',
      'stop_new_orkflow' => 'Number',
      'details_workflow' => 'Number',
    );
  }
}
