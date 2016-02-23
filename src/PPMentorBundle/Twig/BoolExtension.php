<?php

namespace PPMentorBundle\Twig;

class BoolExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('boolean', array($this, 'booleanFilter')),
        );
    }

    public function booleanFilter($value)
    {
        if ($value) {
            return "Yes";
        } else {
            return "No";
        }
    }

    public function getName()
    {
        return 'bool_extension';
    }
}