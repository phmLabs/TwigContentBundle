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

        if (strpos($identifier, 'email') === false) {
            $content = '<span data-cms-identifier="' . $identifier . '" class="cms-identifier" style="display:none">' . $identifier . '</span><span class="cms-content" data-cms-identifier="' . $identifier . '">' . $content . "</span>";
        }

        return $content;
    }

    abstract protected function doRender($identifier);
}