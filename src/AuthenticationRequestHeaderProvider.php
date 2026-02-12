<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna;

use Dalholm\Omnipay\Klarna\Message\AbstractRequest;

final class AuthenticationRequestHeaderProvider
{
    public function getHeaders(AbstractRequest $request): array
    {
        $headers = [
            'Authorization' => sprintf(
                'Basic %s',
                base64_encode(
                    sprintf(
                        '%s:%s',
                        $request->getUsername(),
                        $request->getSecret()
                    )
                )
            ),
        ];

        if ($request->getUserAgent() != '') {
            $headers['User-Agent'] = $request->getUserAgent();
        }

        if ($request->getPartnerId() != '') {
            $headers['Kustom-Partner'] = $request->getPartnerId();
        }

        return $headers;
    }
}
