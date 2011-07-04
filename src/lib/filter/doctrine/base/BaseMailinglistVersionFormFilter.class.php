<?php

/**
 * MailinglistVersion filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailinglistVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglist_template_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistTemplate'), 'add_empty' => true)),
      'document_template_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'add_empty' => true)),
      'send_to_all_slots_at_once'    => new sfWidgetFormFilterInput(),
      'version'                      => new sfWidgetFormFilterInput(),
      'active_version'               => new sfWidgetFormFilterInput(),
      'created_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'mailinglist_template_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistTemplate'), 'column' => 'id')),
      'document_template_version_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'column' => 'id')),
      'send_to_all_slots_at_once'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'version'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'active_version'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistVersion';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'mailinglist_template_id'      => 'ForeignKey',
      'document_template_version_id' => 'ForeignKey',
      'send_to_all_slots_at_once'    => 'Number',
      'version'                      => 'Number',
      'active_version'               => 'Number',
      'created_at'                   => 'Date',
      'updated_at'                   => 'Date',
    );
  }
}
