<?php

namespace phmLabs\TwigContentBundle\Retriever;

class NullRetriever extends Retriever
{
    protected function doRender($identifier)
    {
        return false;
    }
}
