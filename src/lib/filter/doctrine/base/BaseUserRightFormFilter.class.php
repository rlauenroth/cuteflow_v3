<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * UserRight filter form base class.
 *
 * @package    filters
 * @subpackage UserRight *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseUserRightFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'moduleUser'               => new sfWidgetFormFilterInput(),
      'addUser'                  => new sfWidgetFormFilterInput(),
      'deleteUser'               => new sfWidgetFormFilterInput(),
      'editUser'                 => new sfWidgetFormFilterInput(),
      'moduleEditOwnProfile'     => new sfWidgetFormFilterInput(),
      'changeOwnRole'            => new sfWidgetFormFilterInput(),
      'changeOwnDetail'          => new sfWidgetFormFilterInput(),
      'moduleSystemsetting'      => new sfWidgetFormFilterInput(),
      'moduleSendMessage'        => new sfWidgetFormFilterInput(),
      'moduleUserRoleManagement' => new sfWidgetFormFilterInput(),
      'user_roles_list'          => new sfWidgetFormDoctrineChoiceMany(array('model' => 'UserRole')),
    ));

    $this->setValidators(array(
      'moduleUser'               => new sfValidatorPass(array('required' => false)),
      'addUser'                  => new sfValidatorPass(array('required' => false)),
      'deleteUser'               => new sfValidatorPass(array('required' => false)),
      'editUser'                 => new sfValidatorPass(array('required' => false)),
      'moduleEditOwnProfile'     => new sfValidatorPass(array('required' => false)),
      'changeOwnRole'            => new sfValidatorPass(array('required' => false)),
      'changeOwnDetail'          => new sfValidatorPass(array('required' => false)),
      'moduleSystemsetting'      => new sfValidatorPass(array('required' => false)),
      'moduleSendMessage'        => new sfValidatorPass(array('required' => false)),
      'moduleUserRoleManagement' => new sfValidatorPass(array('required' => false)),
      'user_roles_list'          => new sfValidatorDoctrineChoiceMany(array('model' => 'UserRole', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_right_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUserRolesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.UserRightUserRole UserRightUserRole')
          ->andWhereIn('UserRightUserRole.user_role_id', $values);
  }

  public function getModelName()
  {
    return 'UserRight';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'moduleUser'               => 'Text',
      'addUser'                  => 'Text',
      'deleteUser'               => 'Text',
      'editUser'                 => 'Text',
      'moduleEditOwnProfile'     => 'Text',
      'changeOwnRole'            => 'Text',
      'changeOwnDetail'          => 'Text',
      'moduleSystemsetting'      => 'Text',
      'moduleSendMessage'        => 'Text',
      'moduleUserRoleManagement' => 'Text',
      'user_roles_list'          => 'ManyKey',
    );
  }
}