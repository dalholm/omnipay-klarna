<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

final class UpdateMerchantReferencesRequest extends AbstractRequest
{
    /**
     * @return null
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionReference', 'merchant_reference1');

        return [
            'merchant_reference1' => $this->getMerchantReference1(),
            'merchant_reference2' => $this->getMerchantReference2(),
        ];
    }

    /**
     * @param mixed $data
     *
     * @return ExtendAuthorizationResponse
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function sendData($data): ExtendAuthorizationResponse
    {

        $responseBody = $this->getResponseBody(
            $this->sendRequest(
                'PATCH',
                sprintf('/ordermanagement/v1/orders/%s/merchant-references', $this->getTransactionReference()),
                $data
            )
        );

        return new ExtendAuthorizationResponse(
            $this,
            \array_merge(
                $responseBody,
                ['order_id' => $this->getTransactionReference()]
            )
        );
    }
}
