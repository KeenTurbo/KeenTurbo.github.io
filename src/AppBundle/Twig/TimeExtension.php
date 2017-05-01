<?php

namespace AppBundle\Twig;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TimeExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('ago', [$this, 'agoFilter'])
        ];
    }

    /**
     * @param \DateTime $time
     *
     * @return string
     */
    public function agoFilter(\DateTime $time)
    {
        $difference = time() - $time->format('U');

        $distanceInSeconds = round(abs($difference));
        $distanceInMinutes = round((abs($difference) / 60));

        if ($distanceInMinutes < 1) {
            if ($distanceInSeconds < 5) {
                return '刚刚';
            }

            return '几秒前';
        }

        if ($distanceInMinutes < 60) {
            return sprintf('%d分钟前', $distanceInMinutes);
        }

        if ($distanceInMinutes <= 1440) {
            return sprintf('%d小时前', round($distanceInMinutes / 60));
        }

        return $time->format('n月j日 H:i');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'time_extension';
    }
}