<?php

/**
 * AuthorizationConfiguration form base class.
 *
 * @method AuthorizationConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAuthorizationConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'type'            => new sfWidgetFormInputText(),
      'deleteworkflow'  => new sfWidgetFormInputText(),
      'archiveworkflow' => new sfWidgetFormInputText(),
      'stopneworkflow'  => new sfWidgetFormInputText(),
      'detailsworkflow' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'type'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deleteworkflow'  => new sfValidatorInteger(array('required' => false)),
      'archiveworkflow' => new sfValidatorInteger(array('required' => false)),
      'stopneworkflow'  => new sfValidatorInteger(array('required' => false)),
      'detailsworkflow' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('authorization_configuration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthorizationConfiguration';
  }

}
