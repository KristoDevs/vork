<?php

namespace Drupal\content_notification\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\content_notification\ContentNotificationService;
use Drupal\Core\Url;

/**
 * Class ContentNotificationDeleteForm implements notification delete form.
 */
class ContentNotificationDeleteForm extends ConfirmFormBase {

  /**
   * The ID of the item to delete.
   *
   * @var string
   */
  protected $id;

  /**
   * A instance of the content_notification helper service.
   *
   * @var \Drupal\content_notification\ContentNotificationService
   */
  protected $contentNotificationService;

  /**
   * {@inheritdoc}
   */
  public function __construct(ContentNotificationService $contentNotificationService) {
    $this->contentNotificationService = $contentNotificationService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('content_notification.common')
    );
  }

  /**
   * Get the form_id.
   *
   * @inheritDoc
   */
  public function getFormId() {
    return 'email_content_notification_delete_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Do you actually want to delete?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('content_notification.config');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return t('This action can not be undone!');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete it Now!');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return $this->t('Cancel');
  }

  /**
   * Build the Form.
   *
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state, $notification = NULL) {
    $this->id = $notification;
    return parent::buildForm($form, $form_state);
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->contentNotificationService->deleteNotification($this->id);
    $form_state->setRedirect('content_notification.config');
  }

}
