<?php

/**
 * UserConfiguration form base class.
 *
 * @method UserConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                 => new sfWidgetFormInputHidden(),
      'role_id'                            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
      'duration_type'                      => new sfWidgetFormInputText(),
      'duration_length'                    => new sfWidgetFormInputText(),
      'displayed_item'                     => new sfWidgetFormInputText(),
      'refresh_time'                       => new sfWidgetFormInputText(),
      'mark_yellow'                        => new sfWidgetFormInputText(),
      'mark_red'                           => new sfWidgetFormInputText(),
      'mark_orange'                        => new sfWidgetFormInputText(),
      'password'                           => new sfWidgetFormInputText(),
      'language'                           => new sfWidgetFormInputText(),
      'email_format'                       => new sfWidgetFormInputText(),
      'email_type'                         => new sfWidgetFormInputText(),
      'theme'                              => new sfWidgetFormInputText(),
      'circulation_default_sort_column'    => new sfWidgetFormInputText(),
      'circulation_default_sort_direction' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'role_id'                            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'required' => false)),
      'duration_type'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'duration_length'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'displayed_item'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'refresh_time'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mark_yellow'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mark_red'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mark_orange'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'password'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'language'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_format'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_type'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'theme'                              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulation_default_sort_column'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulation_default_sort_direction' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_configuration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserConfiguration';
  }

}
