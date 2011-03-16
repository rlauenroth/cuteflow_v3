<?php

/**
 * UserData form base class.
 *
 * @method UserData getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseUserDataForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'      => new sfWidgetFormInputHidden(),
      'firstname'    => new sfWidgetFormInputText(),
      'lastname'     => new sfWidgetFormInputText(),
      'street'       => new sfWidgetFormInputText(),
      'zip'          => new sfWidgetFormInputText(),
      'city'         => new sfWidgetFormInputText(),
      'country'      => new sfWidgetFormInputText(),
      'phone1'       => new sfWidgetFormInputText(),
      'phone2'       => new sfWidgetFormInputText(),
      'mobile'       => new sfWidgetFormInputText(),
      'fax'          => new sfWidgetFormInputText(),
      'organisation' => new sfWidgetFormInputText(),
      'department'   => new sfWidgetFormInputText(),
      'burdencenter' => new sfWidgetFormInputText(),
      'comment'      => new sfWidgetFormTextarea(),
      'lastaction'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
      'firstname'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'lastname'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'street'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zip'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone1'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone2'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mobile'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'organisation' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'department'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'burdencenter' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'comment'      => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'lastaction'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_data[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserData';
  }

}
