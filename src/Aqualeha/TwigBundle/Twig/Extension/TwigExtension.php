<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/04/16
 * Time: 10:40
 */

namespace Aqualeha\TwigBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

/**
 * Class TwigExtension
 *
 * @package Aqualeha\TwigBundle\Twig\Extension
 */
class TwigExtension extends \Twig_Extension {
    /**
     * @return string
     */
    public function getName() {
        return 'aqualehatwigext';
    }

    /**
     * @return array
     */
    public function getFilters() {
        return array(
            'color_inverse' => new \Twig_Filter_Method($this, 'invertColor'),
        );
    }

    /**
     * @param $color
     *
     * @return string
     */
    public function invertColor($color) {
        $color = trim($color);
        $prependHash = false;

        if (strpos($color, '#') !== false) {
            $prependHash = true;
            $color = str_replace('#', null, $color);
        }

        switch ($len = strlen($color)) {
            case 3:
                $color = preg_replace("/(.)(.)(.)/", "\\1\\1\\2\\2\\3\\3", $color);
            case 6:
                BREAK;
            default:
                trigger_error("Invalid hex length ($len). Must be (3) or (6)", e_user_error);
        }

        IF (!preg_match('/[a-f0-9]{6}/i', $color)) {
            $color = htmlentities($color);
            trigger_error("Invalid hex string #$color", e_user_error);
        }

        $r = dechex(255 - hexdec(substr($color, 0, 2)));
        $r = (strlen($r) > 1) ? $r : '0' . $r;
        $g = dechex(255 - hexdec(substr($color, 2, 2)));
        $g = (strlen($g) > 1) ? $g : '0' . $g;
        $b = dechex(255 - hexdec(substr($color, 4, 2)));
        $b = (strlen($b) > 1) ? $b : '0' . $b;

        return ($prependHash ? '#' : null) . $r . $g . $b;
    }
} 