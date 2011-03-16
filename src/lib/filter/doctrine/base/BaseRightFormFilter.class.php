<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Right filter form base class.
 *
 * @package    filters
 * @subpackage Right *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseRightFormFilter extends BaseFormFilterDoctrine
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
    ));

    $this->widgetSchema->setNameFormat('right_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Right';
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
    );
  }
}