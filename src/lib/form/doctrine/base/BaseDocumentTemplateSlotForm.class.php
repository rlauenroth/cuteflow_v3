<?php

/**
 * DocumentTemplateSlot form base class.
 *
 * @method DocumentTemplateSlot getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocumentTemplateSlotForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'document_template_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'add_empty' => true)),
      'name'                         => new sfWidgetFormInputText(),
      'send_to_all_receivers'        => new sfWidgetFormInputText(),
      'position'                     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'document_template_version_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'required' => false)),
      'name'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'send_to_all_receivers'        => new sfValidatorInteger(array('required' => false)),
      'position'                     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('document_template_slot[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentTemplateSlot';
  }

}
