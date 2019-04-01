<?php

namespace PaymentGatewayLogger\Event;

/**
 * Class events.
 *
 * @package    payment-gateway-logger
 * @author     manzoj
 * @version    1
 */

final class Constants
{
    const OMNIPAY_REQUEST_BEFORE_SEND = 'omnipay.request.before_send';
    const OMNIPAY_REQUEST_SUCCESS = 'omnipay.request.sent';
    const OMNIPAY_REQUEST_ERROR = 'omnipay.request.error';
}
