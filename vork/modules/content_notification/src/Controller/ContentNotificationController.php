<?php

namespace Drupal\content_notification\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\content_notification\ContentNotificationService;
use Drupal\Core\Url;

/**
 * ContentNotificationController Class.
 */
class ContentNotificationController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * A instance of the content_notification helper services.
   *
   * @var \Drupal\content_notification\ContentNotificationService
   */
  protected $contentNotificationService;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a ContentNotificationController object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\content_notification\ContentNotificationService $contentNotificationService
   *   Helper service.
   */
  public function __construct(RendererInterface $renderer, ContentNotificationService $contentNotificationService) {
    $this->renderer = $renderer;
    $this->contentNotificationService = $contentNotificationService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('renderer'), $container->get('content_notification.common')
    );
  }

  /**
   * Generates list of all email content notification.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function getContentNotificationList() {
    $data = $this->contentNotificationService->getNotifications();
    if ($data) {
      $types = node_type_get_names();
      $rows = [];
      foreach ($data as $value) {
        $enable_disable_link = $value->status ? \Drupal::l($this->t('Disable'), Url::fromRoute('content_notification.disable_form', ['notification' => $value->notification_id])) : \Drupal::l($this->t('Enable'), Url::fromRoute('content_notification.enable_form', ['notification' => $value->notification_id]));
        $rows[] = [
          $value->notification_id,
          $value->status ? $this->t('Enabled') : $this->t('Disabled'),
          $types[$value->bundle],
          $value->action,
          \Drupal::l($this->t('Edit'), Url::fromRoute('content_notification.edit_form', ['notification' => $value->notification_id])),
          \Drupal::l($this->t('Delete'), Url::fromRoute('content_notification.delete_form', ['notification' => $value->notification_id])),
          $enable_disable_link,
        ];
      }
      // Header of the Notifications list.
      $header = [
        $this->t('Notification Id'),
        $this->t('Status'),
        $this->t('Content Type'),
        $this->t('On Action'),
        $this->t('Edit'),
        $this->t('Delete'),
        $this->t('Enable/Disable'),
      ];
      return [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
      ];
    }
    else {
      return [
        '#markup' => $this->t('No email content notifcations added yet.'),
      ];
    }
  }

  /**
   * Create email content notification.
   *
   * @return array
   *   The notification add form.
   */
  public function addForm() {
    return $this->formBuilder()->getForm('Drupal\content_notification\Form\ContentNotificationAddForm');
  }

  /**
   * Edit email content notification.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function editForm($notification) {
    return $this->formBuilder()->getForm('Drupal\content_notification\Form\ContentNotificationEditForm', $notification);
  }

  /**
   * Delete email content notification.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function deleteForm($notification) {
    return $this->formBuilder()->getForm('Drupal\content_notification\Form\ContentNotificationDeleteForm', $notification);
  }

  /**
   * Enable email content notification.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function enableForm($notification) {
    $fields = [
      'status' => 1,
    ];
    try {
      $this->contentNotificationService->upDateNotifications($fields, $notification);
      \Drupal::logger('content_notification')->info($this->t('Email content notification has been enabled successfully.'));
      \Drupal::messenger()->addMessage('Email content notification has been enabled successfully.');
    }
    catch (Exception $e) {
      \Drupal::logger('content_notification')->error($e->getMessage());
    }
    return $this->redirect('content_notification.config');
  }

  /**
   * Disable email content notification.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function disableForm($notification) {
    $fields = [
      'status' => 0,
    ];
    try {
      $this->contentNotificationService->upDateNotifications($fields, $notification);
      \Drupal::logger('content_notification')->info($this->t('Email content notification has been disabled successfully.'));
      \Drupal::messenger()->addMessage('Email content notification has been disabled successfully.');
    }
    catch (Exception $e) {
      \Drupal::logger('content_notification')->error($e->getMessage());
    }
    return $this->redirect('content_notification.config');
  }

}
