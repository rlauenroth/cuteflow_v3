<?php

/**
 * EmailConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseEmailConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'smtphost'            => new sfWidgetFormFilterInput(),
      'smtpuseauth'         => new sfWidgetFormFilterInput(),
      'smtpport'            => new sfWidgetFormFilterInput(),
      'smtpusername'        => new sfWidgetFormFilterInput(),
      'smtppassword'        => new sfWidgetFormFilterInput(),
      'smtpencryption'      => new sfWidgetFormFilterInput(),
      'sendmailpath'        => new sfWidgetFormFilterInput(),
      'systemreplyaddress'  => new sfWidgetFormFilterInput(),
      'allowemailtransport' => new sfWidgetFormFilterInput(),
      'activetype'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'smtphost'            => new sfValidatorPass(array('required' => false)),
      'smtpuseauth'         => new sfValidatorPass(array('required' => false)),
      'smtpport'            => new sfValidatorPass(array('required' => false)),
      'smtpusername'        => new sfValidatorPass(array('required' => false)),
      'smtppassword'        => new sfValidatorPass(array('required' => false)),
      'smtpencryption'      => new sfValidatorPass(array('required' => false)),
      'sendmailpath'        => new sfValidatorPass(array('required' => false)),
      'systemreplyaddress'  => new sfValidatorPass(array('required' => false)),
      'allowemailtransport' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activetype'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('email_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmailConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'smtphost'            => 'Text',
      'smtpuseauth'         => 'Text',
      'smtpport'            => 'Text',
      'smtpusername'        => 'Text',
      'smtppassword'        => 'Text',
      'smtpencryption'      => 'Text',
      'sendmailpath'        => 'Text',
      'systemreplyaddress'  => 'Text',
      'allowemailtransport' => 'Number',
      'activetype'          => 'Text',
    );
  }
}
