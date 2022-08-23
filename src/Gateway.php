<?php

namespace Omnipay\Cardconnect;

use Omnipay\Common\AbstractGateway;

/**
 * Cardconnect Gateway.
 *
 * This gateway is useful for testing. It simply authorizes any payment made using a valid
 * credit card number and expiry.
 *
 * Any card number which passes the Luhn algorithm and ends in an even number is authorized,
 * for example: 4242424242424242
 *
 * Any card number which passes the Luhn algorithm and ends in an odd number is declined,
 * for example: 4111111111111111
 *
 * ### Example
 *
 * <code>
 * // Create a gateway for the Cardconnect Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Cardconnect');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'testMode' => true, // Doesn't really matter what you use here.
 * ));
 *
 * // Create a credit card object
 * // This card can be used for testing.
 * $card = new CreditCard(array(
 *             'firstName'    => 'Example',
 *             'lastName'     => 'Customer',
 *             'number'       => '4242424242424242',
 *             'expiryMonth'  => '01',
 *             'expiryYear'   => '2020',
 *             'cvv'          => '123',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'amount'                   => '10.00',
 *     'currency'                 => 'AUD',
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Cardconnect';
    }

    /*
     ★ ★ ★ Jeremy Bueler (buelerj) *************************************
         Getters
    **********************************************************************
    */

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function getApiHost()
    {
        return $this->getParameter('apiHost');
    }

    public function getApiPort()
    {
        return $this->getParameter('apiPort');
    }

    public function getApiUsername()
    {
        return $this->getParameter('apiUsername');
    }

    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    /*
     ★ ★ ★ Jeremy Bueler (buelerj) *************************************
         Setters
    **********************************************************************
    */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function setApiUsername($value)
    {
        return $this->setParameter('apiUsername', $value);
    }

    public function setApiHost($value)
    {
        return $this->setParameter('apiHost', $value);
    }

    public function setApiPort($value)
    {
        return $this->setParameter('apiPort', $value);
    }

    public function setApiPassword($value)
    {
        return $this->setParameter('apiPassword', $value);
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    /*
     ★ ★ ★ Jeremy Bueler (buelerj) *************************************

    **********************************************************************
    */

    public function getDefaultParameters()
    {
        $params = [
            'merchantId' => '496160873888', // As indicated on https://developer.cardconnect.com/guides/cardpointe-gateway
            'apiHost' => '',
            'apiUsername' => 'testing',
            'apiPassword' => 'testing123',
            'testMode' => true,
          ];

        return $params;
    }

    /**
     * Create an authorize request.
     *
     * @return \Omnipay\Cardconnect\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\AuthorizeRequest', $parameters);
    }
    
    /**
     * Create an authorize ach request.
     *
     * @return \Omnipay\Cardconnect\Message\AuthorizeAchRequest
     */
    public function authorizeAch(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\AuthorizeAchRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @return \Omnipay\Cardconnect\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create a capture request.
     *
     * @return \Omnipay\Cardconnect\Message\CaptureRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\CaptureRequest', $parameters);
    }

    /**
     * Create a void request.
     *
     * @return \Omnipay\Cardconnect\Message\VoidRequest
     */
    public function void(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\VoidRequest', $parameters);
    }

    /**
     * Create a refund request.
     *
     * @return \Omnipay\Cardconnect\Message\RefundRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\RefundRequest', $parameters);
    }
    
    /**
     * Create a funding request.
     *
     * @return \Omnipay\Cardconnect\Message\FundingRequest
     */
    public function funding(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\FundingRequest', $parameters);
    }
    
    /**
     * Create a inquire request.
     *
     * @return \Omnipay\Cardconnect\Message\InquireRequest
     */
    public function inquire(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\InquireRequest', $parameters);
    }

    /**
     * Get transaction status.
     *
     * @return void
     */
    public function status(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Cardconnect\Message\InquireRequest', $parameters);
    }
}
