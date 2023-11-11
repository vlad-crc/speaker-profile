<?php

namespace Drupal\speaker_profile\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityTypeManagerInterface;


/**
 * Provides a 'Featured Speaker' block.
 *
 * @Block(
 *   id = "featured_speaker_block",
 *   admin_label = @Translation("Featured Speaker"),
 * )
 */
class FeaturedSpeakerBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {

    // Build and return the block content.
    $content = $this->getRandomSpeaker();

    kint($content);
    return [
      '#theme' => 'featured_speaker',
      '#content'=> $content,
    ];
  }

  protected function getRandomSpeaker()
  {
    // Get a random speaker
    $entityType = 'speaker_profile';
    $entityTypeManager = \Drupal::entityTypeManager();
    $storage = $entityTypeManager->getStorage($entityType);

    $query = $storage->getQuery()
      ->addTag('random_order')
      ->range(0, 1)
      ->accessCheck(false)
      ->execute();

    $speakerLoad = reset($query);

    $speaker = $storage->load($speakerLoad);

    $speakerName = $speaker->get('name')->value;
    $speakerPortrait = $speaker->get('portrait')->entity->getFileUri();
    $speakerExpertise = $speaker->get('topics_of_expertise')->referencedEntities();

    $content = [
      'name'=>$speakerName,
      'portrait'=>$speakerPortrait,
      'expertise'=>$speakerExpertise
    ];

    return $content;
  }
}
