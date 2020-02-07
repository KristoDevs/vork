<?php

namespace Drupal\content_notification\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\content_notification\ContentNotificationService;

/**
 * Class ContentNotificationAddForm implements notification add form.
 */
class ContentNotificationAddForm extends FormBase {

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
    return 'email_content_notification_add_form';
  }

  /**
   * Build the Form.
   *
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];
    $form['content_notification_content_type'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Content Trigger'),
      '#description' => $this->t('Choose the content type for which you want to create notification.'),
    ];

    $bundles = node_type_get_names();
    $form['content_notification_content_type']['content_notification_node_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select which content type will trigger the email notification'),
      '#options' => $bundles,
      '#required' => TRUE,
    ];

    $form['content_notification_content_type']['content_notification_action'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select which action will trigger the email notification'),
      '#options' => [
        'insert' => 'Add',
        'update' => 'Update',
        'both' => 'Both',
      ],
      '#required' => TRUE,
      '#description' => $this->t('Please check the action on which you want to send a notification.'),
    ];

    if (empty($form_state->getValue('content_notification_node_type'))) {
      $type = '';
    }
    else {
      $type = $form_state->getValue('content_notification_node_type');
    }

    if ($this->contentNotificationService->isWorkflowEnabled()) {
      $form['content_notification_content_type']['content_notification_node_type']['#ajax'] = [
        'callback' => '::getWorkflowStateCallback',
        'wrapper' => 'workflow-field-container',
        'event' => 'change',
      ];

      $form['content_notification_content_type']['content_notification_workflow_states'] = [
        '#type' => 'fieldset',
        '#attributes' => ['id' => 'workflow-field-container'],
        '#description' => $this->t('Choose on which workflow state email notification will perform.'),
      ];

      $form['content_notification_content_type']['content_notification_workflow_states']['content_notification_workflow_state'] = [
        '#type' => 'checkboxes',
        '#title' => $this->t('Select Workflow State'),
        '#options' => $this->getWorkflowStatesIfEnabled($type),
      ];
    }

    $user_roles = user_role_names();
    $form['content_notification_content_type']['content_notification_allowed_roles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select which roles will trigger the email notification when performing the action'),
      '#options' => $user_roles,
      '#description' => $this->t('Please select the roles for which email notifications should trigger, if not selected will trigger for all'),
    ];

    $form['content_notification_recepient_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Email Recipients'),
    ];

    $form['content_notification_recepient_fieldset']['content_notification_email_limit'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Recipients Limit (Max)'),
      '#description' => $this->t('Enter -1 if you want to ignore Recipients Limit'),
    ];

    $form['content_notification_recepient_fieldset']['content_notification_email'] = [
      '#type' => 'textarea',
      '#title' => $this->t("List the emails to which the notification is to be sent. Add comma separated emails in case of multiple recipients"),
      '#description' => $this->t('Leave this field blank if want to send email based on roles, Tokens (if token module installed only) are also allowed in it but ensure it should be a valid Email id'),
    ];

    $form['content_notification_recepient_fieldset']['content_notification_email_or_markup']['#markup'] = '<strong>' . $this->t('OR') . '</strong>';

    if (array_key_exists('anonymous', $user_roles)) {
      unset($user_roles['anonymous']);
    }
    $form['content_notification_recepient_fieldset']['content_notification_roles_notified'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select roles'),
      '#options' => $user_roles,
      '#description' => $this->t('Please select the roles to whom you want to send email, please remember to select roles in a way so that total user count should not be greater than 50.'),
    ];

    $form['content_notification_email_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Email Settings'),
    ];

    $form['content_notification_email_fieldset']['content_notification_email_subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Configurable email subject'),
      '#required' => TRUE,
      '#description' => $this->t('Enter subject of the email, Tokens (if token module installed only) are also allowed in it'),
    ];

    $form['content_notification_email_fieldset']['content_notification_email_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Configurable email body'),
      '#required' => TRUE,
      '#description' => $this->t('Email body for the email. Use the following tokens: @user_who_posted, @content_link, @content_title, @content_type, @action (posted or updated, will update accrodingly).'),
    ];

    if ($this->contentNotificationService->isTokenEnabled()) {
      $form['content_notification_email_fieldset']['content_notification_email_tokens']['#markup'] = '<strong>' . $this->t('You can use tokens provided by token module as well.') . '</strong><br>';
      // Add the token tree UI.
      $form['content_notification_email_fieldset']['token_tree'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'user',
          'node',
          'content-type',
          'current-date',
          'current-user'
        ],
        '#show_restricted' => TRUE,
        '#global_types' => FALSE,
        '#weight' => 90,
      ];
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create Notification'),
    ];
    return $form;
  }

  /**
   * Ajax callback.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Workflow state field.
   */
  public function getWorkflowStateCallback(array $form, FormStateInterface $form_state) {
    $form_state->setRebuild();
    return $form['content_notification_content_type']['content_notification_workflow_states'];
  }

  /**
   * Helper function to populate the workflow state checkboxes.
   *
   * @param string $key
   *   This will determine which set of options is returned.
   *
   * @return array
   *   Dropdown options
   */
  public function getWorkflowStatesIfEnabled($key) {
    return $this->contentNotificationService->getWorkflowStatePerContentType($key);
  }

  /**
   * @inheritDoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $user_input_values = $form_state->getUserInput();
    $content_notification_email_limit = $user_input_values['content_notification_email_limit'];
    $roles_notified = array_keys(array_filter($user_input_values['content_notification_roles_notified']));
    if (empty($user_input_values['content_notification_email']) && !count($roles_notified)) {
      $form_state->setErrorByName('content_notification_email', $this->t('Email Recipients should not be empty, please enter either Email id\'s or select roles to which email notification should sent.'));
    }
    if ($content_notification_email_limit != -1) {
      if (!empty($user_input_values['content_notification_email'])) {
        $content_notification_email = explode(',', $user_input_values['content_notification_email']);
        if (count($content_notification_email) > $content_notification_email_limit) {
          $form_state->setErrorByName('content_notification_email', $this->t('Email Ids should be less than or equal to ' . $content_notification_email_limit . '.'));
        }
      }
      else {
        if (count($roles_notified)) {
          $ids = $this->contentNotificationService->getUsersOfRoles($roles_notified);
          if (count($ids) > $content_notification_email_limit) {
            $form_state->setErrorByName('content_notification_roles_notified', $this->t('User count for the Recipients should be less than' . $content_notification_email_limit . '.'));
          }
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user_input_values = $form_state->getValues();
    $data = [
      'content_notification_workflow_state' => array_filter($user_input_values['content_notification_workflow_state']),
      'content_notification_allowed_roles' => array_filter($user_input_values['content_notification_allowed_roles']),
      'content_notification_email' => $user_input_values['content_notification_email'],
      'content_notification_roles_notified' => array_filter($user_input_values['content_notification_roles_notified']),
      'content_notification_email_subject' => $user_input_values['content_notification_email_subject'],
      'content_notification_email_body' => $user_input_values['content_notification_email_body'],
      'content_notification_email_limit' => $user_input_values['content_notification_email_limit'],
    ];
    $fields = [
      'bundle' => $user_input_values['content_notification_node_type'],
      'action' => $user_input_values['content_notification_action'],
      'status' => 1,
      'data' => serialize($data),
    ];
    try {
      $this->contentNotificationService->upDateNotifications($fields);
      \Drupal::logger('content_notification')->info($this->t('Email content notification has been created successfully.'));
      \Drupal::messenger()->addMessage('Email content notification has been created successfully.');
    }
    catch (Exception $e) {
      \Drupal::logger('content_notification')->error($e->getMessage());
    }
    $form_state->setRedirect('content_notification.config');
  }

}
