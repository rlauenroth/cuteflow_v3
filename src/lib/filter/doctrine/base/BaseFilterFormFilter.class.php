<?php

/**
 * Filter filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseFilterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'filtername'                 => new sfWidgetFormFilterInput(),
      'name'                       => new sfWidgetFormFilterInput(),
      'sender_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'daysfrom'                   => new sfWidgetFormFilterInput(),
      'daysto'                     => new sfWidgetFormFilterInput(),
      'sendetfrom'                 => new sfWidgetFormFilterInput(),
      'sendetto'                   => new sfWidgetFormFilterInput(),
      'workflowprocessuser_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcessUser'), 'add_empty' => true)),
      'mailinglistversion_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'documenttemplateversion_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'filtername'                 => new sfValidatorPass(array('required' => false)),
      'name'                       => new sfValidatorPass(array('required' => false)),
      'sender_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'daysfrom'                   => new sfValidatorPass(array('required' => false)),
      'daysto'                     => new sfValidatorPass(array('required' => false)),
      'sendetfrom'                 => new sfValidatorPass(array('required' => false)),
      'sendetto'                   => new sfValidatorPass(array('required' => false)),
      'workflowprocessuser_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowProcessUser'), 'column' => 'id')),
      'mailinglistversion_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistVersion'), 'column' => 'id')),
      'documenttemplateversion_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('filter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Filter';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'filtername'                 => 'Text',
      'name'                       => 'Text',
      'sender_id'                  => 'ForeignKey',
      'daysfrom'                   => 'Text',
      'daysto'                     => 'Text',
      'sendetfrom'                 => 'Text',
      'sendetto'                   => 'Text',
      'workflowprocessuser_id'     => 'ForeignKey',
      'mailinglistversion_id'      => 'ForeignKey',
      'documenttemplateversion_id' => 'Number',
    );
  }
}
