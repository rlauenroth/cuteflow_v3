<?php

/**
 * EmailConfiguration form base class.
 *
 * @method EmailConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEmailConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'smtp_host'             => new sfWidgetFormInputText(),
      'smtp_useauth'          => new sfWidgetFormInputText(),
      'smtp_port'             => new sfWidgetFormInputText(),
      'smtp_username'         => new sfWidgetFormInputText(),
      'smtp_password'         => new sfWidgetFormInputText(),
      'smtp_encryption'       => new sfWidgetFormInputText(),
      'send_mailpath'         => new sfWidgetFormInputText(),
      'system_reply_address'  => new sfWidgetFormInputText(),
      'allow_email_transport' => new sfWidgetFormInputText(),
      'active_type'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'smtp_host'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtp_useauth'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtp_port'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtp_username'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtp_password'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtp_encryption'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'send_mailpath'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'system_reply_address'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'allow_email_transport' => new sfValidatorInteger(array('required' => false)),
      'active_type'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('email_configuration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmailConfiguration';
  }

}
