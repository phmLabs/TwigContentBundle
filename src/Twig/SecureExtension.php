<?php

namespace phmLabs\TwigContentBundle\Twig;

class SecureExtension extends \Twig_Extension
{
    const ALLOWED_TAGS = '<span></span><pre></pre><ul></ul><a></a><li></li><br><p></p><div></div><strong></strong><table></table><tr></tr><td></td>';

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('secure', array($this, 'secure'), array(
                    'is_safe' => array('html'))
            ));
    }

    public function secure($string)
    {
        return self::secureString($string);
    }

    public static function secureString($string)
    {
        $pattern = '^://(.*):(.*)@^';
        $pattern = '#://[^\s]+:[^\s]+@#';

        $strippedString = strip_tags($string, self::ALLOWED_TAGS);
        $strippedString = preg_replace($pattern, '://****:****@', $strippedString);

        return $strippedString;
    }

    public function getName()
    {
        return "secure";
    }
}
