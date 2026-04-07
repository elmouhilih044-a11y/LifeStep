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


}