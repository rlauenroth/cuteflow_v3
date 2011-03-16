<?php

/**
 * AuthenticationConfiguration form base class.
 *
 * @method AuthenticationConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAuthenticationConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'authenticationtype'         => new sfWidgetFormInputText(),
      'ldaphost'                   => new sfWidgetFormInputText(),
      'ldapdomain'                 => new sfWidgetFormInputText(),
      'ldapbindusernameandcontext' => new sfWidgetFormInputText(),
      'ldappassword'               => new sfWidgetFormInputText(),
      'ldaprootcontext'            => new sfWidgetFormInputText(),
      'ldapusersearchattribute'    => new sfWidgetFormInputText(),
      'ldapfirstname'              => new sfWidgetFormInputText(),
      'ldaplastname'               => new sfWidgetFormInputText(),
      'ldapusername'               => new sfWidgetFormInputText(),
      'ldapemail'                  => new sfWidgetFormInputText(),
      'ldapoffice'                 => new sfWidgetFormInputText(),
      'ldapphone'                  => new sfWidgetFormInputText(),
      'ldapcontext'                => new sfWidgetFormInputText(),
      'ldapadduser'                => new sfWidgetFormInputText(),
      'openidserver'               => new sfWidgetFormInputText(),
      'firstlogin'                 => new sfWidgetFormInputText(),
      'allowdirectlogin'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'authenticationtype'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'ldaphost'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapdomain'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapbindusernameandcontext' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldappassword'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldaprootcontext'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapusersearchattribute'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapfirstname'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldaplastname'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapusername'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapemail'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapoffice'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapphone'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapcontext'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldapadduser'                => new sfValidatorInteger(array('required' => false)),
      'openidserver'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'firstlogin'                 => new sfValidatorInteger(array('required' => false)),
      'allowdirectlogin'           => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('authentication_configuration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthenticationConfiguration';
  }

}
