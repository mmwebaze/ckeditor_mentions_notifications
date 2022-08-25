<?php

namespace Drupal\ckeditor_mentions_notifications\EventSubscriber;

use Drupal\comment\Entity\Comment;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\ckeditor_mentions\Events\CKEditorEvents;
use Drupal\ckeditor_mentions\Events\CKEditorMentionsEvent;
use Drupal\Core\Utility\Token;
use Drupal\user\Entity\User;
use Drupal\user\UserDataInterface;

/**
 * Class MentionEventsSubscriber.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class NotificationMentionEventsSubscriber implements EventSubscriberInterface {

    /**
     * The user data service.
     *
     * @var UserDataInterface
     */
    protected UserDataInterface $userData;

  /**
   * The mail manager service.
   *
   * @var MailManagerInterface
   */
    protected MailManagerInterface $mailManager;

  /**
   * @var Token
   */
    protected Token $tokenService;

  /**
   * @var ConfigFactoryInterface
   */
    protected ConfigFactoryInterface $configFactory;

    public function __construct(UserDataInterface $userData, MailManagerInterface $mailManager, ConfigFactoryInterface $configFactory, Token $tokenService) {
        $this->userData = $userData;
        $this->mailManager = $mailManager;
        $this->configFactory = $configFactory;
        $this->tokenService = $tokenService;
    }

  /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents(): array
  {
    return [
      CKEditorEvents::MENTION_FIRST => 'initiateNotification',
    ];
  }

  /**
   * @param CKEditorMentionsEvent $event
   * @return void
   */
  public function initiateNotification(CKEditorMentionsEvent $event){ //TODO: Move this to a service of it's own
    $mentionedEntity = $event->getMentionedEntity();
    if ($mentionedEntity instanceof User ){

      $uid = $mentionedEntity->id();
      $userPref = $this->userData->get('ckeditor_mentions_notifications', $uid, 'mentions_notifications_settings_key');

      if ($userPref === "Enable"){
        $entity = $event->getEntity();
        $data = [];
        if ($entity instanceof Node){
          $data['node'] = $entity;
        }
        elseif ($entity instanceof Comment){
          $data['comment'] = $entity;
        }
        $config = $this->configFactory->get('ckeditor_mentions_notification.settings');
        $subject = $this->tokenService->replacePlain($config->get('mentions_notifications_email_subject'), $data);
        $body = $this->tokenService->replacePlain($config->get('mentions_notifications_email_body'), $data);
        $email = $mentionedEntity->getEmail();

        $params['message'] = $subject;
        $params['subject'] = $body;
        $result = $this->mailManager->mail('ckeditor_mentions_notifications', 'send_ckeditor_mentions_notifications', $email, 'en', $params, TRUE);
        if ($result['result'] != TRUE) {
          \Drupal::logger("ckeditor_mentions_notifications")->notice("Unable to send a mentions notification out to : {$mentionedEntity->getAccountName()}");
        }
      }
    }
  }
}
