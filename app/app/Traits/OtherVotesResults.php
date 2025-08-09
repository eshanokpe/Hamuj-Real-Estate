<?php 
namespace App\Traits;
use App\Models\{
    WomenInGrc,
    MediaVotes,
    GovernorsVotes,
    NonfiVotes
};

trait OtherVotesResults {


    public function WomenInGrcResults($award_id){

        $awards = WomenInGrc::where('award_id', $award_id)->get();
        $total_votes = WomenInGrc::where('award_id', $award_id)->sum('number_of_votes');
        $check = WomenInGrc::where(['status' =>'WINNER', 'award_id' => $award_id])->first();
        if($check){
            $check->update(['status' => '']);
        }
        foreach($awards as $award){
            if($award->judges_votes == null){
                return 0;
            }
            $judge_votes = json_decode($award->judges_votes);
            $total_judges_votes = array_sum($judge_votes);
            
            $total_attainable_judge_scores = count($judge_votes) * 10;
            $judge_votes_to_percentage = ($total_judges_votes/$total_attainable_judge_scores)*100;
            $eighty_percent_of_judges_score = ($judge_votes_to_percentage*0.8);
            $percentage_of_votes = ($award->number_of_votes/$total_votes)*100;
            $twenty_percent_of_votes_score  = $percentage_of_votes * 0.2; 
            $overall_score = $eighty_percent_of_judges_score + $twenty_percent_of_votes_score;
            $award->fill(['total_of_judges_score_converted_to_percentage' => $judge_votes_to_percentage, 
            'eighty_percent_of_judges_score' => $eighty_percent_of_judges_score, 'twenty_percent_votes' => $twenty_percent_of_votes_score,
            'overall_score' => $overall_score])->save();
        }
        $total_votes = WomenInGrc::where('award_id', $award_id)->take(1)->orderBy('overall_score', 'DESC')->first();
        $total_votes->update(['status' => 'WINNER']);
    }

    public function MediaVotesResults($award_id){

        $awards = MediaVotes::where('award_id', $award_id)->get();
        $total_votes = MediaVotes::where('award_id', $award_id)->sum('number_of_votes');
        $check = MediaVotes::where(['status' =>'WINNER', 'award_id' => $award_id])->first();
        if($check){
            $check->update(['status' => '']);
        }
        foreach($awards as $award){
            if($award->judges_votes == null){
                return 0;
            }
            $judge_votes = json_decode($award->judges_votes);
            $total_judges_votes = array_sum($judge_votes);
            
            $total_attainable_judge_scores = count($judge_votes) * 10;
            $judge_votes_to_percentage = ($total_judges_votes/$total_attainable_judge_scores)*100;
            $eighty_percent_of_judges_score = ($judge_votes_to_percentage*0.8);
            $percentage_of_votes = ($award->number_of_votes/$total_votes)*100;
            $twenty_percent_of_votes_score  = $percentage_of_votes * 0.2; 
            $overall_score = $eighty_percent_of_judges_score + $twenty_percent_of_votes_score;
            $award->fill(['total_of_judges_score_converted_to_percentage' => $judge_votes_to_percentage, 
            'eighty_percent_of_judges_score' => $eighty_percent_of_judges_score, 'twenty_percent_votes' => $twenty_percent_of_votes_score,
            'overall_score' => $overall_score])->save();
        }
        $total_votes = MediaVotes::where('award_id', $award_id)->take(1)->orderBy('overall_score', 'DESC')->first();
        $total_votes->update(['status' => 'WINNER']);
    }


    public function GovernorsVotesResults($award_id){

        $awards = GovernorsVotes::where('award_id', $award_id)->get();
        $total_votes = GovernorsVotes::where('award_id', $award_id)->sum('number_of_votes');
        $check = GovernorsVotes::where(['status' =>'WINNER', 'award_id' => $award_id])->first();
        if($check){
            $check->update(['status' => '']);
        }
        foreach($awards as $award){
            if($award->judges_votes == null){
                return 0;
            }
            $judge_votes = json_decode($award->judges_votes);
            $total_judges_votes = array_sum($judge_votes);
            
            $total_attainable_judge_scores = count($judge_votes) * 10;
            $judge_votes_to_percentage = ($total_judges_votes/$total_attainable_judge_scores)*100;
            $eighty_percent_of_judges_score = ($judge_votes_to_percentage*0.8);
            $percentage_of_votes = ($award->number_of_votes/$total_votes)*100;
            $twenty_percent_of_votes_score  = $percentage_of_votes * 0.2; 
            $overall_score = $eighty_percent_of_judges_score + $twenty_percent_of_votes_score;
            $award->fill(['total_of_judges_score_converted_to_percentage' => $judge_votes_to_percentage, 
            'eighty_percent_of_judges_score' => $eighty_percent_of_judges_score, 'twenty_percent_votes' => $twenty_percent_of_votes_score,
            'overall_score' => $overall_score])->save();
        }
        $total_votes = GovernorsVotes::where('award_id', $award_id)->take(1)->orderBy('overall_score', 'DESC')->first();
        $total_votes->update(['status' => 'WINNER']);
    }

    public function NonFiVotesResults($award_id){

        $awards = NonfiVotes::where('award_id', $award_id)->get();
        $total_votes = NonfiVotes::where('award_id', $award_id)->sum('number_of_votes');
        $check = NonfiVotes::where(['status' =>'WINNER', 'award_id' => $award_id])->first();
        if($check){
            $check->update(['status' => '']);
        }
        foreach($awards as $award){
            if($award->judges_votes == null){
                return 0;
            }
            $judge_votes = json_decode($award->judges_votes);
            $total_judges_votes = array_sum($judge_votes);
            
            $total_attainable_judge_scores = count($judge_votes) * 10;
            $judge_votes_to_percentage = ($total_judges_votes/$total_attainable_judge_scores)*100;
            $eighty_percent_of_judges_score = ($judge_votes_to_percentage*0.8);
            $percentage_of_votes = ($award->number_of_votes/$total_votes)*100;
            $twenty_percent_of_votes_score  = $percentage_of_votes * 0.2; 
            $overall_score = $eighty_percent_of_judges_score + $twenty_percent_of_votes_score;
            $award->fill(['total_of_judges_score_converted_to_percentage' => $judge_votes_to_percentage, 
            'eighty_percent_of_judges_score' => $eighty_percent_of_judges_score, 'twenty_percent_votes' => $twenty_percent_of_votes_score,
            'overall_score' => $overall_score])->save();
        }
        $total_votes = NonfiVotes::where('award_id', $award_id)->take(1)->orderBy('overall_score', 'DESC')->first();
        $total_votes->update(['status' => 'WINNER']);
    }




}