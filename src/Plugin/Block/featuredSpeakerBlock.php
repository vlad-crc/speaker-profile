<?php

namespace Drupal\speaker_profile\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;


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

    // Get all
    $query = $storage->getQuery()
      ->accessCheck(false)
      ->execute();

    // Get random
    $randomSpeakerId = $query[array_rand($query)];

    // Load speaker entity
    $speakerLoad = \Drupal\speaker_profile\Entity\SpeakerProfile::load($randomSpeakerId);

    // Load fields
    $speakerName = $speakerLoad->get('name')->value;

    // Get portrait
    $speakerPortrait = $speakerLoad->get('portrait')->entity;
    $speakerPortraitUri = $speakerPortrait->getFileUri();
    $speakerPortraitUrl = \Drupal::service('file_url_generator')->generateString($speakerPortraitUri);

    // Get topics of expertise
    $speakerExpertise = $speakerLoad->get('topics_of_expertise')->referencedEntities();
    $topics = [];
    foreach ($speakerExpertise as $term) {
      $topics[] = $term->getName();
    }

    // Set caching rules and pass variables.
    $cache_tags = $speakerLoad->getCacheTags();
    $content = [
      'name'=>$speakerName,
      'portrait'=>$speakerPortraitUrl,
      'expertise'=>$topics,
      '#cache' => [
        'tags' => $cache_tags,
        'max-age' => 86400,
      ],
    ];

    return $content;
  }
}
