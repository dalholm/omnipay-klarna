<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna;

use Dalholm\Omnipay\Klarna\Message\AcknowledgeRequest;
use Dalholm\Omnipay\Klarna\Message\AuthorizeRequest;
use Dalholm\Omnipay\Klarna\Message\CaptureRequest;
use Dalholm\Omnipay\Klarna\Message\ExtendAuthorizationRequest;
use Dalholm\Omnipay\Klarna\Message\FetchTransactionRequest;
use Dalholm\Omnipay\Klarna\Message\RefundRequest;
use Dalholm\Omnipay\Klarna\Message\UpdateCustomerAddressRequest;
use Dalholm\Omnipay\Klarna\Message\UpdateMerchantReferencesRequest;
use Dalholm\Omnipay\Klarna\Message\UpdateOrderRequest;
use Dalholm\Omnipay\Klarna\Message\UpdateTransactionRequest;
use Dalholm\Omnipay\Klarna\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

final class Gateway extends AbstractGateway implements GatewayInterface
{
    const API_VERSION_EUROPE = 'EU';
    const API_VERSION_NORTH_AMERICA = 'NA';

    const EU_BASE_URL = 'https://api.klarna.com';
    const EU_TEST_BASE_URL = 'https://api.playground.klarna.com';
    const NA_BASE_URL = 'https://api-na.klarna.com';
    const NA_TEST_BASE_URL = 'https://api-na.playground.klarna.com';

    /**
     * @inheritdoc
     */
    public function acknowledge(array $options = []): RequestInterface
    {
        return $this->createRequest(AcknowledgeRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function authorize(array $options = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    public function updateOrder(array $options = [])
    {
        return $this->createRequest(UpdateOrderRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function capture(array $options = [])
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function extendAuthorization(array $options = []): RequestInterface
    {
        return $this->createRequest(ExtendAuthorizationRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function fetchTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    /**
     * @return string REGION_* constant value
     */
    public function getApiRegion(): string
    {
        return $this->getParameter('api_region');
    }

    /**
     * @inheritDoc
     */
    public function getDefaultParameters(): array
    {
        return [
            'api_region' => self::API_VERSION_EUROPE,
            'secret' => '',
            'testMode' => true,
            'username' => '',
            'user_agent' => '',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Klarna';
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getParameter('secret');
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getParameter('username');
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->getParameter('user_agent');
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);

        $this->setBaseUrl();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function refund(array $options = [])
    {
        return $this->createRequest(RefundRequest::class, $options);
    }

    /**
     * @param string $region
     *
     * @return $this
     */
    public function setApiRegion(string $region): self
    {
        $this->setParameter('api_region', $region);

        return $this;
    }

    /**
     * @param string $secret
     *
     * @return $this
     */
    public function setSecret(string $secret): self
    {
        $this->setParameter('secret', $secret);

        return $this;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->setParameter('username', $username);

        return $this;
    }

    /**
     * @param string $userAgent
     *
     * @return $this
     */
    public function setUserAgent(string $userAgent): self
    {
        $this->setParameter('user_agent', $userAgent);

        return $this;
    }

    public function setTestMode($testMode): self
    {
        parent::setTestMode($testMode);

        $this->setBaseUrl();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function updateCustomerAddress(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateCustomerAddressRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function updateTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateTransactionRequest::class, $options);
    }

    public function updateMerchantReferences(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateMerchantReferencesRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function void(array $options = [])
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

    private function setBaseUrl()
    {
        if (self::API_VERSION_EUROPE === $this->getApiRegion()) {
            $this->parameters->set('base_url', $this->getTestMode() ? self::EU_TEST_BASE_URL : self::EU_BASE_URL);

            return;
        }

        $this->parameters->set('base_url', $this->getTestMode() ? self::NA_TEST_BASE_URL : self::NA_BASE_URL);
    }
}
