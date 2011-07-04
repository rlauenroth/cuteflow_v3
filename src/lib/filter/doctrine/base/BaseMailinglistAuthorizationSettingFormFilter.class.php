<?php

/**
 * MailinglistAuthorizationSetting filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailinglistAuthorizationSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglist_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'type'                   => new sfWidgetFormFilterInput(),
      'delete_workflow'        => new sfWidgetFormFilterInput(),
      'archive_workflow'       => new sfWidgetFormFilterInput(),
      'stop_new_workflow'      => new sfWidgetFormFilterInput(),
      'details_workflow'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mailinglist_version_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistVersion'), 'column' => 'id')),
      'type'                   => new sfValidatorPass(array('required' => false)),
      'delete_workflow'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archive_workflow'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stop_new_workflow'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'details_workflow'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_authorization_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistAuthorizationSetting';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'mailinglist_version_id' => 'ForeignKey',
      'type'                   => 'Text',
      'delete_workflow'        => 'Number',
      'archive_workflow'       => 'Number',
      'stop_new_workflow'      => 'Number',
      'details_workflow'       => 'Number',
    );
  }
}
