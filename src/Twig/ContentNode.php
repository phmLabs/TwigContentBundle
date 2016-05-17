<?php
/**
 * Created by PhpStorm.
 * User: nils.langner
 * Date: 15.05.16
 * Time: 08:12
 */

namespace phmLabs\TwigContentBundle\Twig;


use phmLabs\TwigContentBundle\Retriever\Retriever;

class ContentNode extends \Twig_Node
{
    private $retriever;

    public function __construct($params, $lineno = 0, $tag = null, Retriever $retriever = null)
    {
        $this->retriever = $retriever;
        parent::__construct(array('params' => $params), array(), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $count = count($this->getNode('params'));

        if ($count == 1) {
            throw new \Twig_Error_Runtime('Content identifier is missing.');
        } else if ($count > 2) {
            throw new \Twig_Error_Runtime('Too many arguments.');
        }

        $compiler
            ->addDebugInfo($this);

        for ($i = 0; ($i < $count); $i++) {
            // argument is not an expression (such as, a \Twig_Node_Textbody)
            // we should trick with output buffering to get a valid argument to pass
            // to the functionToCall() function.
            if (!($this->getNode('params')->getNode($i) instanceof \Twig_Node_Expression)) {
                $compiler
                    ->write('ob_start();')
                    ->raw(PHP_EOL);

                $compiler
                    ->subcompile($this->getNode('params')->getNode($i));

                $compiler
                    ->write('$_content[] = ob_get_clean();')
                    ->raw(PHP_EOL);
            } else {
                $compiler
                    ->write('$_content[] = ')
                    ->subcompile($this->getNode('params')->getNode($i))
                    ->raw(';')
                    ->raw(PHP_EOL);
            }
        }

        $rawText = $this->retriever->render(
            $this->getNode('params')->getNode(1)->getAttribute('value'),
            $this->getNode('params')->getNode(0)->getAttribute('data'));

        $compiler
            ->raw('echo "' . str_replace('"', '\"', $rawText) . '";')
            ->raw(PHP_EOL);
    }

}