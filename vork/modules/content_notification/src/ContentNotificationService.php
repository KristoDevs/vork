<?php

namespace Drupal\content_notification;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Utility\LinkGeneratorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Logger\LoggerChannelTrait;
use Drupal\Core\Database\Connection;
use Drupal\workflows\Entity\Workflow;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * ContentNotificationService implement helper service class.
 */
class ContentNotificationService {

  use StringTranslationTrait;
  use LoggerChannelTrait;

  /**
   * Constant to hold table name.
   */
  const CONTENT_NOTIFICATION_TABLE = 'email_content_notification';

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * The mail manager instance.
   *
   * @var Drupal\Core\Mail\MailManager
   */
  protected $mailManager;

  /**
   * The link generator instance.
   *
   * @var Drupal\Core\Utility\LinkGeneratorInterface
   */
  protected $linkGenerator;

  /**
   * Database connection.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $databaseConnection;

  /**
   * Module Handler.
   *
   * @var Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Creates a verbose messenger.
   */
  public function __construct(ConfigFactoryInterface $config_factory, AccountInterface $account, MailManagerInterface $mailManager, LinkGeneratorInterface $linkGenerator, Connection $connection, ModuleHandlerInterface $moduleHandler) {
    $this->configFactory = $config_factory;
    $this->account = $account;
    $this->mailManager = $mailManager;
    $this->linkGenerator = $linkGenerator;
    $this->databaseConnection = $connection;
    $this->moduleHandler = $moduleHandler;
  }

  /**
   * Get users of roles.
   *
   * @return array
   *   Array of User Uids.
   */
  public function getUsersOfRoles($roles) {
    $ids = \Drupal::entityQuery('user')
      ->condition('status', 1)
      ->condition('roles', $roles, 'IN')
      ->execute();
    return $ids;
  }

  /**
   * Return all added notification.
   *
   * @param int $notification
   *   Notification id.
   * @param int $enabled
   *   Status.
   * @param string $bundle
   *   Content type.
   * @param string $action
   *   Action.
   *
   * @return array
   *   An array of notifications
   */
  public function getNotifications($notification = NULL, $enabled = NULL, $bundle = NULL, $action = NULL) {
    $query = $this->databaseConnection->select('email_content_notification', 'ecn');
    $query->fields('ecn', [
      'notification_id',
      'bundle',
      'action',
      'status',
      'data',
    ]);
    if (!is_null($enabled)) {
      $enabled = ($enabled) ? 1 : 0;
      $query->condition('ecn.status', $enabled, '=');
    }
    if (!is_null($notification)) {
      $query->condition('ecn.notification_id', $notification, '=');
    }
    if (!is_null($bundle)) {
      $query->condition('ecn.bundle', $bundle, '=');
    }
    if (!is_null($action)) {
      $action = [$action, 'both'];
      $query->condition('ecn.action', $action, 'in');
    }
    return $query->execute()->fetchAll();
  }

  /**
   * Get Workflow state per content type enabled.
   *
   * @param string $type
   *   Content type.
   *
   * @return array
   *   workflow states options
   */
  public function getWorkflowStatePerContentType($type = NULL) {
    $states = ['' => 'N/A'];
    if (!empty($type)) {
      $worklfows = \Drupal::service('plugin.manager.workflows.type')->getDefinitions();
      if (count($worklfows)) {
        foreach ($worklfows as $workflow => $definition) {
          $workflow = Workflow::loadMultipleByType($workflow);
          foreach ($workflow as $moderation) {
            $settings = $moderation->get('type_settings');
            if (in_array($type, $settings['entity_types']['node'])) {
              $states = [];
              foreach ($settings['states'] as $key => $value) {
                $states[$key] = $value['label'];
              }
            }
          }

        }
      }
    }
    return $states;
  }

  /**
   * Check if workflow and content moderation module enabled.
   *
   * @return bool
   *   Return True if enabled.
   */
  public function isWorkflowEnabled() {
    return $this->moduleHandler->moduleExists('workflows') && $this->moduleHandler->moduleExists('content_moderation');
  }

  /**
   * Check if token module enabled.
   *
   * @return bool
   *   Return True if enabled.
   */
  public function isTokenEnabled() {
    return $this->moduleHandler->moduleExists('token');
  }

  /**
   * Create and update notifications.
   *
   * @param array $fields
   *   Fields to be Updated/Created.
   * @param int $key
   *   Primary key on which update should work.
   */
  public function upDateNotifications(array $fields, $key = NULL) {
    $this->databaseConnection->merge(self::CONTENT_NOTIFICATION_TABLE)
      ->key(['notification_id' => $key])
      ->fields($fields)
      ->execute();
  }

  /**
   * Delete notifications.
   *
   * @param int $notification
   *   Fields to be Updated/Created.
   */
  public function deleteNotification($notification) {
    $this->databaseConnection->delete(self::CONTENT_NOTIFICATION_TABLE)
      ->condition('notification_id', $notification, '=')
      ->execute();
  }

  /**
   * Process content notification.
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   Entity.
   * @param string $action
   *   Action insert or update.
   */
  public function contentNotificationProcess(EntityInterface $entity, $action) {
    if ($this->isContentNotificationExistForBundle($entity, $action)) {
      $this->processNotification($entity, $action);
    }
  }

  /**
   * Check if current user allowed to send content notification.
   *
   * @param array $roles
   *   Roles.
   *
   * @return bool
   *   Return true if allowed to send content notification.
   */
  public function isCurrentUserRoleAllowedToSendNotification(array $roles) {
    $currentUserRoles = $this->account->getRoles();
    return count(array_intersect(array_filter($roles), $currentUserRoles));
  }

  /**
   * Check if current workflow state match.
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   Entity.
   * @param array $states
   *   Workflow states.
   *
   * @return bool
   *   Return true if allowed to send content notification.
   */
  public function isWorkflowStateMatched(EntityInterface $entity, array $states) {
    if (!$this->isWorkflowEnabled()) {
      return TRUE;
    }
    elseif (in_array($entity->get('moderation_state')->value, $states)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Check if notification exist for the bundle.
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   Entity.
   * @param string $action
   *   Action insert or update.
   *
   * @return bool
   *   Return true if notification exist for the bundle.
   */
  public function isContentNotificationExistForBundle(EntityInterface $entity, $action) {
    if ($entity->getEntityTypeId() == 'node') {
      $notification = $this->getNotifications(NULL, NULL, $entity->bundle(), $action);
      if ($notification) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Process notifications.
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   Entity.
   * @param string $action
   *   Action insert or update.
   */
  public function processNotification(EntityInterface $entity, $action) {
    $notifications = $this->getNotifications(NULL, NULL, $entity->bundle(), $action);
    foreach ($notifications as $notification) {
      $data = unserialize($notification->data);
      $data['content_notification_workflow_state'] = !empty($data['content_notification_workflow_state']) ?: [];
      if ($this->isCurrentUserRoleAllowedToSendNotification($data['content_notification_allowed_roles'])) {
        $this->sendMail($entity, $action, $data);
      }
      else if ($this->isCurrentUserRoleAllowedToSendNotification($data['content_notification_allowed_roles']) && !empty($data['content_notification_workflow_state']) && $this->isWorkflowStateMatched($entity, $data['content_notification_workflow_state'])) {
        $this->sendMail($entity, $action, $data);
      }
    }
  }

  /**
   * Send Email.
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   Entity.
   * @param string $action
   *   Action insert or update.
   * @param array $data
   *   Notification Data.
   */
  public function sendMail(EntityInterface $entity, $action, array $data) {
    global $base_url;
    $types = node_type_get_names();
    $node_type = $entity->bundle();
    $user = $entity->getOwner();
    $user_name = $user->getDisplayName();
    $url = Url::fromUri($base_url . '/node/' . $entity->id());
    $internal_link = $this->linkGenerator->generate($this->t('@title', ['@title' => $entity->label()]), $url);
    $variables = [
      '@user_who_posted' => $user_name,
      '@content_link' => $internal_link,
      '@content_title' => $entity->label(),
      '@content_type' => $types[$node_type],
      '@action' => $action,
    ];
    $subject = $this->t($data['content_notification_email_subject'], $variables);
    if ($this->isTokenEnabled()) {
      $token_service = \Drupal::token();
      // Replace the token for body.
      $subject = $token_service->replace($subject, ['node' => $entity]);
    }
    $body = $this->t($data['content_notification_email_body'], $variables);
    if ($this->isTokenEnabled()) {
      $token_service = \Drupal::token();
      // Replace the token for body.
      $body = $token_service->replace($body, ['node' => $entity]);
    }
    $emails = $data['content_notification_email'];
    if (empty($emails)) {
      $roles_notify = array_keys(array_filter($data['content_notification_roles_notified']));
      $ids = $this->getUsersOfRoles($roles_notify);
      $emails = [];
      if (count($ids)) {
        $users = User::loadMultiple($ids);
        foreach ($users as $userload) {
          $emails[] = $userload->getEmail();
        }
      }
      $emails = implode(',', $emails);
    }
    else {
      $mails = explode(',', $emails);
      $emails = [];
      foreach ($mails as $email) {
        $email = trim($email);
        // replace token in email recipients list.
        if ($this->isTokenEnabled()) {
          $token_service = \Drupal::token();
          // Replace the token for body.
          $email = $token_service->replace($email, ['node' => $entity]);
        }
        if (\Drupal::service('email.validator')->isValid($email)) {
          $emails[] = $email;
        }
      }
      $emails = implode(',', $emails);
    }
    $params = [
      'body' => $body,
      'subject' => $subject,
      'nid' => $entity->id(),
    ];

    // Allow to alter $emails
    // by using hook_content_notification_recipients_alter().
    // @see content_notification.api.php
    \Drupal::moduleHandler()
      ->alter('content_notification_recipients_alter', $emails, $entity);

    // Allow to alter $params
    // by using hook_content_notification_params_alter().
    // @see content_notification.api.php
    \Drupal::moduleHandler()
      ->alter('content_notification_params_alter', $params, $entity);

    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $key = 'content_notification_key';
    $this->mailManager->mail('content_notification', $key, $emails, $language, $params, \Drupal::config('system.site')->get('mail'), TRUE);
    $this->getLogger('content_notification')->notice(t('Email content notification sent to @emails.', ['@emails' => $emails]));
  }

}
