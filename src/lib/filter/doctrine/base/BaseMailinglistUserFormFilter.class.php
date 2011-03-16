<?php

/**
 * MailinglistUser filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglistslot_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistSlot'), 'add_empty' => true)),
      'user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'position'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mailinglistslot_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistSlot'), 'column' => 'id')),
      'user_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'position'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistUser';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'mailinglistslot_id' => 'ForeignKey',
      'user_id'            => 'ForeignKey',
      'position'           => 'Number',
    );
  }
}
