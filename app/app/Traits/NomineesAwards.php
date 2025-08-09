<?php
namespace App\Traits;
use App\Models\VoteCount;
use App\Models\{ComBankChiefRiskOfficer, ComBankFraudAwareness,
    ComBankRiskComplaince, GrcAntiFinCrimReporter, GrcEmployer, 
    GrcSolutionProvider, GrcTrainingProvider, CrimePreventionAdvisoryService, GovernorsVotes, MediaVotes, WomenInGrc};


trait NomineesAwards {
 //award one
    public function BankChiefRiskOfficer($votes, $award_hashid){
        $check = ComBankChiefRiskOfficer::whereAwardId($award_hashid)->get();
      
        if(count($check) > 0){
           foreach($check as $cc => $val){
          $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount )* (100/VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else{foreach($votes as $vote){
            ComBankChiefRiskOfficer::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)* (100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data = ComBankChiefRiskOfficer::whereAwardId($award_hashid)->get();
        return $data;
    }

    #Award Two
    public function BankFraudAwareness($votes, $award_hashid){
  
        $check = ComBankFraudAwareness::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
          $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)* (100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else{
        foreach($votes as $vote){
            ComBankFraudAwareness::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)* (100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data = ComBankFraudAwareness::whereAwardId($award_hashid)->get();
    return $data;
    }

    #Award 3
    public function BankRiskComplainces($votes, $award_hashid){
        $check = ComBankRiskComplaince::whereAwardId($award_hashid)->get();
      
        if(count($check) > 0){
           foreach($check as $cc => $val){
           $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)* (100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else {
        foreach($votes as $vote){
            ComBankRiskComplaince::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data = ComBankRiskComplaince::whereAwardId($award_hashid)->get();
    return $data;
    }

    #Award 4
    public function GrcAntiFinCrimReporters($votes, $award_hashid){
        $check = GrcAntiFinCrimReporter::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
          $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();;
           }
          
        }else{
        foreach($votes as $vote){
           GrcAntiFinCrimReporter::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data = GrcAntiFinCrimReporter::whereAwardId($award_hashid)->get();
    return $data;
    }

    #Award 5
    public function GrcSolutionProviders($votes, $award_hashid){
        $check = GrcSolutionProvider::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
           $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else{
        foreach($votes as $vote){
              GrcSolutionProvider::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
        }
        $data = GrcSolutionProvider::whereAwardId($award_hashid)->get();
        return $data;
    }

    #Award 6
    public function GrcEmployers($votes, $award_hashid){
 
        $check =  GrcEmployer::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
              $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else{
        foreach($votes as $vote){
               GrcEmployer::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data =  GrcEmployer::whereAwardId($award_hashid)->get();
    return $data;
    }

    #awards 7
    public function GrcTrainingProvider($votes, $award_hashid){
        $check =  GrcTrainingProvider::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
             $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))])->save();
           }
        }else{
        foreach($votes as $vote){
           GrcTrainingProvider::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100 / VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data =  GrcTrainingProvider::whereAwardId($award_hashid)->get();
    return $data;
    }


    #awards 8
    public function crimePreventionAdvisoryServices($votes, $award_hashid){
        $check =  CrimePreventionAdvisoryService::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
             $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
              'percentage_votes' => ($votes[$cc]->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else{
        foreach($votes as $vote){
            CrimePreventionAdvisoryService::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
    }
    $data =  CrimePreventionAdvisoryService::whereAwardId($award_hashid)->get();
    return $data;
    }

public function WomenInGrc($votes, $award_hashid){

    $check =  WomenInGrc::whereAwardId($award_hashid)->get();
    if(count($check) > 0){
       foreach($check as $cc => $val){
         $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
          'percentage_votes' => ($votes[$cc]->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
       }
    }else{
    foreach($votes as $vote){
        WomenInGrc::create([
            'award_id' => $vote->award_id,
            'nominee_id' => $vote->nominee_id,
            'number_of_votes' => $vote->voteCount,
            'percentage_votes' => ($vote->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
        ]);
    }
    }
            $data =  WomenInGrc::whereAwardId($award_hashid)->get();
            return $data;
            }
            
    
    public function Medias($votes, $award_hashid){

                $check =  MediaVotes::whereAwardId($award_hashid)->get();
                if(count($check) > 0){
                   foreach($check as $cc => $val){
                     $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
                      'percentage_votes' => ($votes[$cc]->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
                   }
                }else{
                foreach($votes as $vote){
                    MediaVotes::create([
                        'award_id' => $vote->award_id,
                        'nominee_id' => $vote->nominee_id,
                        'number_of_votes' => $vote->voteCount,
                        'percentage_votes' => ($vote->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
                    ]);
                }
                }
                        $data =  MediaVotes::whereAwardId($award_hashid)->get();
                        return $data;
         }

          
    public function GovernorsVotes($votes, $award_hashid){

        $check =  GovernorsVotes::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
           foreach($check as $cc => $val){
             $val->fill(['award_id'=> $votes[$cc]->award_id,  'nominee_id'=>$votes[$cc]->nominee_id,'number_of_votes' => $votes[$cc]->voteCount, 
              'percentage_votes' => ($votes[$cc]->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount')) ])->save();
           }
        }else{
        foreach($votes as $vote){
            GovernorsVotes::create([
                'award_id' => $vote->award_id,
                'nominee_id' => $vote->nominee_id,
                'number_of_votes' => $vote->voteCount,
                'percentage_votes' => ($vote->voteCount)*(100/VoteCount::whereAwardId($award_hashid)->sum('voteCount'))
            ]);
        }
        }
                $data =  GovernorsVotes::whereAwardId($award_hashid)->get();
                return $data;
 }
                        
            
}


