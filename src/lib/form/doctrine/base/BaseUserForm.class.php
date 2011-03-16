<?php

/**
 * User form base class.
 *
 * @package    form
 * @subpackage user
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'role_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'Role', 'add_empty' => true)),
      'firstname'    => new sfWidgetFormInputText(),
      'lastname'     => new sfWidgetFormInputText(),
      'email'        => new sfWidgetFormInputText(),
      'username'     => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputText(),
      'street'       => new sfWidgetFormInputText(),
      'zip'          => new sfWidgetFormInputText(),
      'city'         => new sfWidgetFormInputText(),
      'phone1'       => new sfWidgetFormInputText(),
      'phone2'       => new sfWidgetFormInputText(),
      'mobile'       => new sfWidgetFormInputText(),
      'fax'          => new sfWidgetFormInputText(),
      'organisation' => new sfWidgetFormInputText(),
      'department'   => new sfWidgetFormInputText(),
      'burdenCenter' => new sfWidgetFormInputText(),
      'emailFormat'  => new sfWidgetFormInputText(),
      'comment'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'role_id'      => new sfValidatorDoctrineChoice(array('model' => 'Role', 'required' => false)),
      'firstname'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'lastname'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'email'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'username'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'password'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'street'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'zip'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'city'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'phone1'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'phone2'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'mobile'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'fax'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'organisation' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'department'   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'burdenCenter' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'emailFormat'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'comment'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
