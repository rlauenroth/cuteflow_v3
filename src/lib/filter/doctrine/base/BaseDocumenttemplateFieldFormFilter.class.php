<?php

/**
 * DocumenttemplateField filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDocumenttemplateFieldFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'document_template_slot_id' => new sfWidgetFormFilterInput(),
      'field_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Field'), 'add_empty' => true)),
      'position'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'document_template_slot_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'field_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Field'), 'column' => 'id')),
      'position'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('documenttemplate_field_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumenttemplateField';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'document_template_slot_id' => 'Number',
      'field_id'                  => 'ForeignKey',
      'position'                  => 'Number',
    );
  }
}
