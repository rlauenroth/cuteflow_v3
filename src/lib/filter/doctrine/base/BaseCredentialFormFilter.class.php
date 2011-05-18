<?php

/**
 * Credential filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCredentialFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_module'          => new sfWidgetFormFilterInput(),
      'user_group'           => new sfWidgetFormFilterInput(),
      'user_right'           => new sfWidgetFormFilterInput(),
      'user_module_position' => new sfWidgetFormFilterInput(),
      'user_group_position'  => new sfWidgetFormFilterInput(),
      'roles_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
    ));

    $this->setValidators(array(
      'user_module'          => new sfValidatorPass(array('required' => false)),
      'user_group'           => new sfValidatorPass(array('required' => false)),
      'user_right'           => new sfValidatorPass(array('required' => false)),
      'user_module_position' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_group_position'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'roles_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('credential_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRolesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CredentialRole CredentialRole')
      ->andWhereIn('CredentialRole.role_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Credential';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'user_module'          => 'Text',
      'user_group'           => 'Text',
      'user_right'           => 'Text',
      'user_module_position' => 'Number',
      'user_group_position'  => 'Number',
      'roles_list'           => 'ManyKey',
    );
  }
}
