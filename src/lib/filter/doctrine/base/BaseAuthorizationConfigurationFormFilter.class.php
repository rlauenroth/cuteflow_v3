<?php

/**
 * AuthorizationConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAuthorizationConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'type'            => new sfWidgetFormFilterInput(),
      'deleteworkflow'  => new sfWidgetFormFilterInput(),
      'archiveworkflow' => new sfWidgetFormFilterInput(),
      'stopneworkflow'  => new sfWidgetFormFilterInput(),
      'detailsworkflow' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'type'            => new sfValidatorPass(array('required' => false)),
      'deleteworkflow'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archiveworkflow' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stopneworkflow'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'detailsworkflow' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'              => 'Number',
      'type'            => 'Text',
      'deleteworkflow'  => 'Number',
      'archiveworkflow' => 'Number',
      'stopneworkflow'  => 'Number',
      'detailsworkflow' => 'Number',
    );
  }
}
