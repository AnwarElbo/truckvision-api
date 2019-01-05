<?php

namespace Xolvio\TruckvisionApi\Exceptions;

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

        throw new TruckvisionApiException((string) $element->children($namespaces['a'])->ErrorMessages->children($namespaces['b'])->string);
    }
}
