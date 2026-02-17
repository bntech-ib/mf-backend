<?php




// app/Jobs/DistributeSeasonRewards.php

namespace App\Jobs;
 
use App\Models\Season;  
use Illuminate\Contracts\Queue\ShouldQueue;

class DistributeSeasonRewards implements ShouldQueue
{
    public function __construct(
        public Season $season
    ) {}

    public function handle(): void
    {
        foreach ($this->season->clubs as $clubAllocation) {

            $fans = $this->season->loyaltyScores()
                ->where('club_id', $clubAllocation->club_id)
                ->get();

            $totalScore = $fans->sum('score');

            if ($totalScore === 0) continue;

            foreach ($fans as $fan) {

                $share = (
                    $clubAllocation->final_allocation
                    * ($fan->score / $totalScore)
                );

                // credit reward wallet (implement separately)
                // RewardService::credit($fan->user, $share);
            }
        }
    }
}
