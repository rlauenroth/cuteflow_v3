<?php

/**
 * AuthenticationConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAuthenticationConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'authentication_type'            => new sfWidgetFormFilterInput(),
      'ldap_host'                      => new sfWidgetFormFilterInput(),
      'ldap_domain'                    => new sfWidgetFormFilterInput(),
      'ldap_bind_username_and_context' => new sfWidgetFormFilterInput(),
      'ldap_password'                  => new sfWidgetFormFilterInput(),
      'ldap_root_context'              => new sfWidgetFormFilterInput(),
      'ldap_user_search_attribute'     => new sfWidgetFormFilterInput(),
      'ldap_firstname'                 => new sfWidgetFormFilterInput(),
      'ldap_lastname'                  => new sfWidgetFormFilterInput(),
      'ldap_username'                  => new sfWidgetFormFilterInput(),
      'ldap_email'                     => new sfWidgetFormFilterInput(),
      'ldap_office'                    => new sfWidgetFormFilterInput(),
      'ldap_phone'                     => new sfWidgetFormFilterInput(),
      'ldap_context'                   => new sfWidgetFormFilterInput(),
      'ldap_add_user'                  => new sfWidgetFormFilterInput(),
      'openid_server'                  => new sfWidgetFormFilterInput(),
      'first_login'                    => new sfWidgetFormFilterInput(),
      'allow_direct_login'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'authentication_type'            => new sfValidatorPass(array('required' => false)),
      'ldap_host'                      => new sfValidatorPass(array('required' => false)),
      'ldap_domain'                    => new sfValidatorPass(array('required' => false)),
      'ldap_bind_username_and_context' => new sfValidatorPass(array('required' => false)),
      'ldap_password'                  => new sfValidatorPass(array('required' => false)),
      'ldap_root_context'              => new sfValidatorPass(array('required' => false)),
      'ldap_user_search_attribute'     => new sfValidatorPass(array('required' => false)),
      'ldap_firstname'                 => new sfValidatorPass(array('required' => false)),
      'ldap_lastname'                  => new sfValidatorPass(array('required' => false)),
      'ldap_username'                  => new sfValidatorPass(array('required' => false)),
      'ldap_email'                     => new sfValidatorPass(array('required' => false)),
      'ldap_office'                    => new sfValidatorPass(array('required' => false)),
      'ldap_phone'                     => new sfValidatorPass(array('required' => false)),
      'ldap_context'                   => new sfValidatorPass(array('required' => false)),
      'ldap_add_user'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'openid_server'                  => new sfValidatorPass(array('required' => false)),
      'first_login'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'allow_direct_login'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('authentication_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AuthenticationConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'authentication_type'            => 'Text',
      'ldap_host'                      => 'Text',
      'ldap_domain'                    => 'Text',
      'ldap_bind_username_and_context' => 'Text',
      'ldap_password'                  => 'Text',
      'ldap_root_context'              => 'Text',
      'ldap_user_search_attribute'     => 'Text',
      'ldap_firstname'                 => 'Text',
      'ldap_lastname'                  => 'Text',
      'ldap_username'                  => 'Text',
      'ldap_email'                     => 'Text',
      'ldap_office'                    => 'Text',
      'ldap_phone'                     => 'Text',
      'ldap_context'                   => 'Text',
      'ldap_add_user'                  => 'Number',
      'openid_server'                  => 'Text',
      'first_login'                    => 'Number',
      'allow_direct_login'             => 'Number',
    );
  }
}
