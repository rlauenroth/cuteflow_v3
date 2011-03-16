<?php

/**
 * MailinglistTemplate form base class.
 *
 * @method MailinglistTemplate getObject() Returns the current form's model object
 *
 * @package    cf
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseMailinglistTemplateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'documenttemplatetemplate_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateTemplate'), 'add_empty' => true)),
      'name'                        => new sfWidgetFormInputText(),
      'isactive'                    => new sfWidgetFormInputText(),
      'deleted_at'                  => new sfWidgetFormDateTime(),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'documenttemplatetemplate_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocumenttemplateTemplate'), 'required' => false)),
      'name'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'isactive'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deleted_at'                  => new sfValidatorDateTime(array('required' => false)),
      'created_at'                  => new sfValidatorDateTime(),
      'updated_at'                  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mailinglist_template[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailinglistTemplate';
  }

}
