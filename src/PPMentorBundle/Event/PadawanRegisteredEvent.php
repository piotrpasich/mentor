<?php

namespace PPMentorBundle\Event;

use PPMentorBundle\Entity\Padawan;
use Symfony\Component\EventDispatcher\Event;

class PadawanRegisteredEvent extends Event
{

    /**
     * @var Padawan
     */
    protected $padawan;

    public function __construct(Padawan $padawan)
    {
        $this->padawan = $padawan;
    }

    /**
     * @return Padawan
     */
    public function getPadawan()
    {
        return $this->padawan;
    }
}