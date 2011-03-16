<?php

/**
 * MailinglistSlot form base class.
 *
 * @method MailinglistSlot getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistSlotForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'mailinglistversion_id' => new sfWidgetFormInputText(),
      'slot_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'add_empty' => true)),
      'position'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'mailinglistversion_id' => new sfValidatorInteger(array('required' => false)),
      'slot_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'required' => false)),
      'position'              => new sfValidatorInteger(array('required' => false)),
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
