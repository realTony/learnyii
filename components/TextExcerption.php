<?php

namespace app\components;


class TextExcerption
{

    public static function excerptText($text, $max_length = 140, $cut_off = '...', $keep_word = false)
    {
        if(strlen($text) <= $max_length) {
            return $text;
        }

        if(strlen($text) > $max_length) {
            if($keep_word) {
                $text = mb_substr($text, 0, $max_length + 1);

                if($last_space = strrpos($text, ' ')) {
                    $text = mb_substr($text, 0, $last_space);
                    $text = rtrim($text);
                    $text .=  $cut_off;
                }
            } else {
                $text = mb_substr($text, 0, $max_length);
                $text = rtrim($text);
                $text .=  $cut_off;
            }
        }

        return $text;
    }
}