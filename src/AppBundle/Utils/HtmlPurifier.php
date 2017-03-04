<?php

namespace AppBundle\Utils;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class HtmlPurifier
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function purify($text)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,ol,ul,li,img[src],blockquote,strong,u,em,a[href]');

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($text);
    }
}