<?php

/**
 * CredentialRole form base class.
 *
 * @method CredentialRole getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCredentialRoleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'       => new sfWidgetFormInputHidden(),
      'credential_id' => new sfWidgetFormInputHidden(),
      'deleted_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'role_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'role_id', 'required' => false)),
      'credential_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'credential_id', 'required' => false)),
      'deleted_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('credential_role[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CredentialRole';
  }

}
