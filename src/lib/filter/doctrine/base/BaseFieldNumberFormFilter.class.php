<?php

/**
 * FieldNumber filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFieldNumberFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'field_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'regex'          => new sfWidgetFormFilterInput(),
      'default_value'  => new sfWidgetFormFilterInput(),
      'combobox_value' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'field_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'regex'          => new sfValidatorPass(array('required' => false)),
      'default_value'  => new sfValidatorPass(array('required' => false)),
      'combobox_value' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('field_number_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FieldNumber';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'field_id'       => 'ForeignKey',
      'regex'          => 'Text',
      'default_value'  => 'Text',
      'combobox_value' => 'Text',
    );
  }
}
