<?php

/**
 * FilterField filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseFilterFieldFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'filter_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Filter'), 'add_empty' => true)),
      'field_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'operator'  => new sfWidgetFormFilterInput(),
      'value'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'filter_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Filter'), 'column' => 'id')),
      'field_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'operator'  => new sfValidatorPass(array('required' => false)),
      'value'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('filter_field_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FilterField';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'filter_id' => 'ForeignKey',
      'field_id'  => 'ForeignKey',
      'operator'  => 'Text',
      'value'     => 'Text',
    );
  }
}
