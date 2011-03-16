<?php

/**
 * UserRole form base class.
 *
 * @package    form
 * @subpackage user_role
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseUserRoleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'description'      => new sfWidgetFormInputText(),
      'group_by'         => new sfWidgetFormInputText(),
      'deleteable'       => new sfWidgetFormInputText(),
      'editable'         => new sfWidgetFormInputText(),
      'user_rights_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'UserRight')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => 'UserRole', 'column' => 'id', 'required' => false)),
      'description'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'group_by'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'deleteable'       => new sfValidatorInteger(array('required' => false)),
      'editable'         => new sfValidatorInteger(array('required' => false)),
      'user_rights_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'UserRight', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_role[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserRole';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_rights_list']))
    {
      $this->setDefault('user_rights_list', $this->object->UserRights->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserRightsList($con);
  }

  public function saveUserRightsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_rights_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->UserRights->getPrimaryKeys();
    $values = $this->getValue('user_rights_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('UserRights', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('UserRights', array_values($link));
    }
  }

}
