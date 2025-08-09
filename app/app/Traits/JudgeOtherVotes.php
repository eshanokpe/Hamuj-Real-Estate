<?php 

namespace App\Traits;

use App\Models\{
    WomenInGrc,
    MediaVotes,
    GovernorsVotes,
    NonfiVotes
};
use App\Models\JudgesVotes;

trait JudgeOtherVotes{

    public function WomenInGrcJudgeVote($judges_votes, $nominees, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominees as $nominess => $value){
               $nominee = WomenInGrc::where(['nominee_name' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }




    public function MediasJudgeVote($judges_votes, $nominees, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominees as $nominess => $value){
               $nominee = MediaVotes::where(['nominee_name' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }


    public function GovernorsJudgeVote($judges_votes, $nominees, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominees as $nominess => $value){
               $nominee = GovernorsVotes::where(['nominee_name' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }



    public function NonfiJudgeVote($judges_votes, $nominees, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominees as $nominess => $value){
               $nominee = NonfiVotes::where(['nominee_name' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_name' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }









}

