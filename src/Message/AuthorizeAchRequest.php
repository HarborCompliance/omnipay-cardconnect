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
            'ecomind' => $this->getPaymentOrigin(),
            'accttype' => $this->getBankAccountType(),
            'capture' => $this->getCapture(),
            'ponumber' => $this->getPurchaseOrderNumber(),
            'orderid' => $this->getOrderId(),
            'taxamnt' => $this->getTaxAmount(),
            'dutyamnt' => $this->getDutyAmount(),
            'orderdate' => $this->getOrderDate(),
            'frtamnt' => $this->getFreightAmount(),
            'shiptozip' => $this->getToZipCode(),
            'shipfromzip' => $this->getFromZipCode(),
            'shiptocountry' => $this->getCountry(),
            'items' => $this->getItems(),
        ];
    }

    public function getEndpoint()
    {
        return $this->getEndpointBase().'/auth';
    }
}
