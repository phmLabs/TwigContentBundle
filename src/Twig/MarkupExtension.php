<?php

namespace phmLabs\TwigContentBundle\Twig;

class MarkupExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('markup', array($this, 'enrich'), array(
                    'is_safe' => array('html'))
            ));
    }

    public function markup($string)
    {
        return self::markupString($string);
    }

    public static function markupString($string)
    {
        $url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
        $string = preg_replace($url, '<a href="$0" target="_blank">$0</a>', $string);

        return $string;
    }

    public function getName()
    {
        return "enrich";
    }
}
