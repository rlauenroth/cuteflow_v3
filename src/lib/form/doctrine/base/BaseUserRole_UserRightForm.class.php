<?php

/**
 * UserRole_UserRight form base class.
 *
 * @package    form
 * @subpackage user_role_user_right
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUserRole_UserRightForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'userrole_id'  => new sfWidgetFormInputHidden(),
      'userright_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'userrole_id'  => new sfValidatorDoctrineChoice(array('model' => 'UserRole_UserRight', 'column' => 'userrole_id', 'required' => false)),
      'userright_id' => new sfValidatorDoctrineChoice(array('model' => 'UserRole_UserRight', 'column' => 'userright_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_role_user_right[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserRole_UserRight';
  }

}
