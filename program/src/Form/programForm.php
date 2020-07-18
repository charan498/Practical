<?php
namespace Drupal\program\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for the program add and edit forms.
 */
class programForm extends EntityForm {

  /**
   * Constructs an programForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $program = $this->entity; 
	//print_r($program);

    $form['id'] = [
      '#type' => 'hidden',
      '#default_value' => $program->id(),
/*       '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$program->isNew(), */
    ];
    
	$form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 255,
      '#default_value' => $program->title,
      '#description' => $this->t("Title for the program."),
      '#required' => TRUE,
    ];
    $form['stdate'] = [
      '#type' => 'date',
      '#title' => t('Start Date'),
      '#default_value' => isset($program->stdate)?(\Drupal::service('date.formatter')->format(strtotime($program->stdate), 'custom', 'Y-m-d')):'',
      '#required' => TRUE,
      '#date_format' => 'd-m-Y',
      '#date_year_range' => '-2:+4',
    ];   
	$form['endate'] = [
      '#type' => 'date',
      '#title' => t('End Date'),
      '#default_value' => isset($program->endate)?(\Drupal::service('date.formatter')->format(strtotime($program->endate), 'custom', 'Y-m-d')):'',
      '#required' => TRUE,
      '#date_format' => 'd-m-Y',
      '#date_year_range' => '-2:+4',
    ];
	$form['venue'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Venue'),
      '#maxlength' => 255,
      '#default_value' => $program->venue,
      '#description' => $this->t("Venue for the program."),
      '#required' => TRUE,
    ];	
	$form['desc'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#maxlength' => 255,
      '#default_value' => $program->desc,
      '#description' => $this->t("Description of program."),
      '#required' => TRUE,
    ];
    // You will need additional form elements for your custom properties.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $program = $this->entity;
	$program->id = strtoupper($program->title);
    $status = $program->save();

    if ($status === SAVED_NEW) {
      $this->messenger()->addMessage($this->t('The %label program created.', [
        '%label' => $program->title,
      ]));
    }
    else {
      $this->messenger()->addMessage($this->t('The %label program updated.', [
        '%label' => $program->title,
      ]));
    }

    $form_state->setRedirect('entity.program.collection');
  }

  /**
   * Helper function to check whether an program configuration entity exists.
   */
  public function exist($id) {
    $entity = $this->entityTypeManager->getStorage('program')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}

