<?php

namespace phmLabs\TwigContentBundle\Retriever;

abstract class Retriever
{
    final public function render($identifier, $fallback = '')
    {
        $content = $this->doRender($identifier);

        if (!$content) {
            $content = $fallback;
        }

        $content = '<span data-cms-identifier="' . $identifier . '" class="cms-identifier">' . $identifier . '</span><span class="cms-content" data-cms-identifier="' . $identifier . '">' . $content . "</span>";

        return $content;
    }

    abstract protected function doRender($identifier);
}