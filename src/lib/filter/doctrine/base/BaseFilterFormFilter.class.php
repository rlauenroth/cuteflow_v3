<?php

/**
 * Filter filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFilterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'filter_name'                  => new sfWidgetFormFilterInput(),
      'name'                         => new sfWidgetFormFilterInput(),
      'sender_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'days_from'                    => new sfWidgetFormFilterInput(),
      'days_to'                      => new sfWidgetFormFilterInput(),
      'sendet_from'                  => new sfWidgetFormFilterInput(),
      'sendet_to'                    => new sfWidgetFormFilterInput(),
      'workflow_process_user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcessUser'), 'add_empty' => true)),
      'mailinglist_version_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'document_template_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'filter_name'                  => new sfValidatorPass(array('required' => false)),
      'name'                         => new sfValidatorPass(array('required' => false)),
      'sender_id'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserLogin'), 'column' => 'id')),
      'days_from'                    => new sfValidatorPass(array('required' => false)),
      'days_to'                      => new sfValidatorPass(array('required' => false)),
      'sendet_from'                  => new sfValidatorPass(array('required' => false)),
      'sendet_to'                    => new sfValidatorPass(array('required' => false)),
      'workflow_process_user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WorkflowProcessUser'), 'column' => 'id')),
      'mailinglist_version_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MailinglistVersion'), 'column' => 'id')),
      'document_template_version_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'column' => 'id')),
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
      'id'                           => 'Number',
      'filter_name'                  => 'Text',
      'name'                         => 'Text',
      'sender_id'                    => 'ForeignKey',
      'days_from'                    => 'Text',
      'days_to'                      => 'Text',
      'sendet_from'                  => 'Text',
      'sendet_to'                    => 'Text',
      'workflow_process_user_id'     => 'ForeignKey',
      'mailinglist_version_id'       => 'ForeignKey',
      'document_template_version_id' => 'ForeignKey',
    );
  }
}
