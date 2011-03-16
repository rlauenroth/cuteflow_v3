<?php

/**
 * DocumenttemplateField form base class.
 *
 * @method DocumenttemplateField getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDocumenttemplateFieldForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'documenttemplateslot_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'add_empty' => true)),
      'field_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'position'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'documenttemplateslot_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateSlot'), 'required' => false)),
      'field_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'required' => false)),
      'position'                => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documenttemplate_field[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumenttemplateField';
  }

}
