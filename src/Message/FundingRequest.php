<?php

declare(strict_types=1);

namespace Omnipay\Cardconnect\Message;

class FundingRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionDate');

        return [
            'merchid' => $this->getMerchantId(),
            'date' => $this->getTransactionDate(),
        ];
    }

    public function sendData($data)
    {
        return $this->handleResponse($this->httpClient->request('GET', $this->getEndpoint($data), $this->getHeaders()));
    }

    public function getEndpoint($data)
    {
        $queryString = http_build_query($data);

        return $this->getEndpointBase()."/funding?{$queryString}";
    }
}
