<?php

/**
 * CredentialsRole form base class.
 *
 * @package    form
 * @subpackage credentials_role
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCredentialsRoleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'       => new sfWidgetFormInputHidden(),
      'credential_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'role_id'       => new sfValidatorDoctrineChoice(array('model' => 'CredentialsRole', 'column' => 'role_id', 'required' => false)),
      'credential_id' => new sfValidatorDoctrineChoice(array('model' => 'CredentialsRole', 'column' => 'credential_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('credentials_role[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CredentialsRole';
  }

}
