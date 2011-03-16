<?php

/**
 * DocumenttemplateSlot filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDocumenttemplateSlotFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'documenttemplateversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'add_empty' => true)),
      'name'                       => new sfWidgetFormFilterInput(),
      'sendtoallreceivers'         => new sfWidgetFormFilterInput(),
      'position'                   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'documenttemplateversion_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'column' => 'id')),
      'name'                       => new sfValidatorPass(array('required' => false)),
      'sendtoallreceivers'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'position'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('documenttemplate_slot_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DocumenttemplateSlot';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'documenttemplateversion_id' => 'ForeignKey',
      'name'                       => 'Text',
      'sendtoallreceivers'         => 'Number',
      'position'                   => 'Number',
    );
  }
}
