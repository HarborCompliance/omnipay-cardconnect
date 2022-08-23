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

    public function getTransactionDate()
    {
        return $this->getParameter('transactionDate');
    }
    
    public function getPaymentOrigin()
    {
        return $this->getParameter('ecomind');
    }
    
    public function getBankAccountType()
    {
        return $this->getParameter('accttype');
    }

    public function getCapture()
    {
        return $this->getParameter('capture') ?? 'y';
    }
    
    public function getPurchaseOrderNumber()
    {
        return $this->getParameter('ponumber');
    }
    
    public function getOrderId()
    {
        return $this->getParameter('orderid');
    }
    
    public function getTaxAmount()
    {
        return $this->getParameter('taxamnt');
    }
    
    public function getDutyAmount()
    {
        return $this->getParameter('dutyamnt');
    }
    
    public function getOrderDate()
    {
        return $this->getParameter('orderdate');
    }
    
    public function getFreightAmount()
    {
        return $this->getParameter('frtamnt');
    }
    
    public function getToZipCode()
    {
        return $this->getParameter('shiptozip');
    }
    
    public function getFromZipCode()
    {
        return $this->getParameter('shipfromzip');
    }
    
    public function getCountry()
    {
        return $this->getParameter('shiptocountry');
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

    public function setPaymentOrigin($value)
    {
        return $this->setParameter('ecomind', $value);
    }
    
    public function setBankAccountType($value)
    {
        return $this->setParameter('accttype', $value);
    }

    public function setCapture($value)
    {
        return $this->setParameter('capture', $value);
    }
    
    public function setPurchaseOrderNumber($value)
    {
        return $this->setParameter('ponumber', $value);
    }
    
    public function setOrderId($value)
    {
        return $this->setParameter('orderid', $value);
    }
    
    public function setTaxAmount($value)
    {
        return $this->setParameter('taxamnt', $value);
    }
    
    public function setDutyAmount($value)
    {
        return $this->setParameter('dutyamnt', $value);
    }
    
    public function setOrderDate($value)
    {
        return $this->setParameter('orderdate', $value);
    }
    
    public function setFreightAmount($value)
    {
        return $this->setParameter('frtamnt', $value);
    }
    
    public function setToZipCode($value)
    {
        return $this->setParameter('shiptozip', $value);
    }
    
    public function setFromZipCode($value)
    {
        return $this->setParameter('shipfromzip', $value);
    }
    
    public function setCountry($value)
    {
        return $this->setParameter('shiptocountry', $value);
    }

    /**
     * Valid formats - MMDD or YYYYMMDD
     */
    public function setTransactionDate($value)
    {
        return $this->setParameter('transactionDate', $value);
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
