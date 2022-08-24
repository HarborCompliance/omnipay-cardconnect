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
    
    public function getEcomind()
    {
        return $this->getParameter('ecomind');
    }
    
    public function getAccttype()
    {
        return $this->getParameter('accttype');
    }

    public function getCapture()
    {
        return $this->getParameter('capture') ?? 'y';
    }
    
    public function getPonumber()
    {
        return $this->getParameter('ponumber');
    }
    
    public function getOrderid()
    {
        return $this->getParameter('orderid');
    }
    
    public function getTaxamnt()
    {
        return $this->getParameter('taxamnt');
    }
    
    public function getDutyamnt()
    {
        return $this->getParameter('dutyamnt');
    }
    
    public function getOrderdate()
    {
        return $this->getParameter('orderdate');
    }
    
    public function getFrtamnt()
    {
        return $this->getParameter('frtamnt');
    }
    
    public function getShiptozip()
    {
        return $this->getParameter('shiptozip');
    }
    
    public function getShipfromzip()
    {
        return $this->getParameter('shipfromzip');
    }
    
    public function getShiptocountry()
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

    public function setEcomind($value)
    {
        return $this->setParameter('ecomind', $value);
    }
    
    public function setAccttype($value)
    {
        return $this->setParameter('accttype', $value);
    }

    public function setCapture($value)
    {
        return $this->setParameter('capture', $value);
    }
    
    public function setPonumber($value)
    {
        return $this->setParameter('ponumber', $value);
    }
    
    public function setOrderid($value)
    {
        return $this->setParameter('orderid', $value);
    }
    
    public function setTaxamnt($value)
    {
        return $this->setParameter('taxamnt', $value);
    }
    
    public function setDutyamnt($value)
    {
        return $this->setParameter('dutyamnt', $value);
    }
    
    public function setOrderdate($value)
    {
        return $this->setParameter('orderdate', $value);
    }
    
    public function setFrtamnt($value)
    {
        return $this->setParameter('frtamnt', $value);
    }
    
    public function setShiptozip($value)
    {
        return $this->setParameter('shiptozip', $value);
    }
    
    public function setShipfromzip($value)
    {
        return $this->setParameter('shipfromzip', $value);
    }
    
    public function setShiptocountry($value)
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
