<?php

namespace AppBundle\Utils;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class HTMLPurifier
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function purify($text)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,ol,ul,li,img[src],blockquote,strong,u,em,a[href],br');

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify($text);
    }
}