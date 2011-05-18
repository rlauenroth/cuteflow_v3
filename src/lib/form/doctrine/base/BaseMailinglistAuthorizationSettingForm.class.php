<?php

/**
 * MailinglistAuthorizationSetting form base class.
 *
 * @method MailinglistAuthorizationSetting getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailinglistAuthorizationSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'mailinglist_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'add_empty' => true)),
      'type'                   => new sfWidgetFormInputText(),
      'delete_workflow'        => new sfWidgetFormInputText(),
      'archive_workflow'       => new sfWidgetFormInputText(),
      'stop_new_workflow'      => new sfWidgetFormInputText(),
      'details_workflow'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mailinglist_version_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailinglistVersion'), 'required' => false)),
      'type'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'delete_workflow'        => new sfValidatorInteger(array('required' => false)),
      'archive_workflow'       => new sfValidatorInteger(array('required' => false)),
      'stop_new_workflow'      => new sfValidatorInteger(array('required' => false)),
      'details_workflow'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_authorization_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistAuthorizationSetting';
  }

}
