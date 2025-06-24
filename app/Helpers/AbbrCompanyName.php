<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;


class AbbrCompanyName
{
    public static function Abbr_company_name()
    {
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