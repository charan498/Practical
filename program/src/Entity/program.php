<?php
namespace Drupal\program\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\program\programInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
/**
 * Defines the program entity.
 *
 * @ConfigEntityType(
 *   id = "program",
 *   label = @Translation("program"),
 *   handlers = {
 *     "list_builder" = "Drupal\program\Controller\programListBuilder",
 *     "form" = {
 *       "add" = "Drupal\program\Form\programForm",
 *       "edit" = "Drupal\program\Form\programForm",
 *       "delete" = "Drupal\program\Form\programDeleteForm",
 *     }
 *   },
 *   config_prefix = "program",
 *   base_table = "program_term",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "title" = "title",
 *     "created" = "created",
 *     "changed" = "changed",
 *     "stdate" = "stdate",
 *     "endate" = "endate",
 *     "venue" = "venue",
 *     "desc" = "desc",
 *   },
 *   config_export = {
 *     "id",
 *     "title",
 *     "stdate",
 *     "endate",
 *     "venue",
 *     "desc"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/system/program/{program}",
 *     "delete-form" = "/admin/config/system/program/{program}/delete",
 *   }
 * )
 */
class program extends ConfigEntityBase implements programInterface {
	
  use EntityChangedTrait;
  /**
   * The program ID.
   *
   * @var string
   */
 // public $id;

  /**
   * The program label.
   *
   * @var string
   */
  //public $label;

  // Your specific configuration property get/set methods go here,
  // implementing the interface.
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    // Default author to current user.
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Term entity.'))
      ->setReadOnly(TRUE);



    // Name field for the contact.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('Its title.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);    
	 
	$fields['stdate'] = BaseFieldDefinition::create('datetime')
	  ->setLabel(t('Start date'))
	  ->setDescription(t('The date that the survey is started.'))
	  ->setSetting('datetime_type', 'date')
	  ->setRequired(true)
	  ->setDisplayOptions('view', array(
		'label' => 'above',
		'type' => 'string',
		'weight' => -4,
	  ))
	  ->setDisplayOptions('form', array(
        'type' => 'daterange_default',
        'weight' => -4,
      ))
	  ->setDisplayConfigurable('form', TRUE)
	  ->setDisplayConfigurable('view', TRUE);	
    $fields['endate'] = BaseFieldDefinition::create('datetime')
	  ->setLabel(t('End date'))
	  ->setDescription(t('The date that the survey is ended.'))
	  ->setSetting('datetime_type', 'date')
	  ->setRequired(true)
	  ->setDisplayOptions('view', array(
		'label' => 'above',
		'type' => 'string',
		'weight' => -4,
	  ))
	  ->setDisplayOptions('form', array(
        'type' => 'daterange_default',
        'weight' => -4,
      ))
	  ->setDisplayConfigurable('form', TRUE)
	  ->setDisplayConfigurable('view', TRUE);

    $fields['venue'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Venue'))
      ->setDescription(t('Its Venue.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);     
	  
    $fields['desc'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Description'))
      ->setDescription(t('Its Description.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE); 
	  
	  

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}


