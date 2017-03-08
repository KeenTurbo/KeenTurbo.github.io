<?php

namespace AppBundle\Utils;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class Markdown
{
    /**
     * @var \Parsedown
     */
    private $parser;

    /**
     * @var HTMLPurifier
     */
    private $purifier;

    /**
     * Markdown constructor.
     *
     * @param HTMLPurifier $purifier
     */
    public function __construct(HTMLPurifier $purifier)
    {
        $this->purifier = $purifier;

        $this->parser = new \Parsedown();
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function toHtml($text)
    {
        $html = $this->parser->text($text);

        $safeHtml = $this->purifier->purify($html);

        return $safeHtml;
    }
}
