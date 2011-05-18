<?php

/**
 * FieldRadiogroup form base class.
 *
 * @method FieldRadiogroup getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFieldRadiogroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'field_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'value'     => new sfWidgetFormInputText(),
      'is_active' => new sfWidgetFormInputText(),
      'position'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'field_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'required' => false)),
      'value'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active' => new sfValidatorInteger(array('required' => false)),
      'position'  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('field_radiogroup[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FieldRadiogroup';
  }

}
