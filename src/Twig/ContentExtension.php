<?php
/**
 * Created by PhpStorm.
 * User: nils.langner
 * Date: 15.05.16
 * Time: 08:14
 */

namespace phmLabs\TwigContentBundle\Twig;

use phmLabs\TwigContentBundle\Retriever\Retriever;

class ContentExtension extends \Twig_Extension
{
    public function __construct(Retriever $retriever)
    {
        $this->retriever = $retriever;
    }

    public function getTokenParsers()
    {
        return array(
            new ContentTokenParser($this->retriever)
        );
    }

    public function getName()
    {
        return 'content';
    }
}
