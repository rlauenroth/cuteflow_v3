<?php

/**
 * EmailConfiguration form base class.
 *
 * @method EmailConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseEmailConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'smtphost'            => new sfWidgetFormInputText(),
      'smtpuseauth'         => new sfWidgetFormInputText(),
      'smtpport'            => new sfWidgetFormInputText(),
      'smtpusername'        => new sfWidgetFormInputText(),
      'smtppassword'        => new sfWidgetFormInputText(),
      'smtpencryption'      => new sfWidgetFormInputText(),
      'sendmailpath'        => new sfWidgetFormInputText(),
      'systemreplyaddress'  => new sfWidgetFormInputText(),
      'allowemailtransport' => new sfWidgetFormInputText(),
      'activetype'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'smtphost'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtpuseauth'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtpport'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtpusername'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtppassword'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'smtpencryption'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sendmailpath'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'systemreplyaddress'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'allowemailtransport' => new sfValidatorInteger(array('required' => false)),
      'activetype'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
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
