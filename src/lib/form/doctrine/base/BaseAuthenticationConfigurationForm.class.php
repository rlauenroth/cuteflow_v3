<?php

/**
 * AuthenticationConfiguration form base class.
 *
 * @method AuthenticationConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAuthenticationConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'authentication_type'            => new sfWidgetFormInputText(),
      'ldap_host'                      => new sfWidgetFormInputText(),
      'ldap_domain'                    => new sfWidgetFormInputText(),
      'ldap_bind_username_and_context' => new sfWidgetFormInputText(),
      'ldap_password'                  => new sfWidgetFormInputText(),
      'ldap_root_context'              => new sfWidgetFormInputText(),
      'ldap_user_search_attribute'     => new sfWidgetFormInputText(),
      'ldap_firstname'                 => new sfWidgetFormInputText(),
      'ldap_lastname'                  => new sfWidgetFormInputText(),
      'ldap_username'                  => new sfWidgetFormInputText(),
      'ldap_email'                     => new sfWidgetFormInputText(),
      'ldap_office'                    => new sfWidgetFormInputText(),
      'ldap_phone'                     => new sfWidgetFormInputText(),
      'ldap_context'                   => new sfWidgetFormInputText(),
      'ldap_add_user'                  => new sfWidgetFormInputText(),
      'openid_server'                  => new sfWidgetFormInputText(),
      'first_login'                    => new sfWidgetFormInputText(),
      'allow_direct_login'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'authentication_type'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'ldap_host'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_domain'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_bind_username_and_context' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_password'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_root_context'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_user_search_attribute'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_firstname'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_lastname'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_username'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_email'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_office'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_phone'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_context'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ldap_add_user'                  => new sfValidatorInteger(array('required' => false)),
      'openid_server'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_login'                    => new sfValidatorInteger(array('required' => false)),
      'allow_direct_login'             => new sfValidatorInteger(array('required' => false)),
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
