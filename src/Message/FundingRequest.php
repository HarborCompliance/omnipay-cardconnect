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
        $response = $this->httpClient->request('GET', $this->getEndpoint($data), $this->getHeaders());

        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getReasonPhrase());
        }

        $json = json_decode($response->getBody()->getContents(), true);

        $this->response = new Response($this, [
            'respcode' => $json['respcode'] ?? null,
            'voidable' => isset($json['voidable']) && $json['voidable'] === 'Y',
            'refundable' => isset($json['refundable']) && $json['refundable'] === 'Y',
        ]);

        return $this->response;
    }

    public function getEndpoint($data)
    {
        $queryString = http_build_query($data);

        return $this->getEndpointBase()."/funding?{$queryString}";
    }
}
