<?php


namespace Kojirock5260\SimpleLineFlexMessage\Builder;


class MessageBuilder implements MessageBuilderInterface
{
    /**
     * @var MessageBuilderJson
     */
    private $messageBuilderJson;

    /**
     * MessageBuilder constructor.
     * @param MessageBuilderJson $messageBuilderJson
     */
    public function __construct(MessageBuilderJson $messageBuilderJson)
    {
        $this->messageBuilderJson = $messageBuilderJson;
    }

    /**
     * @return array
     */
    public function build()
    {
        return json_decode($this->buildForJson(), true);
    }

    /**
     * @param MessageBuilderJson $messageBuilderJson
     * @return string
     */
    private function buildForJson()
    {
        return <<<Json
{
  "type": "flex",
  "altText": "{$this->messageBuilderJson->getAltText()}",
  "contents": {$this->messageBuilderJson->getContents()}
}
Json;
    }
}