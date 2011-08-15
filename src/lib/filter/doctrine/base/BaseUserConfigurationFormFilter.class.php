<?php

/**
 * UserConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'                            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
      'duration_type'                      => new sfWidgetFormFilterInput(),
      'duration_length'                    => new sfWidgetFormFilterInput(),
      'displayed_item'                     => new sfWidgetFormFilterInput(),
      'refresh_time'                       => new sfWidgetFormFilterInput(),
      'mark_yellow'                        => new sfWidgetFormFilterInput(),
      'mark_red'                           => new sfWidgetFormFilterInput(),
      'mark_orange'                        => new sfWidgetFormFilterInput(),
      'password'                           => new sfWidgetFormFilterInput(),
      'language'                           => new sfWidgetFormFilterInput(),
      'email_format'                       => new sfWidgetFormFilterInput(),
      'email_type'                         => new sfWidgetFormFilterInput(),
      'theme'                              => new sfWidgetFormFilterInput(),
      'circulation_default_sort_column'    => new sfWidgetFormFilterInput(),
      'circulation_default_sort_direction' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'role_id'                            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Role'), 'column' => 'id')),
      'duration_type'                      => new sfValidatorPass(array('required' => false)),
      'duration_length'                    => new sfValidatorPass(array('required' => false)),
      'displayed_item'                     => new sfValidatorPass(array('required' => false)),
      'refresh_time'                       => new sfValidatorPass(array('required' => false)),
      'mark_yellow'                        => new sfValidatorPass(array('required' => false)),
      'mark_red'                           => new sfValidatorPass(array('required' => false)),
      'mark_orange'                        => new sfValidatorPass(array('required' => false)),
      'password'                           => new sfValidatorPass(array('required' => false)),
      'language'                           => new sfValidatorPass(array('required' => false)),
      'email_format'                       => new sfValidatorPass(array('required' => false)),
      'email_type'                         => new sfValidatorPass(array('required' => false)),
      'theme'                              => new sfValidatorPass(array('required' => false)),
      'circulation_default_sort_column'    => new sfValidatorPass(array('required' => false)),
      'circulation_default_sort_direction' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_configuration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserConfiguration';
  }

  public function getFields()
  {
    return array(
      'id'                                 => 'Number',
      'role_id'                            => 'ForeignKey',
      'duration_type'                      => 'Text',
      'duration_length'                    => 'Text',
      'displayed_item'                     => 'Text',
      'refresh_time'                       => 'Text',
      'mark_yellow'                        => 'Text',
      'mark_red'                           => 'Text',
      'mark_orange'                        => 'Text',
      'password'                           => 'Text',
      'language'                           => 'Text',
      'email_format'                       => 'Text',
      'email_type'                         => 'Text',
      'theme'                              => 'Text',
      'circulation_default_sort_column'    => 'Text',
      'circulation_default_sort_direction' => 'Text',
    );
  }
}
