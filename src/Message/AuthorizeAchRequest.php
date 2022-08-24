<?php

namespace Omnipay\Cardconnect\Message;

class AuthorizeAchRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'token', 'accttype', 'ecomind');

        return [
            'merchid' => $this->getMerchantId(),
            'account' => $this->getToken(),
            'ecomind' => $this->getEcomind(),
            'accttype' => $this->getAccttype(),
            'capture' => $this->getCapture(),
            'ponumber' => $this->getPonumber(),
            'orderid' => $this->getOrderid(),
            'taxamnt' => $this->getTaxamnt(),
            'dutyamnt' => $this->getDutyamnt(),
            'orderdate' => $this->getOrderDate(),
            'frtamnt' => $this->getFrtamnt(),
            'shiptozip' => $this->getShiptozip(),
            'shipfromzip' => $this->getShipfromzip(),
            'shiptocountry' => $this->getShiptocountry(),
            'items' => $this->getItems(),
        ];
    }

    public function getEndpoint()
    {
        return $this->getEndpointBase().'/auth';
    }
}
