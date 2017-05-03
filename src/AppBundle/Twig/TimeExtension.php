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
        $now = new \DateTime();
        $difference = $now->getTimestamp() - $time->getTimestamp();

        $distanceInSeconds = round(abs($difference));
        $distanceInMinutes = round((abs($difference) / 60));
        $distanceInHours = round((abs($difference) / 60 / 60));
        $hoursOfToday = intval($now->format('G'));

        if ($distanceInMinutes < 1) {
            if ($distanceInSeconds < 5) {
                return '刚刚';
            }

            return sprintf('%d秒前', $distanceInSeconds);
        }

        if ($distanceInMinutes < 60) {
            return sprintf('%d分钟前', $distanceInMinutes);
        }

        if ($distanceInHours <= $hoursOfToday) {
            return $time->format('今天 H:i');
        }

        if ($distanceInHours <= $hoursOfToday + 24) {
            return $time->format('昨天 H:i');
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