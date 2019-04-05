<?php

namespace phmLabs\TwigContentBundle\Twig;

class DurationExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('duration', array($this, 'duration'), array(
                    'is_safe' => array('html'))
            ));
    }

    private function format($duration, $unit, $format)
    {
        $result = str_replace('#duration#', $duration, $format);

        $result = str_replace('#unit#', $unit . 's', $result);

        if ($duration == 1) {
            $result = str_replace('#units#', $unit, $result);
        } else {
            $result = str_replace('#units#', $unit . 's', $result);
        }

        return $result;
    }

    public function duration($duration, $unit = 'min', $format = '#duration# #units#')
    {
        switch ($unit) {
            case 'min':
                if ($duration < 60) {
                    return $this->format(round($duration), 'minute', $format);
                } else {
                    return $this->duration($duration / 60, 'hour', $format);
                }
                break;
            case 'hour':
                if ($duration < 24) {
                    return $this->format(round($duration), 'hour', $format);
                } else {
                    return $this->duration($duration / 24, 'day', $format);
                }
                break;
            case 'day':
                if ($duration < 365) {
                    return $this->format(round($duration), 'day', $format);
                } else {
                    return $this->duration($duration / 365, 'year', $format);
                }
                break;
            case 'year':
                return $this->format(round($duration), 'year', $format);
                break;
            default:
                throw new \Exception('Unit not existing (' . $unit . ')');
        }
    }

    public function getName()
    {
        return "duration";
    }
}
