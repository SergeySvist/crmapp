<?php

namespace Core;

class Tools
{
    public static function notify(string $message, string $color)
    {
        $output = "<p style='color: $color;font-size: 24px;margin: 0 auto;'>$message</p>";
        echo $output;
    }
}
