<?php

/**
 * EmailConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEmailConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'smtp_host'             => new sfWidgetFormFilterInput(),
      'smtp_useauth'          => new sfWidgetFormFilterInput(),
      'smtp_port'             => new sfWidgetFormFilterInput(),
      'smtp_username'         => new sfWidgetFormFilterInput(),
      'smtp_password'         => new sfWidgetFormFilterInput(),
      'smtp_encryption'       => new sfWidgetFormFilterInput(),
      'send_mailpath'         => new sfWidgetFormFilterInput(),
      'system_reply_address'  => new sfWidgetFormFilterInput(),
      'allow_email_transport' => new sfWidgetFormFilterInput(),
      'active_type'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'smtp_host'             => new sfValidatorPass(array('required' => false)),
      'smtp_useauth'          => new sfValidatorPass(array('required' => false)),
      'smtp_port'             => new sfValidatorPass(array('required' => false)),
      'smtp_username'         => new sfValidatorPass(array('required' => false)),
      'smtp_password'         => new sfValidatorPass(array('required' => false)),
      'smtp_encryption'       => new sfValidatorPass(array('required' => false)),
      'send_mailpath'         => new sfValidatorPass(array('required' => false)),
      'system_reply_address'  => new sfValidatorPass(array('required' => false)),
      'allow_email_transport' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active_type'           => new sfValidatorPass(array('required' => false)),
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
      'id'                    => 'Number',
      'smtp_host'             => 'Text',
      'smtp_useauth'          => 'Text',
      'smtp_port'             => 'Text',
      'smtp_username'         => 'Text',
      'smtp_password'         => 'Text',
      'smtp_encryption'       => 'Text',
      'send_mailpath'         => 'Text',
      'system_reply_address'  => 'Text',
      'allow_email_transport' => 'Number',
      'active_type'           => 'Text',
    );
  }
}
