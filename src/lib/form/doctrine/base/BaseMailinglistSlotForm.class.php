<?php

/**
 * MailinglistSlot form base class.
 *
 * @method MailinglistSlot getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailinglistSlotForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'mailinglist_version_id' => new sfWidgetFormInputText(),
      'slot_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateSlot'), 'add_empty' => true)),
      'position'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mailinglist_version_id' => new sfValidatorInteger(array('required' => false)),
      'slot_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateSlot'), 'required' => false)),
      'position'               => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_slot[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistSlot';
  }

}
