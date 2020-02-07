<?php

/**
 * @file
 * Hooks and API provided by the "Email Content Notification" module.
 */

use Drupal\Core\Entity\EntityInterface;

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Allows to alter the recipients data before sending the mail.
 *
 * @param $value
 * @param \Drupal\Core\Entity\EntityInterface $entity
 * @param $field_name
 */

/**
 * Allows to alter the recipients data before sending the mail.
 *
 * @param string $recipients
 *   Comma separated list of recipients.
 * @param \Drupal\Core\Entity\EntityInterface $entity
 *   Entity.
 */
function hook_content_notification_recipients_alter(&$recipients, EntityInterface $entity) {
  // Add new recipient programmatically.
  if ($entity->hasField('field_your_email')) {
    $recipients = array_map('trim', explode(',', $recipients));
    $recipients[] = $entity->get('field_your_email')->getString();
    $recipients = implode(',', $recipients);
  }
}

/**
 * Allows to alter the subject or body before sending the mail.
 *
 * @param array $params
 *   Params.
 * @param \Drupal\Core\Entity\EntityInterface $entity
 *   Entity.
 */
function hook_content_notification_params_alter(array &$params, EntityInterface $entity) {
  // Add text to the subject.
  $params['subject'] .= '[Site report]';

  // Add text to the body.
  $params['body'] .= '== Your signature';
}

/**
 * @} End of "addtogroup hooks".
 */
