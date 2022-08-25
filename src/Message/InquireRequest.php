<?php

declare(strict_types=1);

namespace Omnipay\Cardconnect\Message;

class InquireRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');
        $data = [
            'merchid' => $this->getMerchantId(),
            'retref' => $this->getTransactionReference(),
        ];

        return $data;
    }

    public function sendData($data)
    {
        return $this->handleResponse($this->httpClient->request('GET', $this->getEndpoint($data), $this->getHeaders()));
    }

    public function getEndpoint($data)
    {
        return $this->getEndpointBase()."/inquire/{$data['retref']}/{$data['merchid']}";
    }
}
