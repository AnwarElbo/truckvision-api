<?php


namespace Xolvio\TruckvisionApi\Request;


use SimpleXMLElement;
use Xolvio\TruckvisionApi\Response\AddOtherResponse;
use Xolvio\TruckvisionApi\Transaction\OtherCollection;
use Xolvio\TruckvisionApi\TruckvisionApi;
use Xolvio\TruckvisionApi\TruckvisionRequestInterface;
use Xolvio\TruckvisionApi\TruckvisionResponseInterface;

class AddOther implements TruckvisionRequestInterface
{
    /**
     * @var RequestTemplate
     */
    private $request_template;

    /**
     * @var OtherCollection
     */
    private $other_collection;

    /**
     * @var string
     */
    private $order_number;

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var string
     */
    private $language_code;

    public function __construct(
        OtherCollection $other_collection,
        string $order_number,
        string $user_name,
        string $language_code = 'NL'
    ) {
        $this->request_template = new RequestTemplate();
        $this->other_collection = $other_collection;
        $this->order_number     = $order_number;
        $this->user_name        = $user_name;
        $this->language_code    = $language_code;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $body = [
            'v' . TruckvisionApi::VERSION . ':AddOther' => [
                'v' . TruckvisionApi::VERSION . ':request' => [
                    'truc:LanguageCode' => $this->language_code,
                    'truc:OrderNumber' => $this->order_number,
                    'truc:Others' => $this->other_collection->toXmlArray(),
                    'truc:UserName' => $this->user_name
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
        return '/dossierservice/V' . TruckvisionApi::VERSION . '/IDossier/AddOther';
    }

    /**
     * @param SimpleXMLElement $element
     *
     * @return TruckvisionResponseInterface
     */
    public function setResponse(SimpleXMLElement $element): TruckvisionResponseInterface
    {
        return new AddOtherResponse($element);
    }
}