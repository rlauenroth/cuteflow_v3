<?php

/**
 * UserData filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserDataFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'firstname'    => new sfWidgetFormFilterInput(),
      'lastname'     => new sfWidgetFormFilterInput(),
      'street'       => new sfWidgetFormFilterInput(),
      'zip'          => new sfWidgetFormFilterInput(),
      'city'         => new sfWidgetFormFilterInput(),
      'country'      => new sfWidgetFormFilterInput(),
      'phone1'       => new sfWidgetFormFilterInput(),
      'phone2'       => new sfWidgetFormFilterInput(),
      'mobile'       => new sfWidgetFormFilterInput(),
      'fax'          => new sfWidgetFormFilterInput(),
      'organisation' => new sfWidgetFormFilterInput(),
      'department'   => new sfWidgetFormFilterInput(),
      'burdencenter' => new sfWidgetFormFilterInput(),
      'comment'      => new sfWidgetFormFilterInput(),
      'last_action'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'firstname'    => new sfValidatorPass(array('required' => false)),
      'lastname'     => new sfValidatorPass(array('required' => false)),
      'street'       => new sfValidatorPass(array('required' => false)),
      'zip'          => new sfValidatorPass(array('required' => false)),
      'city'         => new sfValidatorPass(array('required' => false)),
      'country'      => new sfValidatorPass(array('required' => false)),
      'phone1'       => new sfValidatorPass(array('required' => false)),
      'phone2'       => new sfValidatorPass(array('required' => false)),
      'mobile'       => new sfValidatorPass(array('required' => false)),
      'fax'          => new sfValidatorPass(array('required' => false)),
      'organisation' => new sfValidatorPass(array('required' => false)),
      'department'   => new sfValidatorPass(array('required' => false)),
      'burdencenter' => new sfValidatorPass(array('required' => false)),
      'comment'      => new sfValidatorPass(array('required' => false)),
      'last_action'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_data_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserData';
  }

  public function getFields()
  {
    return array(
      'user_id'      => 'Number',
      'firstname'    => 'Text',
      'lastname'     => 'Text',
      'street'       => 'Text',
      'zip'          => 'Text',
      'city'         => 'Text',
      'country'      => 'Text',
      'phone1'       => 'Text',
      'phone2'       => 'Text',
      'mobile'       => 'Text',
      'fax'          => 'Text',
      'organisation' => 'Text',
      'department'   => 'Text',
      'burdencenter' => 'Text',
      'comment'      => 'Text',
      'last_action'  => 'Text',
    );
  }
}
