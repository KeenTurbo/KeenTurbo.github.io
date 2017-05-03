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
        $config->set('HTML.Allowed', 'p,ol,ul,li,img[src],blockquote,strong,b,i,em,u,del,a[href],br');
//        $config->set('AutoFormat.AutoParagraph', true);
        $config->set('AutoFormat.Linkify', true);
        $config->set('HTML.TargetBlank', true);
        $config->set('HTML.Nofollow', true);

        $purifier = new \HTMLPurifier($config);

        return $purifier->purify(nl2br($text));
    }
}