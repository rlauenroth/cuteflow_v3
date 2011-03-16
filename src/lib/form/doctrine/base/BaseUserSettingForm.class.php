<?php

/**
 * UserSetting form base class.
 *
 * @method UserSetting getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseUserSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                         => new sfWidgetFormInputHidden(),
      'language'                        => new sfWidgetFormInputText(),
      'markyellow'                      => new sfWidgetFormInputText(),
      'markred'                         => new sfWidgetFormInputText(),
      'markorange'                      => new sfWidgetFormInputText(),
      'refreshtime'                     => new sfWidgetFormInputText(),
      'displayeditem'                   => new sfWidgetFormInputText(),
      'durationtype'                    => new sfWidgetFormInputText(),
      'durationlength'                  => new sfWidgetFormInputText(),
      'emailformat'                     => new sfWidgetFormInputText(),
      'emailtype'                       => new sfWidgetFormInputText(),
      'circulationdefaultsortcolumn'    => new sfWidgetFormInputText(),
      'circulationdefaultsortdirection' => new sfWidgetFormInputText(),
      'theme'                           => new sfWidgetFormInputText(),
      'firstlogin'                      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'user_id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
      'language'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'markyellow'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'markred'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'markorange'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'refreshtime'                     => new sfValidatorInteger(array('required' => false)),
      'displayeditem'                   => new sfValidatorInteger(array('required' => false)),
      'durationtype'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'durationlength'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'emailformat'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'emailtype'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulationdefaultsortcolumn'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulationdefaultsortdirection' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'theme'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'firstlogin'                      => new sfValidatorInteger(array('required' => false)),
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
