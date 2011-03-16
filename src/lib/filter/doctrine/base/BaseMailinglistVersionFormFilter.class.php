<?php

/**
 * MailinglistVersion filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistVersionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglisttemplate_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistTemplate'), 'add_empty' => true)),
      'documenttemplateversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'add_empty' => true)),
      'sendtoallslotsatonce'       => new sfWidgetFormFilterInput(),
      'version'                    => new sfWidgetFormFilterInput(),
      'activeversion'              => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'mailinglisttemplate_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistTemplate'), 'column' => 'id')),
      'documenttemplateversion_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'column' => 'id')),
      'sendtoallslotsatonce'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'version'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activeversion'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'                         => 'Number',
      'mailinglisttemplate_id'     => 'ForeignKey',
      'documenttemplateversion_id' => 'ForeignKey',
      'sendtoallslotsatonce'       => 'Number',
      'version'                    => 'Number',
      'activeversion'              => 'Number',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
    );
  }
}
