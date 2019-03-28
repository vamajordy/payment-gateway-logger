<?php
/**
 * payment-gateway-logger
 *
 * @package    payment-gateway-logger
 * @author     manzoj
 * @version    1
 */

namespace PaymentGatewayLogger\Event\Subscriber;

use Guzzle\Common\Event;
use PaymentGatewayLogger\Event\Constants;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OmnipayGatewayRequestSubscriber implements EventSubscriberInterface
{
    const PRIORITY = 255;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $gateway_name;

    /**
     * OmnipayGatewayRequestSubscriber constructor.
     *
     * @param string $gateway_name
     * @param LoggerInterface $logger
     */
    public function __construct($gateway_name, $logger)
    {
        $this->logger = $logger;
        $this->gateway_name = 'omnipay_' . $gateway_name;
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
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            Constants::OMNIPAY_REQUEST  => array('onOmnipayRequestBeforeSend', self::PRIORITY),
            Constants::OMNIPAY_RESPONSE => array('onOmnipayRequestSent', self::PRIORITY),
            Constants::OMNIPAY_ERROR    => array('onOmnipayRequestError', self::PRIORITY),
        );
    }

    /**
     * Triggers a log write before a request is sent.
     *
     * @param Event $event
     * @return void
     */
    public function onOmnipayRequestBeforeSend(Event $event)
    {
        $this->logger->log(LogLevel::INFO, $this->gateway_name, $event->toArray());
    }

    /**
     * Triggers a log write when a request completes.
     *
     * @param Event $event
     * @return void
     */
    public function onOmnipayRequestSent(Event $event)
    {
        $this->logger->log(LogLevel::INFO, $this->gateway_name, $event->toArray());
    }

    /**
     * Triggers a log write when a request fails.
     *
     * @param Event $event
     * @return void
     */
    public function onOmnipayRequestError(Event $event)
    {
        $this->logger->log(LogLevel::ERROR, $this->gateway_name, $event->toArray());
    }
}
