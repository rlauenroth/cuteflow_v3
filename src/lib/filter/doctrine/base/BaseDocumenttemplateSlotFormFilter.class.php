<?php

/**
 * DocumentTemplateSlot filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDocumentTemplateSlotFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'document_template_version_id' => new sfWidgetFormFilterInput(),
      'name'                         => new sfWidgetFormFilterInput(),
      'send_to_all_receivers'        => new sfWidgetFormFilterInput(),
      'position'                     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'document_template_version_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'name'                         => new sfValidatorPass(array('required' => false)),
      'send_to_all_receivers'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('document_template_slot_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumentTemplateSlot';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'document_template_version_id' => 'Number',
      'name'                         => 'Text',
      'send_to_all_receivers'        => 'Number',
      'position'                     => 'Number',
    );
  }
}
