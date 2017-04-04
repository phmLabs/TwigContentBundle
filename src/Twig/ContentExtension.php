<?php

namespace phmLabs\TwigContentBundle\Twig;

use Doctrine\Common\Cache\VoidCache;
use phmLabs\TwigContentBundle\Retriever\Retriever;
use Psr\Cache\CacheItemPoolInterface;

class ContentExtension extends \Twig_Extension
{
    private $retriever;

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
