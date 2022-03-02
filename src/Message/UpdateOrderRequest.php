<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

/**
 * Creates a Klarna Checkout order if it does not exist
 */
final class UpdateOrderRequest extends AbstractOrderRequest
{

    /**
     * @inheritDoc
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'transactionReference',
            'amount',
            'items'
        );

        $data = $this->getOrderData();


        return $data;
    }

    /**
     * @return string|null
     */
    public function getRenderUrl()
    {
        return $this->getParameter('render_url');
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidResponseException
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function sendData($data)
    {


        $response = $this->sendRequest(
            'PATCH',
            sprintf('/ordermanagement/v1/orders/%s/authorization', $this->getTransactionReference()),
            $data
        );


        return new UpdateOrderResponse($response->getStatusCode());
    }
}
