<?php






if (! function_exists('fan_tier')) {

    function fan_tier(int $score): string
    {
        return match (true) {
            $score >= 2000 => 'Superfan',
            $score >= 800  => 'Ultra',
            $score >= 200  => 'Supporter',
            default         => 'Casual',
        };
    }
}