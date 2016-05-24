<?php

namespace phmLabs\TwigContentBundle\Retriever;

class HttpRetriever extends Retriever
{
    private $cmsBasePath;

    public function __construct($cmsBasePath)
    {
        $this->cmsBasePath = $cmsBasePath;
    }

    protected function doRender($identifier)
    {
        $content = @file_get_contents(str_replace('#identifier#', $identifier, $this->cmsBasePath));

        if (!$content) {
            return false;
        }

        $id = (int)substr($content, 4, 5);

        if ($content) {
            return '<span id="data-cms-id-' . $id . '" data-cms-id="' . $id . '">' . $content . '</span>';
        }
    }
}
