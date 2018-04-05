<?php

namespace phmLabs\TwigContentBundle\Retriever;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class HttpRetriever extends Retriever
{
    private $cmsBasePath;

    public function __construct($cmsBasePath)
    {
        $this->cmsBasePath = $cmsBasePath;
    }

    protected function doRender($identifier)
    {
        $url = str_replace('#identifier#', $identifier, $this->cmsBasePath);

        $client = new Client();
        $response = $client->get(new Uri($url), ['connect_timeout' => 5, 'timeout' => 3.14]);
        $content = (string)$response->getBody();

        if (!$content) {
            return false;
        }

        $id = (int)substr($content, 4, 5);

        if ($content) {
            return '<span id="data-cms-id-' . $id . '" data-cms-id="' . $id . '">' . $content . '</span>';
        }
    }
}
