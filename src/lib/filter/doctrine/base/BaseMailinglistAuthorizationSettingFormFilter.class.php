<?php

/**
 * MailinglistAuthorizationSetting filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistAuthorizationSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailinglistversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'type'                  => new sfWidgetFormFilterInput(),
      'deleteworkflow'        => new sfWidgetFormFilterInput(),
      'archiveworkflow'       => new sfWidgetFormFilterInput(),
      'stopneworkflow'        => new sfWidgetFormFilterInput(),
      'detailsworkflow'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mailinglistversion_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistVersion'), 'column' => 'id')),
      'type'                  => new sfValidatorPass(array('required' => false)),
      'deleteworkflow'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'archiveworkflow'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stopneworkflow'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'detailsworkflow'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_authorization_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistAuthorizationSetting';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'mailinglistversion_id' => 'ForeignKey',
      'type'                  => 'Text',
      'deleteworkflow'        => 'Number',
      'archiveworkflow'       => 'Number',
      'stopneworkflow'        => 'Number',
      'detailsworkflow'       => 'Number',
    );
  }
}
