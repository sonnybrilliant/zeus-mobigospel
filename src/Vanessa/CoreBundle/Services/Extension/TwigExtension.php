<?php

namespace Vanessa\CoreBundle\Services\Extension;

use \Twig_Filter_Function;
use \Twig_Filter_Method;

class TwigExtension extends \Twig_Extension
{

    /**
     * Return the functions registered as twig extensions
     * 
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'file_exists' => new \Twig_Function_Function('file_exists'),
            'rand' => new \Twig_Function_Function('rand')
        );
    }

    public function getName()
    {
        return 'twig_extension';
    }
}
?>