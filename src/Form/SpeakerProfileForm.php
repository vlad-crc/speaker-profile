<?php declare(strict_types = 1);

namespace Drupal\speaker_profile\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the speaker profile entity edit forms.
 */
final class SpeakerProfileForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);

    $message_args = ['%name' => $this->entity->toLink()->toString()];
    $logger_args = [
      '%name' => $this->entity->label(),
      'link' => $this->entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New speaker profile %name has been created.', $message_args));
        $this->logger('speaker_profile')->notice('New speaker profile %name has been created.', $logger_args);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The speaker profile %name has been updated.', $message_args));
        $this->logger('speaker_profile')->notice('The speaker profile %name has been updated.', $logger_args);
        break;

      default:
        throw new \LogicException('Could not save the entity.');
    }

    $form_state->setRedirectUrl($this->entity->toUrl());

    return $result;
  }

}
