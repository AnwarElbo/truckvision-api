<?php


namespace Xolvio\TruckvisionApi\Request;


use SimpleXMLElement;
use Xolvio\TruckvisionApi\Response\ChangeTransactionProcessIdResponse;
use Xolvio\TruckvisionApi\TruckvisionApi;
use Xolvio\TruckvisionApi\TruckvisionRequestInterface;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class ChangeTransactionProcessId implements TruckvisionRequestInterface
{
    /**
     * @var RequestTemplate
     */
    private $request_template;

    /**
     * @var int
     */
    private $transaction_id;

    /**
     * @var string
     */
    private $process_code;

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var string
     */
    private $language_code;

    public function __construct(
        int $transaction_id,
        string $process_code,
        string $user_name,
        string $language_code = 'NL'
    ) {
        $this->request_template = new RequestTemplate();
        $this->transaction_id = $transaction_id;
        $this->process_code   = $process_code;
        $this->user_name      = $user_name;
        $this->language_code  = $language_code;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $body = [
            'v' . TruckvisionApi::VERSION . ':ChangeTransactionProcessId' => [
                'v' . TruckvisionApi::VERSION . ':request' => [
                    'dos:FileTransactionId' => $this->transaction_id,
                    'dos:LanguageCode' => $this->language_code,
                    'dos:ProcessIdCode' => $this->process_code,
                    'dos:UserName' => $this->user_name
                ]
            ]
        ];

        $this->request_template->setBody($body);

        return $this->request_template->toString();
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return '/dossierservice/V' . TruckvisionApi::VERSION . '/IDossier/ChangeTransactionProcessId';
    }

    /**
     * @param SimpleXMLElement $element
     *
     * @return TruckvisionResponseInterface
     */
    public function setResponse(SimpleXMLElement $element): TruckvisionResponseInterface
    {
        return new ChangeTransactionProcessIdResponse($element);
    }
}