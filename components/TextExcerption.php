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

    public static function mbUcfirst($string, $encoding) : string
    {
        $string = mb_strtolower($string, $encoding);
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);

        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    public static function getDayString($num) : string
    {
        $days = '';

        switch ($num) {
            case 1:
                $days = \Yii::t('app', 'день');
                break;
            case 2:
            case 3:
            case 4:
                $days = \Yii::t('app', 'деня');
                break;
            default:
                $days = \Yii::t('app', 'деней');
        }

        return $days;
    }
}