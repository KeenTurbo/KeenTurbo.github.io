<?php

namespace AppBundle\Twig;

use AppBundle\Utils\Markdown;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class MarkdownExtension extends \Twig_Extension
{
    /**
     * @var Markdown
     */
    private $parser;

    /**
     * MarkdownExtension constructor.
     *
     * @param Markdown $parser
     */
    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('md2html', [$this, 'markdownToHtml'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function markdownToHtml($text)
    {
        return $this->parser->toHtml($text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'markdown_extension';
    }
}