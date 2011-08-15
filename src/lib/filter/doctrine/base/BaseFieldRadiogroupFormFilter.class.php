<?php

/**
 * FieldRadiogroup filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFieldRadiogroupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'field_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'value'     => new sfWidgetFormFilterInput(),
      'is_active' => new sfWidgetFormFilterInput(),
      'position'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'field_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'value'     => new sfValidatorPass(array('required' => false)),
      'is_active' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('field_radiogroup_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FieldRadiogroup';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'field_id'  => 'ForeignKey',
      'value'     => 'Text',
      'is_active' => 'Number',
      'position'  => 'Number',
    );
  }
}
