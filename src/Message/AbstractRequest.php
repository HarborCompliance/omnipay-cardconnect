<?php
/**
* Abstract class used to communicate with CardConnect.
*/

namespace Omnipay\Cardconnect\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $testEndpoint = 'https://fts.cardconnect.com:6443/cardconnect/rest';

    /*
     **********************************************************************
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
     **********************************************************************
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

    public function sendData($data)
    {
        return $this->handleResponse($this->httpClient->request('PUT', $this->getEndpoint(), $this->getHeaders(), json_encode($data)));
    }

    public function getHeaders()
    {
        $authHeader = 'Basic '.base64_encode($this->getApiUsername().':'.$this->getApiPassword());

        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $authHeader,
        ];
    }

    public function getEndpointBase()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint();
    }

    public function handleResponse($response)
    {
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getReasonPhrase());
        }

        $this->response = new Response($this, json_decode($response->getBody()->getContents(), true));

        return $this->response;
    }

    protected function liveEndpoint()
    {
        return 'https://'.$this->getApiHost().':'.$this->getApiPort().'/cardconnect/rest';
    }
}
