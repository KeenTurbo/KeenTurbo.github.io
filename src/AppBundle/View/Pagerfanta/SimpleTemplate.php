<?php

namespace AppBundle\View\Pagerfanta;

use Pagerfanta\View\Template\Template;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class SimpleTemplate extends Template
{
    static protected $defaultOptions = [
        'prev_message'        => '‹ 上一页',
        'next_message'        => '下一页 ›',
        'css_container_class' => 'pagination',
        'css_prev_class'      => 'pagination-item-previous',
        'css_next_class'      => 'pagination-item-next',
        'css_disabled_class'  => 'disabled'
    ];

    public function container()
    {
        return sprintf('<div class="%s">%%pages%%</div>',
            $this->option('css_container_class')
        );
    }

    public function page($page)
    {
    }

    public function pageWithText($page, $text)
    {
    }

    private function pageWithTextAndClass($page, $text, $class)
    {
        $href = $this->generateRoute($page);

        return $this->link($class, $href, $text);
    }

    public function previousDisabled()
    {
        $class = $this->previousDisabledClass();
        $text = $this->option('prev_message');

        return $this->span($class, $text);
    }

    private function previousDisabledClass()
    {
        return $this->option('css_prev_class') . ' ' . $this->option('css_disabled_class');
    }

    public function previousEnabled($page)
    {
        $text = $this->option('prev_message');
        $class = $this->option('css_prev_class');

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    public function nextDisabled()
    {
        $class = $this->nextDisabledClass();
        $text = $this->option('next_message');

        return $this->span($class, $text);
    }

    private function nextDisabledClass()
    {
        return $this->option('css_next_class') . ' ' . $this->option('css_disabled_class');
    }

    public function nextEnabled($page)
    {
        $text = $this->option('next_message');
        $class = $this->option('css_next_class');

        return $this->pageWithTextAndClass($page, $text, $class);
    }

    public function first()
    {
    }

    public function last($page)
    {
    }

    public function current($page)
    {
    }

    public function separator()
    {
    }

    private function link($class, $href, $text)
    {
        return sprintf('<a class="%s" href="%s">%s</a>', $class, $href, $text);
    }

    private function span($class, $text)
    {
        return sprintf('<span class="%s">%s</span>', $class, $text);
    }
}