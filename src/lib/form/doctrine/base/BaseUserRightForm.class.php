<?php

/**
 * UserRight form base class.
 *
 * @package    form
 * @subpackage user_right
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUserRightForm extends BaseFormDoctrine
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
      'user_roles_list'          => new sfWidgetFormDoctrineChoiceMany(array('model' => 'UserRole')),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorDoctrineChoice(array('model' => 'UserRight', 'column' => 'id', 'required' => false)),
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
      'user_roles_list'          => new sfValidatorDoctrineChoiceMany(array('model' => 'UserRole', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_right[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserRight';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_roles_list']))
    {
      $this->setDefault('user_roles_list', $this->object->UserRoles->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserRolesList($con);
  }

  public function saveUserRolesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_roles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->UserRoles->getPrimaryKeys();
    $values = $this->getValue('user_roles_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('UserRoles', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('UserRoles', array_values($link));
    }
  }

}
