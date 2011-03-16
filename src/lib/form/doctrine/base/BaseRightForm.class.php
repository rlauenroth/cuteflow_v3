<?php

/**
 * Right form base class.
 *
 * @package    form
 * @subpackage right
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseRightForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'moduleUser'               => new sfWidgetFormInputText(),
      'addUser'                  => new sfWidgetFormInputText(),
      'deleteUser'               => new sfWidgetFormInputText(),
      'editUser'                 => new sfWidgetFormInputText(),
      'moduleEditOwnProfile'     => new sfWidgetFormInputText(),
      'changeOwnRole'            => new sfWidgetFormInputText(),
      'changeOwnDetail'          => new sfWidgetFormInputText(),
      'moduleSystemsetting'      => new sfWidgetFormInputText(),
      'moduleSendMessage'        => new sfWidgetFormInputText(),
      'moduleUserRoleManagement' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorDoctrineChoice(array('model' => 'Right', 'column' => 'id', 'required' => false)),
      'moduleUser'               => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'addUser'                  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'deleteUser'               => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'editUser'                 => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'moduleEditOwnProfile'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'changeOwnRole'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'changeOwnDetail'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'moduleSystemsetting'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'moduleSendMessage'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'moduleUserRoleManagement' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('right[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Right';
  }

}
