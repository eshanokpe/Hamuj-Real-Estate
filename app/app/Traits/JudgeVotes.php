<?php 
namespace App\Traits;
use App\Models\{ComBankChiefRiskOfficer, ComBankFraudAwareness,
    ComBankRiskComplaince, GrcAntiFinCrimReporter, GrcEmployer, 
    GrcSolutionProvider, GrcTrainingProvider, CrimePreventionAdvisoryService, GovernorsVotes, MediaVotes, WomenInGrc};
use App\Models\VoteCount;
use App\Models\JudgesVotes;

trait JudgeVotes {

      #awardsOne
    public function BankChiefRiskOfficerVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = ComBankChiefRiskOfficer::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }


      #awardsTwo
    public function BankFraudAwarenessVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = ComBankFraudAwareness::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }


      #awardsThree
    public function BankRiskComplaincesVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
        // dd($check);
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = ComBankRiskComplaince::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }

      #awardsFour
    public function GrcAntiFinCrimReportersVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = GrcAntiFinCrimReporter::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }


      #awardsFive
    public function GrcSolutionProvidersVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = GrcSolutionProvider::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }

    
  #awardsSix
    public function GrcEmployersVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = GrcEmployer::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }



    #awardsSeven
    public function GrcTrainingProviderVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = GrcTrainingProvider::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }


     #awardseight
     public function crimePreventionAdvisoryServicesVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = CrimePreventionAdvisoryService::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }

    public function WomenInGrcJudgeVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = WomenInGrc::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }


    public function MediasJudgeVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = MediaVotes::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
                 $nominee->update(['judges_votes' => json_encode($vote)]);
                
               }
               array_pop($vote);
            }
        $data = true;
        }
        return $data;
    }
    
    public function GovernorsJudgeVote($judges_votes, $nominee_ids, $award_hashid){
        $check = JudgesVotes::where(['award_id'=>$award_hashid, 'judge_id' => auth('admin')->user()->id])->first();
       $vote = [];
        if($check){
            $data = false;
        }else{ 
        foreach($nominee_ids as $nominess => $value){
               $nominee = GovernorsVotes::where(['nominee_id' => $value, 'award_id'=>$award_hashid])->first();
               if($nominee->judges_votes != null){    
               $vote =  json_decode($nominee->judges_votes);
                array_push($vote, $judges_votes[$nominess]);
                $nominee->update(['judges_votes' => json_encode($vote)]);
                JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
                ]);
               }else{
                 array_push($vote,$judges_votes[$nominess]);
                 JudgesVotes::create([
                    'judge_id' => auth('admin')->user()->id,
                     'votes' => $judges_votes[$nominess],
                    'award_id' => $award_hashid, 
                    'nominee_id' => $value,
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


