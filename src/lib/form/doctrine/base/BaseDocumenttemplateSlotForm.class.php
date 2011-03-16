<?php

/**
 * DocumenttemplateSlot form base class.
 *
 * @method DocumenttemplateSlot getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDocumenttemplateSlotForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'documenttemplateversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'add_empty' => true)),
      'name'                       => new sfWidgetFormInputText(),
      'sendtoallreceivers'         => new sfWidgetFormInputText(),
      'position'                   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'documenttemplateversion_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sendtoallreceivers'         => new sfValidatorInteger(array('required' => false)),
      'position'                   => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documenttemplate_slot[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumenttemplateSlot';
  }

}
