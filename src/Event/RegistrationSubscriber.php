<?php

namespace App\Event;

use JMS\Serializer\SerializerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationSubscriber implements EventSubscriberInterface
{

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * RegistrationSubscriber constructor.
     * @param MailerInterface $mailer
     * @param ProducerInterface $producer
     * @param SerializerInterface $serializer
     */
    public function __construct(MailerInterface $mailer, ProducerInterface $producer, SerializerInterface $serializer)
    {
        $this->mailer = $mailer;
        $this->producer = $producer;
        $this->serializer = $serializer;
    }

    public function OnRegisterUser(RegistrationEvent $event){
        $user = $event->getUser();

        $email = (new Email())
            ->from('mohammed.jidal93@gmail.com')
            ->to('mohammed.jidal93@gmail.com')
            ->subject($user->getUsername())
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
        $this->producer->publish($this->serializer($email));

    }
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [RegistrationEvent::NAME => 'OnRegisterUser'];
    }
}