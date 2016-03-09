<?php

namespace PPMentorBundle\Listener;

use PPMentorBundle\Event\PadawanRegisteredEvent;
use Circle\RestClientBundle\Services\RestClient;

class RegisterPadawanNotifyOnSlackListener
{

    protected $slackHookUrl;

    /**
     * @var RestClient
     */
    protected $restClient;

    public function __construct(RestClient $restClient, $slackHookUrl)
    {
        $this->slackHookUrl = $slackHookUrl;
        $this->restClient = $restClient;
    }

    public function notify(PadawanRegisteredEvent $padawanRegisteredEvent)
    {
        $padawan = $padawanRegisteredEvent->getPadawan();
        $text = "Greeting Heroes! New padawan just registered. \n" .
                "{$padawan->getName()}({$padawan->getEmail()}) with {$padawan->getSkills()} skills. ";

        $payload = json_encode([
            "text" => $text,
            "username" => "Miyagi",
            "icon_url" => "http://cdn.meme.am/images/60x60/11603508.jpg"
        ]);

        $this->restClient->post($this->slackHookUrl, $payload);
    }
}