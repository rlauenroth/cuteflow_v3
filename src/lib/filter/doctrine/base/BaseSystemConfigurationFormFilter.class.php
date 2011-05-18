<?php

/**
 * SystemConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSystemConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language'              => new sfWidgetFormFilterInput(),
      'show_position_in_mail' => new sfWidgetFormFilterInput(),
      'send_receiver_mail'    => new sfWidgetFormFilterInput(),
      'send_reminde_rmail'    => new sfWidgetFormFilterInput(),
      'visible_slots'         => new sfWidgetFormFilterInput(),
      'color_of_north_region' => new sfWidgetFormFilterInput(),
      'individual_cronjob'    => new sfWidgetFormFilterInput(),
      'set_user_agent_type'   => new sfWidgetFormFilterInput(),
      'cronjob_days'          => new sfWidgetFormFilterInput(),
      'cronjob_from'          => new sfWidgetFormFilterInput(),
      'cronjob_to'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'language'              => new sfValidatorPass(array('required' => false)),
      'show_position_in_mail' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'send_receiver_mail'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'send_reminde_rmail'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'visible_slots'         => new sfValidatorPass(array('required' => false)),
      'color_of_north_region' => new sfValidatorPass(array('required' => false)),
      'individual_cronjob'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'set_user_agent_type'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cronjob_days'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cronjob_from'          => new sfValidatorPass(array('required' => false)),
      'cronjob_to'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'language'              => 'Text',
      'show_position_in_mail' => 'Number',
      'send_receiver_mail'    => 'Number',
      'send_reminde_rmail'    => 'Number',
      'visible_slots'         => 'Text',
      'color_of_north_region' => 'Text',
      'individual_cronjob'    => 'Number',
      'set_user_agent_type'   => 'Number',
      'cronjob_days'          => 'Number',
      'cronjob_from'          => 'Text',
      'cronjob_to'            => 'Text',
    );
  }
}
