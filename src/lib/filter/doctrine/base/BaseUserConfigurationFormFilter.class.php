<?php

/**
 * UserConfiguration filter form base class.
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseUserConfigurationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'role_id'                         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role'), 'add_empty' => true)),
      'durationtype'                    => new sfWidgetFormFilterInput(),
      'durationlength'                  => new sfWidgetFormFilterInput(),
      'displayeditem'                   => new sfWidgetFormFilterInput(),
      'refreshtime'                     => new sfWidgetFormFilterInput(),
      'markyellow'                      => new sfWidgetFormFilterInput(),
      'markred'                         => new sfWidgetFormFilterInput(),
      'markorange'                      => new sfWidgetFormFilterInput(),
      'password'                        => new sfWidgetFormFilterInput(),
      'language'                        => new sfWidgetFormFilterInput(),
      'emailformat'                     => new sfWidgetFormFilterInput(),
      'emailtype'                       => new sfWidgetFormFilterInput(),
      'theme'                           => new sfWidgetFormFilterInput(),
      'circulationdefaultsortcolumn'    => new sfWidgetFormFilterInput(),
      'circulationdefaultsortdirection' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'role_id'                         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Role'), 'column' => 'id')),
      'durationtype'                    => new sfValidatorPass(array('required' => false)),
      'durationlength'                  => new sfValidatorPass(array('required' => false)),
      'displayeditem'                   => new sfValidatorPass(array('required' => false)),
      'refreshtime'                     => new sfValidatorPass(array('required' => false)),
      'markyellow'                      => new sfValidatorPass(array('required' => false)),
      'markred'                         => new sfValidatorPass(array('required' => false)),
      'markorange'                      => new sfValidatorPass(array('required' => false)),
      'password'                        => new sfValidatorPass(array('required' => false)),
      'language'                        => new sfValidatorPass(array('required' => false)),
      'emailformat'                     => new sfValidatorPass(array('required' => false)),
      'emailtype'                       => new sfValidatorPass(array('required' => false)),
      'theme'                           => new sfValidatorPass(array('required' => false)),
      'circulationdefaultsortcolumn'    => new sfValidatorPass(array('required' => false)),
      'circulationdefaultsortdirection' => new sfValidatorPass(array('required' => false)),
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
      'id'                              => 'Number',
      'role_id'                         => 'ForeignKey',
      'durationtype'                    => 'Text',
      'durationlength'                  => 'Text',
      'displayeditem'                   => 'Text',
      'refreshtime'                     => 'Text',
      'markyellow'                      => 'Text',
      'markred'                         => 'Text',
      'markorange'                      => 'Text',
      'password'                        => 'Text',
      'language'                        => 'Text',
      'emailformat'                     => 'Text',
      'emailtype'                       => 'Text',
      'theme'                           => 'Text',
      'circulationdefaultsortcolumn'    => 'Text',
      'circulationdefaultsortdirection' => 'Text',
    );
  }
}
