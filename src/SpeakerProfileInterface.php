<?php declare(strict_types = 1);

namespace Drupal\speaker_profile;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a speaker profile entity type.
 */
interface SpeakerProfileInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
