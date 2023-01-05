<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

final class CancelRequest extends AbstractRequest
{
    /**
     * {@inheritDoc}
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionReference');

        return null;
    }

    /**
     * @inheritdoc
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function sendData($data)
    {
        $response = $this->sendRequest(
            'POST',
            sprintf(
                '/ordermanagement/v1/orders/%s/cancel',
                $this->getTransactionReference()
            ),
            $data
        );

        return new CancelResponse(
            $this,
            $this->getResponseBody($response),
            $response->getStatusCode()
        );
    }
}
