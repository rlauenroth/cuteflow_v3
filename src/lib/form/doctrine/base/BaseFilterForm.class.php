<?php

/**
 * Filter form base class.
 *
 * @method Filter getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFilterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'filter_name'                  => new sfWidgetFormInputText(),
      'name'                         => new sfWidgetFormInputText(),
      'sender_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'days_from'                    => new sfWidgetFormInputText(),
      'days_to'                      => new sfWidgetFormInputText(),
      'sendet_from'                  => new sfWidgetFormInputText(),
      'sendet_to'                    => new sfWidgetFormInputText(),
      'workflow_process_user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcessUser'), 'add_empty' => true)),
      'mailinglist_version_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'document_template_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'filter_name'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sender_id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'required' => false)),
      'days_from'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'days_to'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sendet_from'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sendet_to'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'workflow_process_user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcessUser'), 'required' => false)),
      'mailinglist_version_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'required' => false)),
      'document_template_version_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumentTemplateVersion'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('filter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Filter';
  }

}
