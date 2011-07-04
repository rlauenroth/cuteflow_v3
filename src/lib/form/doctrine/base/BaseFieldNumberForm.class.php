<?php

/**
 * FieldNumber form base class.
 *
 * @method FieldNumber getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFieldNumberForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'field_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'regex'          => new sfWidgetFormInputText(),
      'default_value'  => new sfWidgetFormInputText(),
      'combobox_value' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'field_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'required' => false)),
      'regex'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'default_value'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'combobox_value' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('field_number[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FieldNumber';
  }

}
