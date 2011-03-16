<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * UserRole filter form base class.
 *
 * @package    filters
 * @subpackage UserRole *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseUserRoleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'description'      => new sfWidgetFormFilterInput(),
      'group_by'         => new sfWidgetFormFilterInput(),
      'deleteable'       => new sfWidgetFormFilterInput(),
      'editable'         => new sfWidgetFormFilterInput(),
      'user_rights_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'UserRight')),
    ));

    $this->setValidators(array(
      'description'      => new sfValidatorPass(array('required' => false)),
      'group_by'         => new sfValidatorPass(array('required' => false)),
      'deleteable'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'editable'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_rights_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'UserRight', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_role_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUserRightsListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('UserRightUserRole.userright_id', $values);
  }

  public function getModelName()
  {
    return 'UserRole';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'description'      => 'Text',
      'group_by'         => 'Text',
      'deleteable'       => 'Number',
      'editable'         => 'Number',
      'user_rights_list' => 'ManyKey',
    );
  }
}