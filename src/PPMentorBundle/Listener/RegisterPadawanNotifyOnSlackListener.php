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
        $firstName = strpos($padawan->getName(), ' ') !== false ?
            substr($padawan->getName(), 0, strpos($padawan->getName(), ' ') + 1) :
            $padawan->getName();

        $text = "<!group>: Another Daniel-san is looking for a Mr. Miyagi!\n" .
                "\n" .
                "Name: *{$padawan->getName()}​*\n" .
                "E-mail: *​{$padawan->getEmail()}*​\n" .
                "Skills to learn/improve: ​*{$padawan->getSkills()}*​\n" .
                "\n" .
                "Who will teach ​*{$firstName}*​ how to WAX ON, WAX OFF?\n" .
                "\n" ;

        $payload = json_encode([
            "text" => $text,
            "username" => "MENTOR REQUEST",
            "icon_url" => "http://cdn.meme.am/images/60x60/11603508.jpg"
        ]);

        $this->restClient->post($this->slackHookUrl, $payload);
    }
}