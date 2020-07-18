<?php

namespace Drupal\program\Controller;

use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Provides a listing of program.
 */
class programListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id())
      //$container->get('url_generator')
    );
  }
  /**
   * Constructs a new programTermListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type term.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage) {
    parent::__construct($entity_type, $storage);
    //$this->urlGenerator = $url_generator;
  }  
  public function buildHeader() {
	//$header['id'] = $this->t('TermID');
	//$header['id'] = $this->t('<input class="form-checkbox" type="checkbox">');
	//$header['id'] = $this->t('');
	$header['title'] = $this->t('Title');
    $header['stdate'] = $this->t('Start Date');
    $header['endate'] = $this->t('End Date');
    $header['venue'] = $this->t('Venue');
    $header['desc'] = $this->t('Description');	
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {

    //$program1 = $this->entity;	
	//print_r($program1);
    //$row['id'] = $entity->id();
   // $row['id'] = $this->t('<input class="form-checkbox" type="checkbox">');
    $row['title'] = $entity->title;
    $row['stdate'] = $entity->stdate;
    $row['endate'] = $entity->endate;
    $row['venue'] = $entity->venue;
    $row['desc'] = $entity->desc;

    return $row + parent::buildRow($entity);
  }





}
