<?php

/**
 * MailinglistSlot filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailinglistSlotFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglist_version_id' => new sfWidgetFormFilterInput(),
      'slot_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateSlot'), 'add_empty' => true)),
      'position'               => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mailinglist_version_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumentTemplateSlot'), 'column' => 'id')),
      'position'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_slot_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistSlot';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'mailinglist_version_id' => 'Number',
      'slot_id'                => 'ForeignKey',
      'position'               => 'Number',
    );
  }
}
