<?php

namespace Omnipay\Cardconnect\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();
        $card = $this->getCard();
    	$data = array(
    		'merchid'   => $this->getMerchantId(),
    		'account'   => $card->getNumber(),
    		'expiry'    => $card->getExpiryDate('m')."".$this->getCard()->getExpiryDate('y'),
    		'cvv2'      => $card->getCvv(),
    		'amount'    => $this->getAmountInteger(),
    		'currency'  => $this->getCurrency(),
    		'orderid'   => $this->getTransactionId(),
    		'name'      => $card->getName(),
    		'address'    => $card->getBillingAddress1(),
    		'city'      => $card->getBillingCity(),
    		'region'    => $card->getBillingState(),
    		'country'   => $card->getBillingCountry(),
    		'postal'    => $card->getBillingPostcode(),
            'retref'    => $this->getTransactionReference(),
    		'tokenize'  => "Y",
    		'capture'   => "Y",
            'userfields' => $this->getUserfields(),
            'email' => $card->getEmail()
    	);
        return $data;
    }

    public function getEndpoint()
    {
        return $this->getEndpointBase() . "/auth";
    }
    
        public function setUserfields($value)
    {
        return $this->setParameter('userfields', $value);
    }

    public function getUserfields()
    {
        return $this->getParameter('userfields');
    }
}
