<?php

/**
 * FieldDate filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseFieldDateFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'field_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'regex'        => new sfWidgetFormFilterInput(),
      'defaultvalue' => new sfWidgetFormFilterInput(),
      'dateformat'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'field_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'regex'        => new sfValidatorPass(array('required' => false)),
      'defaultvalue' => new sfValidatorPass(array('required' => false)),
      'dateformat'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('field_date_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FieldDate';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'field_id'     => 'ForeignKey',
      'regex'        => 'Text',
      'defaultvalue' => 'Text',
      'dateformat'   => 'Text',
    );
  }
}
