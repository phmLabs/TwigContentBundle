<?php

namespace phmLabs\TwigContentBundle\Twig;

use phmLabs\TwigContentBundle\Retriever\Retriever;
use Psr\Cache\CacheItemPoolInterface;

class ContentTokenParser extends \Twig_TokenParser
{
    private $retriever;

    public function __construct(Retriever $retriever)
    {
        $this->retriever = $retriever;
    }

    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();

        $stream = $this->parser->getStream();

        // recovers all inline parameters close to your tag name
        $params = array_merge(array(), $this->getInlineParams($token));

        $continue = true;
        while ($continue) {
            // create subtree until the decideMyTagFork() callback returns true
            $body = $this->parser->subparse(array($this, 'decideMyTagFork'));

            // I like to put a switch here, in case you need to add middle tags, such
            // as: {% mytag %}, {% nextmytag %}, {% endmytag %}.
            $tag = $stream->next()->getValue();

            switch ($tag) {
                case 'endcontent':
                    $continue = false;
                    break;
                default:
                    throw new \Twig_Error_Syntax(sprintf('Unexpected end of template. Twig was looking for the following tags "endmytag" to close the "mytag" block started at line %d)', $lineno), -1);
            }

            // you want $body at the beginning of your arguments
            array_unshift($params, $body);

            // if your endmytag can also contains params, you can uncomment this line:
            // $params = array_merge($params, $this->getInlineParams($token));
            // and comment this one:
            $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        }

        return new ContentNode(new \Twig_Node($params), $lineno, $this->getTag(), $this->retriever);
    }

    /**
     * Recovers all tag parameters until we find a BLOCK_END_TYPE ( %} )
     *
     * @param \Twig_Token $token
     * @return array
     */
    protected function getInlineParams(\Twig_Token $token)
    {
        $stream = $this->parser->getStream();
        $params = array();
        while (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            $params[] = $this->parser->getExpressionParser()->parseExpression();
        }
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        return $params;
    }

    /**
     * Callback called at each tag name when subparsing, must return
     * true when the expected end tag is reached.
     *
     * @param \Twig_Token $token
     * @return bool
     */
    public function decideMyTagFork(\Twig_Token $token)
    {
        return $token->test(array('endcontent'));
    }

    /**
     * Your tag name: if the parsed tag match the one you put here, your parse()
     * method will be called.
     *
     * @return string
     */
    public function getTag()
    {
        return 'content';
    }

}