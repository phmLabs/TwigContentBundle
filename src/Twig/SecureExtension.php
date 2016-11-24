<?php
/**
 * Created by PhpStorm.
 * User: nils.langner
 * Date: 19.05.16
 * Time: 09:00
 */

namespace phmLabs\TwigContentBundle\Twig;

class SecureExtension extends \Twig_Extension
{
    private $allowedTags = '<pre></pre><ul></ul><a></a><li></li><br><p></p><div></div><strong></strong><table></table><tr></tr><td></td>';

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('secure', array($this, 'secure'), array(
                    'is_safe' => array('html'))
            ));
    }

    public function secure($string)
    {
        return strip_tags($string, $this->allowedTags);
    }

    public function getName()
    {
        return "secure";
    }
}
