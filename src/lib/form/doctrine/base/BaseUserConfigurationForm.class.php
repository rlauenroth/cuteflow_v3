<?php

/**
 * UserConfiguration form base class.
 *
 * @method UserConfiguration getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseUserConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                              => new sfWidgetFormInputHidden(),
      'role_id'                         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
      'durationtype'                    => new sfWidgetFormInputText(),
      'durationlength'                  => new sfWidgetFormInputText(),
      'displayeditem'                   => new sfWidgetFormInputText(),
      'refreshtime'                     => new sfWidgetFormInputText(),
      'markyellow'                      => new sfWidgetFormInputText(),
      'markred'                         => new sfWidgetFormInputText(),
      'markorange'                      => new sfWidgetFormInputText(),
      'password'                        => new sfWidgetFormInputText(),
      'language'                        => new sfWidgetFormInputText(),
      'emailformat'                     => new sfWidgetFormInputText(),
      'emailtype'                       => new sfWidgetFormInputText(),
      'theme'                           => new sfWidgetFormInputText(),
      'circulationdefaultsortcolumn'    => new sfWidgetFormInputText(),
      'circulationdefaultsortdirection' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'role_id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'required' => false)),
      'durationtype'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'durationlength'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'displayeditem'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'refreshtime'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'markyellow'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'markred'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'markorange'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'password'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'language'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'emailformat'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'emailtype'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'theme'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulationdefaultsortcolumn'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'circulationdefaultsortdirection' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
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
