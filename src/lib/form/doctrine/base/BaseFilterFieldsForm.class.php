<?php

/**
 * FilterFields form base class.
 *
 * @method FilterFields getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseFilterFieldsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'filter_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Filter'), 'add_empty' => true)),
      'field_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'operator'  => new sfWidgetFormInputText(),
      'value'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'filter_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Filter'), 'required' => false)),
      'field_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'required' => false)),
      'operator'  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'value'     => new sfValidatorString(array('max_length' => 200, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('filter_fields[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FilterFields';
  }

}
