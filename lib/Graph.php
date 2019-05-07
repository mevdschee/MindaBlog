<?php
namespace MintyPHP;

class Graph
{
    public static function verticalBar($values, $height, $title = '')
    {
        if (count($values)) {
            $real_max = max($values);
        } else {
            $real_max = 100;
        }
        $max = pow(10, ceil(log10($real_max)));
        while ($max / 2 > $real_max) {
            $max /= 2;
        }
        $html = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="100%" height="' . $height . '">';
        $html .= '<rect width="100%" height="100%" fill="#eee" style="stroke:#aaa;stroke-width:2px;"/>';
        for ($i = 0; $i < 10; $i++) {
            $top = ($i / 10 * $height);
            if ($i % 2 == 0) {
                $html .= '<line x1="0" y1="' . $top . '" x2="100%" y2="' . $top . '" style="stroke:#aaa;" />';
            } else {
                $html .= '<line x1="0" y1="' . $top . '" x2="100%" y2="' . $top . '" style="stroke:#ccc;" />';
            }
        }
        $c = count($values);
        if ($c) {
            $i = 0;
            foreach ($values as $key => $value) {
                $p = round(100 * ($value / $max));
                $hover = is_string($key) ? $key . ': ' . $value : $value;
                $html .= '<g>';
                $margin = 0.25;
                $html .= '<rect x="' . (($c - $i - 1) * (100 / $c) + $margin) . '%" y="' . (100 - $p) . '%" width="' . (100 / $c - 2 * $margin) . '%" height="' . $p . '%" style="fill:#bbb"/>';
                if (is_string($key)) {
                    $html .= '<text x="' . (($c - $i - .5) * (100 / $c)) . '%" y="' . (100 - $p) . '%" style="writing-mode: sideways-lr;font-size: 75%;dominant-baseline:middle;text-anchor:start;fill:#eee;" transform="translate(1,4)">' . $key . '</text>';
                }
                $html .= '<title>' . $hover . '</title>';
                $html .= '</g>';
                $i++;
            }
        }
        $html .= '<text x="50%" y="0" style="dominant-baseline:hanging;text-anchor:middle" transform="translate(0,2)">' . $title . '</text>';
        for ($i = 0; $i < 10; $i++) {
            $top = ($i / 10 * $height);
            $text = ((1 - $i / 10) * $max);
            if ($i % 2 == 0) {
                $html .= '<line x1="0" y1="' . $top . '" x2="9" y2="' . $top . '" style="stroke:#000;" />';
                $html .= '<text x="0" y="' . $top . '" style="dominant-baseline:hanging;text-anchor:start" transform="translate(2,2)">' . $text . '</text>';
            } else {
                $html .= '<line x1="0" y1="' . $top . '" x2="6" y2="' . $top . '" style="stroke:#000;" />';
            }
        }
        $html .= '</svg>';
        return $html;
    }

    public static function horizontalBar($values, $height, $title = '')
    {
        if (count($values)) {
            $real_max = max($values);
        } else {
            $real_max = 100;
        }
        $max = pow(10, ceil(log10($real_max)));
        while ($max / 2 > $real_max) {
            $max /= 2;
        }
        array_unshift($values, 0);

        $html = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="100%" height="' . $height . '">';
        $html .= '<rect width="100%" height="100%" fill="#eee" style="stroke:#aaa;stroke-width:2px;"/>';
        for ($i = 0; $i < 10; $i++) {
            $left = $i * 10;
            if ($i % 2 == 0) {
                $html .= '<line x1="' . $left . '%" y1="0" x2="' . $left . '%" y2="' . $height . '" style="stroke:#aaa;" />';
            } else {
                $html .= '<line x1="' . $left . '%" y1="0" x2="' . $left . '%" y2="' . $height . '" style="stroke:#ccc;" />';
            }
        }
        $c = count($values);
        if ($c) {
            $i = 0;
            foreach ($values as $key => $value) {
                $p = round(100 * ($value / $max));
                $hover = is_string($key) ? $key . ': ' . $value : $value;
                $spacing = 0.05;
                $html .= '<g>';
                $html .= '<rect x="0" y="' . (($i + $spacing) * ($height / $c)) . '" width="' . $p . '%" height="' . ((1 - 2 * $spacing) * ($height / $c)) . '" style="fill:#bbb" />';
                if (is_string($key)) {
                    $html .= '<text x="' . $p . '%" y="' . (($i + 0.5) * ($height / $c)) . '" style="font-size:90%;dominant-baseline:middle;text-anchor:end;fill:#eee;" transform="translate(-4,0)">' . $key . '</text>';
                }
                $html .= '<title>' . $hover . '</title>';
                $html .= '</g>';
                $i++;
            }
        }
        $html .= '<text x="50%" y="0" style="dominant-baseline:hanging;text-anchor:middle" transform="translate(0,2)">' . $title . '</text>';
        for ($i = 0; $i < 10; $i++) {
            $left = $i * 10;
            $text = ($i / 10) * $max;
            if ($i % 2 == 0) {
                $html .= '<line x1="' . $left . '%" y1="' . ($height - 9) . '" x2="' . $left . '%" y2="' . $height . '" style="stroke:#000;" />';
                $html .= '<text x="' . $left . '%" y="' . $height . '" style="text-anchor:start" transform="translate(3,-3)">' . $text . '</text>';
            } else {
                $html .= '<line x1="' . $left . '%" y1="' . ($height - 6) . '" x2="' . $left . '%" y2="' . $height . '" style="stroke:#000;" />';
            }
        }
        $html .= '</svg>';
        return $html;
    }

}
