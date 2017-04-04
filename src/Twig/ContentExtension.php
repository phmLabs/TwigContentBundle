<?php

namespace phmLabs\TwigContentBundle\Twig;

use Doctrine\Common\Cache\VoidCache;
use phmLabs\TwigContentBundle\Retriever\Retriever;
use Psr\Cache\CacheItemPoolInterface;

class ContentExtension extends \Twig_Extension
{
    private $cacheItemPool;
    private $retriever;

    public function __construct(Retriever $retriever, CacheItemPoolInterface $cacheItemPool = null)
    {
        $this->retriever = $retriever;

        if ($cacheItemPool) {
            $this->cacheItemPool = $cacheItemPool;
        } else {
            $this->cacheItemPool = new VoidCache();
        }
    }

    public function getTokenParsers()
    {
        return array(
            new ContentTokenParser($this->retriever, $this->cacheItemPool)
        );
    }

    public function getName()
    {
        return 'content';
    }
}
