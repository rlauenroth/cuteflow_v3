<?php

/**
 * RoleRight form base class.
 *
 * @package    form
 * @subpackage role_right
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseRoleRightForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'userrole_id'  => new sfWidgetFormInputHidden(),
      'userright_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'userrole_id'  => new sfValidatorDoctrineChoice(array('model' => 'RoleRight', 'column' => 'userrole_id', 'required' => false)),
      'userright_id' => new sfValidatorDoctrineChoice(array('model' => 'RoleRight', 'column' => 'userright_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_right[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RoleRight';
  }

}
