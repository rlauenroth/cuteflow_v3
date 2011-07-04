<?php

/**
 * UserSetting filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language'                           => new sfWidgetFormFilterInput(),
      'mark_yellow'                        => new sfWidgetFormFilterInput(),
      'mark_red'                           => new sfWidgetFormFilterInput(),
      'mark_orange'                        => new sfWidgetFormFilterInput(),
      'refresh_time'                       => new sfWidgetFormFilterInput(),
      'displayed_item'                     => new sfWidgetFormFilterInput(),
      'duration_type'                      => new sfWidgetFormFilterInput(),
      'duration_length'                    => new sfWidgetFormFilterInput(),
      'email_format'                       => new sfWidgetFormFilterInput(),
      'email_type'                         => new sfWidgetFormFilterInput(),
      'circulation_default_sort_column'    => new sfWidgetFormFilterInput(),
      'circulation_default_sort_direction' => new sfWidgetFormFilterInput(),
      'theme'                              => new sfWidgetFormFilterInput(),
      'firstlogin'                         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'language'                           => new sfValidatorPass(array('required' => false)),
      'mark_yellow'                        => new sfValidatorPass(array('required' => false)),
      'mark_red'                           => new sfValidatorPass(array('required' => false)),
      'mark_orange'                        => new sfValidatorPass(array('required' => false)),
      'refresh_time'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'displayed_item'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'duration_type'                      => new sfValidatorPass(array('required' => false)),
      'duration_length'                    => new sfValidatorPass(array('required' => false)),
      'email_format'                       => new sfValidatorPass(array('required' => false)),
      'email_type'                         => new sfValidatorPass(array('required' => false)),
      'circulation_default_sort_column'    => new sfValidatorPass(array('required' => false)),
      'circulation_default_sort_direction' => new sfValidatorPass(array('required' => false)),
      'theme'                              => new sfValidatorPass(array('required' => false)),
      'firstlogin'                         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('user_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserSetting';
  }

  public function getFields()
  {
    return array(
      'user_id'                            => 'Number',
      'language'                           => 'Text',
      'mark_yellow'                        => 'Text',
      'mark_red'                           => 'Text',
      'mark_orange'                        => 'Text',
      'refresh_time'                       => 'Number',
      'displayed_item'                     => 'Number',
      'duration_type'                      => 'Text',
      'duration_length'                    => 'Text',
      'email_format'                       => 'Text',
      'email_type'                         => 'Text',
      'circulation_default_sort_column'    => 'Text',
      'circulation_default_sort_direction' => 'Text',
      'theme'                              => 'Text',
      'firstlogin'                         => 'Number',
    );
  }
}
