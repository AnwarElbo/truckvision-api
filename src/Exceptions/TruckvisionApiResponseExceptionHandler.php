<?php

namespace Xolvio\TruckvisionApi\Exceptions;

use Xolvio\TruckvisionApi\Exceptions\ResponseExceptions\TruckvisionApiMechanicHasClockingOpenException;
use Xolvio\TruckvisionApi\Exceptions\ResponseExceptions\TruckvisionApiNoLicenseException;

class TruckvisionApiResponseExceptionHandler
{
    /**
     * @const string
     */
    public const ERROR_STATUS_CODE = 'NOK';

    /**
     * @param \SimpleXMLElement $element
     * @param array             $namespaces
     *
     * @throws TruckvisionApiException
     */
    public static function handle(\SimpleXMLElement $element, array $namespaces): void
    {
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
