<?php

/**
 * MailinglistSlot filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistSlotFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglistversion_id' => new sfWidgetFormFilterInput(),
      'slot_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'add_empty' => true)),
      'position'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mailinglistversion_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'slot_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'column' => 'id')),
      'position'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'                    => 'Number',
      'mailinglistversion_id' => 'Number',
      'slot_id'               => 'ForeignKey',
      'position'              => 'Number',
    );
  }
}
