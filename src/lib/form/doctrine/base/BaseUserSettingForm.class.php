<?php

/**
 * UserSetting form base class.
 *
 * @method UserSetting getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                            => new sfWidgetFormInputHidden(),
      'language'                           => new sfWidgetFormInputText(),
      'mark_yellow'                        => new sfWidgetFormInputText(),
      'mark_red'                           => new sfWidgetFormInputText(),
      'mark_orange'                        => new sfWidgetFormInputText(),
      'refresh_time'                       => new sfWidgetFormInputText(),
      'displayed_item'                     => new sfWidgetFormInputText(),
      'duration_type'                      => new sfWidgetFormInputText(),
      'duration_length'                    => new sfWidgetFormInputText(),
      'email_format'                       => new sfWidgetFormInputText(),
      'email_type'                         => new sfWidgetFormInputText(),
      'circulation_default_sort_column'    => new sfWidgetFormInputText(),
      'circulation_default_sort_direction' => new sfWidgetFormInputText(),
      'theme'                              => new sfWidgetFormInputText(),
      'firstlogin'                         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'user_id'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'language'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mark_yellow'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mark_red'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mark_orange'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'refresh_time'                       => new sfValidatorInteger(array('required' => false)),
      'displayed_item'                     => new sfValidatorInteger(array('required' => false)),
      'duration_type'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'duration_length'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_format'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_type'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulation_default_sort_column'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulation_default_sort_direction' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'theme'                              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'firstlogin'                         => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserSetting';
  }

}
