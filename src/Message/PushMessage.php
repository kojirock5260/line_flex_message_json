<?php


namespace Kojirock5260\SimpleLineFlexMessage\Message;


use Kojirock5260\SimpleLineFlexMessage\Builder\MessageBuilderInterface;
use Kojirock5260\SimpleLineFlexMessage\Exception\LinePushMessageException;
use Kojirock5260\SimpleLineFlexMessage\Request\CurlRequest;

class PushMessage
{
    const BASE_URL = "https://api.line.me/v2/bot/";

    /**
     * @var string
     */
    private $channelAccessToken;

    /**
     * PushMessage constructor.
     * @param $channelAccessToken
     */
    public function __construct($channelAccessToken)
    {
        $this->channelAccessToken = $channelAccessToken;
        $this->httpRequest        = new CurlRequest();
    }

    /**
     * @param $to
     * @param MessageBuilderInterface $messageBuilder
     * @param bool $notificationDisabled
     * @throws LinePushMessageException
     * @return bool
     */
    public function execute($to, MessageBuilderInterface $messageBuilder, $notificationDisabled = false)
    {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken
        ];

        $postData = [
            'to'                   => $to,
            'messages'             => [$messageBuilder->build()],
            'notificationDisabled' => $notificationDisabled,
        ];

        $this->httpRequest->init();
        $this->httpRequest->setOption(CURLOPT_HTTPHEADER, $headers);
        $this->httpRequest->setOption(CURLOPT_URL, self::BASE_URL . 'message/push');
        $this->httpRequest->setOption(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->httpRequest->setOption(CURLOPT_POSTFIELDS, json_encode($postData));
        $this->httpRequest->setOption(CURLOPT_RETURNTRANSFER, true);

        try {
            $response = $this->httpRequest->execute();
            if ($this->httpRequest->errorNumber() !== 0) {
                throw new ($this->httpRequest->errorString());
            }

            $jsonData = json_decode($response, true);
            if (isset($jsonData['message'])) {
                throw new \Exception($jsonData['message']);
            }
        } catch (\Exception $e) {
            new LinePushMessageException($e->getMessage());
        } finally {
            $this->httpRequest->close();
        }

        return true;
    }
}