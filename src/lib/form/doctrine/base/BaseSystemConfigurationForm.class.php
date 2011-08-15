<?php

/**
 * SystemConfiguration form base class.
 *
 * @method SystemConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSystemConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'language'              => new sfWidgetFormInputText(),
      'show_position_in_mail' => new sfWidgetFormInputText(),
      'send_receiver_mail'    => new sfWidgetFormInputText(),
      'send_reminder_mail'    => new sfWidgetFormInputText(),
      'visible_slots'         => new sfWidgetFormInputText(),
      'color_of_north_region' => new sfWidgetFormInputText(),
      'individual_cronjob'    => new sfWidgetFormInputText(),
      'set_user_agent_type'   => new sfWidgetFormInputText(),
      'cronjob_days'          => new sfWidgetFormInputText(),
      'cronjob_from'          => new sfWidgetFormInputText(),
      'cronjob_to'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'language'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'show_position_in_mail' => new sfValidatorInteger(array('required' => false)),
      'send_receiver_mail'    => new sfValidatorInteger(array('required' => false)),
      'send_reminder_mail'    => new sfValidatorInteger(array('required' => false)),
      'visible_slots'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'color_of_north_region' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'individual_cronjob'    => new sfValidatorInteger(array('required' => false)),
      'set_user_agent_type'   => new sfValidatorInteger(array('required' => false)),
      'cronjob_days'          => new sfValidatorInteger(array('required' => false)),
      'cronjob_from'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cronjob_to'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_configuration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemConfiguration';
  }

}
