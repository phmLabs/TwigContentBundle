<?php

namespace phmLabs\TwigContentBundle\Retriever;

class WordpressRetriever extends Retriever
{
    private $cmsBasePath;

    public function __construct($cmsBasePath)
    {
        $this->cmsBasePath = $cmsBasePath;
    }

    protected function doRender($identifier)
    {
        $content = @file_get_contents($this->cmsBasePath . $identifier);

        if (!$content) {
            return false;
        }

        $id = (int)substr($content, 4, 5);

        if ($content) {
            return '<span id="data-cms-id-' . $id . '" data-cms-id="' . $id . '">' . $content . '</span>';
        }
    }
}