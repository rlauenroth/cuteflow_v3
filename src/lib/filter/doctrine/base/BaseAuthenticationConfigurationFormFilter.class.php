<?php

/**
 * AuthenticationConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAuthenticationConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'authenticationtype'         => new sfWidgetFormFilterInput(),
      'ldaphost'                   => new sfWidgetFormFilterInput(),
      'ldapdomain'                 => new sfWidgetFormFilterInput(),
      'ldapbindusernameandcontext' => new sfWidgetFormFilterInput(),
      'ldappassword'               => new sfWidgetFormFilterInput(),
      'ldaprootcontext'            => new sfWidgetFormFilterInput(),
      'ldapusersearchattribute'    => new sfWidgetFormFilterInput(),
      'ldapfirstname'              => new sfWidgetFormFilterInput(),
      'ldaplastname'               => new sfWidgetFormFilterInput(),
      'ldapusername'               => new sfWidgetFormFilterInput(),
      'ldapemail'                  => new sfWidgetFormFilterInput(),
      'ldapoffice'                 => new sfWidgetFormFilterInput(),
      'ldapphone'                  => new sfWidgetFormFilterInput(),
      'ldapcontext'                => new sfWidgetFormFilterInput(),
      'ldapadduser'                => new sfWidgetFormFilterInput(),
      'openidserver'               => new sfWidgetFormFilterInput(),
      'firstlogin'                 => new sfWidgetFormFilterInput(),
      'allowdirectlogin'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'authenticationtype'         => new sfValidatorPass(array('required' => false)),
      'ldaphost'                   => new sfValidatorPass(array('required' => false)),
      'ldapdomain'                 => new sfValidatorPass(array('required' => false)),
      'ldapbindusernameandcontext' => new sfValidatorPass(array('required' => false)),
      'ldappassword'               => new sfValidatorPass(array('required' => false)),
      'ldaprootcontext'            => new sfValidatorPass(array('required' => false)),
      'ldapusersearchattribute'    => new sfValidatorPass(array('required' => false)),
      'ldapfirstname'              => new sfValidatorPass(array('required' => false)),
      'ldaplastname'               => new sfValidatorPass(array('required' => false)),
      'ldapusername'               => new sfValidatorPass(array('required' => false)),
      'ldapemail'                  => new sfValidatorPass(array('required' => false)),
      'ldapoffice'                 => new sfValidatorPass(array('required' => false)),
      'ldapphone'                  => new sfValidatorPass(array('required' => false)),
      'ldapcontext'                => new sfValidatorPass(array('required' => false)),
      'ldapadduser'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'openidserver'               => new sfValidatorPass(array('required' => false)),
      'firstlogin'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'allowdirectlogin'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'                         => 'Number',
      'authenticationtype'         => 'Text',
      'ldaphost'                   => 'Text',
      'ldapdomain'                 => 'Text',
      'ldapbindusernameandcontext' => 'Text',
      'ldappassword'               => 'Text',
      'ldaprootcontext'            => 'Text',
      'ldapusersearchattribute'    => 'Text',
      'ldapfirstname'              => 'Text',
      'ldaplastname'               => 'Text',
      'ldapusername'               => 'Text',
      'ldapemail'                  => 'Text',
      'ldapoffice'                 => 'Text',
      'ldapphone'                  => 'Text',
      'ldapcontext'                => 'Text',
      'ldapadduser'                => 'Number',
      'openidserver'               => 'Text',
      'firstlogin'                 => 'Number',
      'allowdirectlogin'           => 'Number',
    );
  }
}
