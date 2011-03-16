<?php

/**
 * UserSetting filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseUserSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language'                        => new sfWidgetFormFilterInput(),
      'markyellow'                      => new sfWidgetFormFilterInput(),
      'markred'                         => new sfWidgetFormFilterInput(),
      'markorange'                      => new sfWidgetFormFilterInput(),
      'refreshtime'                     => new sfWidgetFormFilterInput(),
      'displayeditem'                   => new sfWidgetFormFilterInput(),
      'durationtype'                    => new sfWidgetFormFilterInput(),
      'durationlength'                  => new sfWidgetFormFilterInput(),
      'emailformat'                     => new sfWidgetFormFilterInput(),
      'emailtype'                       => new sfWidgetFormFilterInput(),
      'circulationdefaultsortcolumn'    => new sfWidgetFormFilterInput(),
      'circulationdefaultsortdirection' => new sfWidgetFormFilterInput(),
      'theme'                           => new sfWidgetFormFilterInput(),
      'firstlogin'                      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'language'                        => new sfValidatorPass(array('required' => false)),
      'markyellow'                      => new sfValidatorPass(array('required' => false)),
      'markred'                         => new sfValidatorPass(array('required' => false)),
      'markorange'                      => new sfValidatorPass(array('required' => false)),
      'refreshtime'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'displayeditem'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'durationtype'                    => new sfValidatorPass(array('required' => false)),
      'durationlength'                  => new sfValidatorPass(array('required' => false)),
      'emailformat'                     => new sfValidatorPass(array('required' => false)),
      'emailtype'                       => new sfValidatorPass(array('required' => false)),
      'circulationdefaultsortcolumn'    => new sfValidatorPass(array('required' => false)),
      'circulationdefaultsortdirection' => new sfValidatorPass(array('required' => false)),
      'theme'                           => new sfValidatorPass(array('required' => false)),
      'firstlogin'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'user_id'                         => 'Number',
      'language'                        => 'Text',
      'markyellow'                      => 'Text',
      'markred'                         => 'Text',
      'markorange'                      => 'Text',
      'refreshtime'                     => 'Number',
      'displayeditem'                   => 'Number',
      'durationtype'                    => 'Text',
      'durationlength'                  => 'Text',
      'emailformat'                     => 'Text',
      'emailtype'                       => 'Text',
      'circulationdefaultsortcolumn'    => 'Text',
      'circulationdefaultsortdirection' => 'Text',
      'theme'                           => 'Text',
      'firstlogin'                      => 'Number',
    );
  }
}
