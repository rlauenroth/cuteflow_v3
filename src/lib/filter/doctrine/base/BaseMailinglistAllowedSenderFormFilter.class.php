<?php

/**
 * MailinglistAllowedSender filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailinglistAllowedSenderFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglist_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'user_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'position'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mailinglist_version_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistVersion'), 'column' => 'id')),
      'user_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'position'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_allowed_sender_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistAllowedSender';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'mailinglist_version_id' => 'ForeignKey',
      'user_id'                => 'ForeignKey',
      'position'               => 'Number',
    );
  }
}
