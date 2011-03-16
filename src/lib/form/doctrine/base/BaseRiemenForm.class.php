<?php

/**
 * Riemen form base class.
 *
 * @package    form
 * @subpackage riemen
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseRiemenForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'userrole_id'  => new sfWidgetFormInputHidden(),
      'userright_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'userrole_id'  => new sfValidatorDoctrineChoice(array('model' => 'Riemen', 'column' => 'userrole_id', 'required' => false)),
      'userright_id' => new sfValidatorDoctrineChoice(array('model' => 'Riemen', 'column' => 'userright_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('riemen[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Riemen';
  }

}
