<?php

/**
 * Credential filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCredentialFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usermodule'         => new sfWidgetFormFilterInput(),
      'usergroup'          => new sfWidgetFormFilterInput(),
      'userright'          => new sfWidgetFormFilterInput(),
      'usermoduleposition' => new sfWidgetFormFilterInput(),
      'usergroupposition'  => new sfWidgetFormFilterInput(),
      'roles_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Role')),
    ));

    $this->setValidators(array(
      'usermodule'         => new sfValidatorPass(array('required' => false)),
      'usergroup'          => new sfValidatorPass(array('required' => false)),
      'userright'          => new sfValidatorPass(array('required' => false)),
      'usermoduleposition' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usergroupposition'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'roles_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Role', 'required' => false)),
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

    $query->leftJoin('r.CredentialRole CredentialRole')
          ->andWhereIn('CredentialRole.role_id', $values);
  }

  public function getModelName()
  {
    return 'Credential';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'usermodule'         => 'Text',
      'usergroup'          => 'Text',
      'userright'          => 'Text',
      'usermoduleposition' => 'Number',
      'usergroupposition'  => 'Number',
      'roles_list'         => 'ManyKey',
    );
  }
}
