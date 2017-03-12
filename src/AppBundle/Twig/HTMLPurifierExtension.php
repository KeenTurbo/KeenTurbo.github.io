<?php

namespace AppBundle\Twig;

use AppBundle\Utils\HTMLPurifier;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class HTMLPurifierExtension extends \Twig_Extension
{
    /**
     * @var HTMLPurifier
     */
    private $purifier;

    /**
     * HTMLPurifierExtension constructor.
     *
     * @param HTMLPurifier $purifier
     */
    public function __construct(HTMLPurifier $purifier)
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