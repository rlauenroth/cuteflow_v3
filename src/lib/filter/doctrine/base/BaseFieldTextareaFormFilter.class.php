<?php

/**
 * FieldTextarea filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFieldTextareaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'field_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'content_type' => new sfWidgetFormFilterInput(),
      'content'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'field_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'content_type' => new sfValidatorPass(array('required' => false)),
      'content'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('field_textarea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FieldTextarea';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'field_id'     => 'ForeignKey',
      'content_type' => 'Text',
      'content'      => 'Text',
    );
  }
}
