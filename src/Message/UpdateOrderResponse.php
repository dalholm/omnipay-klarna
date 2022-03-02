<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna\Message;

use Omnipay\Common\Message\RequestInterface;

final class UpdateOrderResponse extends AbstractResponse
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @param int              $statusCode
     */
    public function __construct( $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && 204 === $this->statusCode;
    }
}
