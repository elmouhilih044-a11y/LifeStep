<?php
namespace App\Services;

class CompatibilityService
{
public function budgetScore($lifeProfile,$logement){
    $price=$logement->price;
    $min=$lifeProfile->budget_min;
    $max=$lifeProfile->budget_max;

if(!$min || !$max){
    return 0;
}

if ($price >= $min && $price <= $max){
    return 40;
}

if($price<=$max*1.1 && $price>=$min*0.9){
    return 20;
}
return 0;


}

public function cityScore($lifeProfile,$logement){
    $cityProfile=$lifeProfile->location;
    $cityLogement=$logement->city;

    if(strtolower($cityProfile) === strtolower($cityLogement)){
        return 25;
    }
    return 0;
}

public function profileTypeScore($lifeProfile,$logement){
    $profileType=$lifeProfile->profile_type;
    $logementType=$logement->type;

    if($profileType==='etudiant'){
        if($logementType==='studio' || $logementType ==='appartement'){
        return 25;
        }
        return 0;
        }
       
    if($profileType==='couple'){
        if($logementType==='appartement'){
            return 25;
        }
        return 0;
    }

    if($profileType==='famille'){
        if($logementType==='maison' || $logementType==='villa'){
            return 25;
        }
        return 0;
    }
       return 0; 
        
}
}