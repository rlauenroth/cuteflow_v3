<?php

/**
 * MailinglistVersion form base class.
 *
 * @method MailinglistVersion getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'mailinglisttemplate_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistTemplate'), 'add_empty' => true)),
      'documenttemplateversion_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'add_empty' => true)),
      'sendtoallslotsatonce'       => new sfWidgetFormInputText(),
      'version'                    => new sfWidgetFormInputText(),
      'activeversion'              => new sfWidgetFormInputText(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'mailinglisttemplate_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistTemplate'), 'required' => false)),
      'documenttemplateversion_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateVersion'), 'required' => false)),
      'sendtoallslotsatonce'       => new sfValidatorInteger(array('required' => false)),
      'version'                    => new sfValidatorInteger(array('required' => false)),
      'activeversion'              => new sfValidatorInteger(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistVersion';
  }

}
