<?php


if (!function_exists('Abbr_company_name')) {
    function Abbr_company_name() {
        // List of stop words to ignore
        $stopWords = ['and', 'of', 'the', 'in', 'on', 'at', 'for', 'to', 'with', 'a', 'an', 'by'];

        // Split the string into words
        $words = explode(" ", Auth::user()->settings->company_name);
        $abbreviation = "";

        foreach ($words as $word) {
            $word = strtolower(trim($word)); // normalize and trim whitespace
            if (!empty($word) && !in_array($word, $stopWords)) {
                $abbreviation .= strtoupper($word[0]);
            }
        }
        return $abbreviation;
    }
}

if (!function_exists('numberToWords')) {
    function numberToWords($num) {
        $num = intval($num);
        
        // Handle edge cases
        if (empty($num) || $num === 0) {
            return 'zero';
        }

        if ($num < 0) {
            return 'negative ' . numberToWords(abs($num));
        }

        // Simple array-based approach
        $ones = array(
            1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
            6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
            11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
            15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen'
        );

        $tens = array(20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
                      60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety');

        $scales = array(1000000000 => 'billion', 1000000 => 'million', 1000 => 'thousand', 100 => 'hundred');

        $result = '';

        foreach ($scales as $scale => $scaleWord) {
            if ($num >= $scale) {
                $div = $num / $scale;
                $num = $num % $scale;
                $result .= (strlen($result) > 0 ? ' ' : '');
                
                if ($div < 20) {
                    $result .= $ones[$div] . ' ' . $scaleWord;
                } elseif ($div < 100) {
                    $tens_digit = intval($div / 10) * 10;
                    $result .= $tens[$tens_digit];
                    if ($div % 10 > 0) {
                        $result .= ' ' . $ones[$div % 10];
                    }
                    $result .= ' ' . $scaleWord;
                } else {
                    $result .= numberToWords($div) . ' ' . $scaleWord;
                }
            }
        }

        // Handle numbers less than 100
        if ($num > 0) {
            if ($result) $result .= ' ';
            
            if ($num < 20) {
                $result .= $ones[$num];
            } elseif ($num < 100) {
                $tens_digit = intval($num / 10) * 10;
                $result .= $tens[$tens_digit];
                if ($num % 10 > 0) {
                    $result .= ' ' . $ones[$num % 10];
                }
            }
        }

        return trim($result);
    }
}