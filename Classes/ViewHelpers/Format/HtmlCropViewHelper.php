<?php

// erez at meezoog dot com
// 07-Jul-2009 04:59
// An improvement to substrws - multi-byte, and closes tags better.

/**
* word-sensitive substring function with html tags awareness
* @param text The text to cut
* @param len The maximum length of the cut string
* @returns string
**/
function mb_substrws( $text, $len=180 ) {

    if( (mb_strlen($text) > $len) ) {

        $whitespaceposition = mb_strpos($text," ",$len)-1;

        if( $whitespaceposition > 0 ) {
            $chars = count_chars(mb_substr($text, 0, ($whitespaceposition+1)), 1);
            if ($chars[ord('<')] > $chars[ord('>')])
                $whitespaceposition = mb_strpos($text,">",$whitespaceposition)-1;
            $text = mb_substr($text, 0, ($whitespaceposition+1));
        }

        // close unclosed html tags
        if( preg_match_all("|<([a-zA-Z]+)|",$text,$aBuffer) ) {

            if( !empty($aBuffer[1]) ) {

                preg_match_all("|</([a-zA-Z]+)>|",$text,$aBuffer2);

                if( count($aBuffer[1]) != count($aBuffer2[1]) ) {

                    foreach( $aBuffer[1] as $index => $tag ) {

                        if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag)
                            $text .= '</'.$tag.'>';
                    }
                }
            }
        }
    }
    return $text;
}