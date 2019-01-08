<?php

namespace Xolvio\TruckvisionApi\Exceptions;

use Xolvio\TruckvisionApi\Exceptions\ResponseExceptions\TruckvisionApiMechanicHasClockingOpenException;
use Xolvio\TruckvisionApi\Exceptions\ResponseExceptions\TruckvisionApiNoLicenseException;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class TruckvisionApiResponseExceptionHandler
{
    /**
     * @const string
     */
    public const ERROR_STATUS_CODE = 'NOK';

    /**
     * @param TruckvisionResponseInterface $response
     *
     * @throws TruckvisionApiException
     * @throws TruckvisionApiMechanicHasClockingOpenException
     * @throws TruckvisionApiNoLicenseException
     */
    public static function handle(TruckvisionResponseInterface $response): void
    {
        $namespaces = $response->getNamespaces();
        $element    = $response->getBody();

        $status_code = (string) $element->children($namespaces['a'])->ReturnCode;

        if (self::ERROR_STATUS_CODE !== $status_code) {
            return;
        }

        $exception_message = (string) $element->children($namespaces['a'])->ErrorMessages->children($namespaces['b'])->string;

        if (false !== stripos($exception_message, 'Er staat voor deze monteur al een klokking open')) {
            throw new TruckvisionApiMechanicHasClockingOpenException($exception_message);
        }

        if (false !== stripos($exception_message, 'Er is geen licentie gevonden voor dit maatwerk')) {
            throw new TruckvisionApiNoLicenseException($exception_message);
        }

        throw new TruckvisionApiException((string) $element->children($namespaces['a'])->ErrorMessages->children($namespaces['b'])->string);
    }
}
