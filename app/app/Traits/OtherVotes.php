<?php 

namespace App\Traits;
use App\Models\{
    WomenInGrc,
    MediaVotes,
    GovernorsVotes,
    NonfiVotes
};

trait OtherVotes {


    public function WomenInGrc($votes, $award_hashid){
        $check = WomenInGrc::whereAwardId($award_hashid)->get();
        if(count($check) > 0){
            return $check;
        }
        $nominees = array_count_values($votes);
        arsort($nominees);
        $x = 0;
        $Totalvotes = 0;
     
        if(count($nominees) > 0){
            $Totalvotes = array_sum($nominees);
            foreach($nominees as $nominees_name => $nominees_votes){
             WomenInGrc::create([
                'award_id' => $award_hashid,
                'nominee_name' => $nominees_name,
                'number_of_votes' => $nominees_votes,
                'percentage_votes' => ((100/$Totalvotes)*$nominees_votes)
            ]);
         $x++;
         if($x == 4) break;
        }   
}
return $check;
    }
    

    public function Medias($votes, $award_hashid){
        $check = MediaVotes::whereAwardId($award_hashid)->get();
            
        if(count($check) > 0){
            return $check;
        }

        $nominees = array_count_values($votes);
        arsort($nominees);
        $x = 0;
        $Totalvotes = 0;
        if(count($nominees) > 0){
            $Totalvotes = array_sum($nominees);
            foreach($nominees as $nominees_name => $nominees_votes){
                MediaVotes::create([
                'award_id' => $award_hashid,
                'nominee_name' => $nominees_name,
                'number_of_votes' => $nominees_votes,
                'percentage_votes' => ((100/$Totalvotes)*$nominees_votes)
            ]);
         $x++;
         if($x == 4) break;
        }   
}
return $check;


    }

    public function GovernorsVotes($votes, $award_hashid){
        $check = GovernorsVotes::whereAwardId($award_hashid)->get();
            
        if(count($check) > 0){
            return $check;
        }

        $nominees = array_count_values($votes);
        arsort($nominees);
        $x = 0;
        $Totalvotes = 0;
        if(count($nominees) > 0){
            $Totalvotes = array_sum($nominees);
            foreach($nominees as $nominees_name => $nominees_votes){
                GovernorsVotes::create([
                'award_id' => $award_hashid,
                'nominee_name' => $nominees_name,
                'number_of_votes' => $nominees_votes,
                'percentage_votes' => ((100/$Totalvotes)*$nominees_votes)
            ]);
         $x++;
         if($x == 4) break;
        }   
}
return $check;


    }

    public function NonFiVote($votes, $award_hashid){
        $check = NonfiVotes::whereAwardId($award_hashid)->get();   
        if(count($check) > 0){
            return $check;
        }
        $nominees = array_count_values($votes);
        arsort($nominees);
        $x = 0;
        $Totalvotes = 0;
        if(count($nominees) > 0){
            $Totalvotes = array_sum($nominees);
            foreach($nominees as $nominees_name => $nominees_votes){
                NonfiVotes::create([
                'award_id' => $award_hashid,
                'nominee_name' => $nominees_name,
                'number_of_votes' => $nominees_votes,
                'percentage_votes' => ((100/$Totalvotes)*$nominees_votes)
            ]);
         $x++;
         if($x == 4) break;
        }   
}
return $check;
}

}
