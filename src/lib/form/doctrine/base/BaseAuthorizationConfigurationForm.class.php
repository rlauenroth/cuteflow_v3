<?php

/**
 * AuthorizationConfiguration form base class.
 *
 * @method AuthorizationConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAuthorizationConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'type'             => new sfWidgetFormInputText(),
      'delete_workflow'  => new sfWidgetFormInputText(),
      'archive_workflow' => new sfWidgetFormInputText(),
      'stop_new_orkflow' => new sfWidgetFormInputText(),
      'details_workflow' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'delete_workflow'  => new sfValidatorInteger(array('required' => false)),
      'archive_workflow' => new sfValidatorInteger(array('required' => false)),
      'stop_new_orkflow' => new sfValidatorInteger(array('required' => false)),
      'details_workflow' => new sfValidatorInteger(array('required' => false)),
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
