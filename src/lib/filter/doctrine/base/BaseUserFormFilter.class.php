<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * User filter form base class.
 *
 * @package    filters
 * @subpackage User *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'Role', 'add_empty' => true)),
      'firstname'    => new sfWidgetFormFilterInput(),
      'lastname'     => new sfWidgetFormFilterInput(),
      'email'        => new sfWidgetFormFilterInput(),
      'username'     => new sfWidgetFormFilterInput(),
      'password'     => new sfWidgetFormFilterInput(),
      'street'       => new sfWidgetFormFilterInput(),
      'zip'          => new sfWidgetFormFilterInput(),
      'city'         => new sfWidgetFormFilterInput(),
      'phone1'       => new sfWidgetFormFilterInput(),
      'phone2'       => new sfWidgetFormFilterInput(),
      'mobile'       => new sfWidgetFormFilterInput(),
      'fax'          => new sfWidgetFormFilterInput(),
      'organisation' => new sfWidgetFormFilterInput(),
      'department'   => new sfWidgetFormFilterInput(),
      'burdenCenter' => new sfWidgetFormFilterInput(),
      'emailFormat'  => new sfWidgetFormFilterInput(),
      'comment'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'role_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Role', 'column' => 'id')),
      'firstname'    => new sfValidatorPass(array('required' => false)),
      'lastname'     => new sfValidatorPass(array('required' => false)),
      'email'        => new sfValidatorPass(array('required' => false)),
      'username'     => new sfValidatorPass(array('required' => false)),
      'password'     => new sfValidatorPass(array('required' => false)),
      'street'       => new sfValidatorPass(array('required' => false)),
      'zip'          => new sfValidatorPass(array('required' => false)),
      'city'         => new sfValidatorPass(array('required' => false)),
      'phone1'       => new sfValidatorPass(array('required' => false)),
      'phone2'       => new sfValidatorPass(array('required' => false)),
      'mobile'       => new sfValidatorPass(array('required' => false)),
      'fax'          => new sfValidatorPass(array('required' => false)),
      'organisation' => new sfValidatorPass(array('required' => false)),
      'department'   => new sfValidatorPass(array('required' => false)),
      'burdenCenter' => new sfValidatorPass(array('required' => false)),
      'emailFormat'  => new sfValidatorPass(array('required' => false)),
      'comment'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'role_id'      => 'ForeignKey',
      'firstname'    => 'Text',
      'lastname'     => 'Text',
      'email'        => 'Text',
      'username'     => 'Text',
      'password'     => 'Text',
      'street'       => 'Text',
      'zip'          => 'Text',
      'city'         => 'Text',
      'phone1'       => 'Text',
      'phone2'       => 'Text',
      'mobile'       => 'Text',
      'fax'          => 'Text',
      'organisation' => 'Text',
      'department'   => 'Text',
      'burdenCenter' => 'Text',
      'emailFormat'  => 'Text',
      'comment'      => 'Text',
    );
  }
}