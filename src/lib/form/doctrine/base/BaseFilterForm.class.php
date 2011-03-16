<?php

/**
 * Filter form base class.
 *
 * @method Filter getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseFilterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'filtername'                 => new sfWidgetFormInputText(),
      'name'                       => new sfWidgetFormInputText(),
      'sender_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'add_empty' => true)),
      'daysfrom'                   => new sfWidgetFormInputText(),
      'daysto'                     => new sfWidgetFormInputText(),
      'sendetfrom'                 => new sfWidgetFormInputText(),
      'sendetto'                   => new sfWidgetFormInputText(),
      'workflowprocessuser_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcessUser'), 'add_empty' => true)),
      'mailinglistversion_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'documenttemplateversion_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'filtername'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sender_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserLogin'), 'required' => false)),
      'daysfrom'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'daysto'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sendetfrom'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sendetto'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'workflowprocessuser_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WorkflowProcessUser'), 'required' => false)),
      'mailinglistversion_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'required' => false)),
      'documenttemplateversion_id' => new sfValidatorInteger(array('required' => false)),
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
