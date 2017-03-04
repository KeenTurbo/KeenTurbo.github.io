<?php

namespace AppBundle\Twig;

use AppBundle\Utils\HtmlPurifier;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class HtmlPurifierExtension extends \Twig_Extension
{
    /**
     * @var HtmlPurifier
     */
    private $purifier;

    /**
     * HtmlPurifierExtension constructor.
     *
     * @param $purifier
     */
    public function __construct(HtmlPurifier $purifier)
    {
        $this->purifier = $purifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('purify', [$this, 'purify'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function purify($text)
    {
        return $this->purifier->purify($text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'html_purifier_extension';
    }
}