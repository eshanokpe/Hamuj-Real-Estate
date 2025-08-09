<?php 
namespace App\Traits;

trait AwardsGroups{
 
    public function getAwardId()
    {
        $data['award_group_one'] = [40,43]; //ComBankRiskComplainces
        $data['award_group_five'] = [97]; //rc_solution_providers
        $data['award_group_seven'] = [12]; //grc_anti_fin_crim_reporters
        $data['award_group_eleven'] = [101]; // Governors award 
        $data['award_group_twelve']  = [102]; //NonFI
// --------------------in use -----------------
        $data['award_group_two'] = [147]; //ESG Initiative
        $data['award_group_three'] = [105,107,109,126,133,135,129,137,111,110, 146, 131]; //com_bank_chief_risk_officers
        $data['award_group_four'] = [125, 104, 106,108,128,130, 132,134, 136]; //grc_employers
        $data['award_group_six'] = [140,141,142,143]; //grc_training_providers
        $data['award_group_eight'] = [96,95]; //Financial Crime Prevention Advisory Service
        $data['award_group_nine'] = [138, 139]; // women is GRC
        $data['award_group_ten'] = [144]; //Media Votes
        $data['award_group_eleven'] = [145]; //Special Recog
        return $data;
    }

}