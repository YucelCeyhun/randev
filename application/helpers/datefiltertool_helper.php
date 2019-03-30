<?php

function DateCovert($date){
    $dateArray = explode('-',$date);

    if($dateArray[0][0] < 1){
        $dateArray[0] = $dateArray[0][1];
    }

    if($dateArray[1][0] < 1){
        $dateArray[1] =  $dateArray[1][1];
    }
   
    $monthTr = Array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
    $dateArray[1] = $monthTr[$dateArray[1] - 1];

    
    return Array('d' => $dateArray[0],'m' => $dateArray[1],'y' => $dateArray[2]);
}


function DateCovertNum($date){
    $dateArray = explode('-',$date);

    if($dateArray[0][0] < 1){
        $dateArray[0] = $dateArray[0][1];
    }

    if($dateArray[1][0] < 1){
        $dateArray[1] =  $dateArray[1][1];
    }
   
    return Array('d' => $dateArray[0],'m' => $dateArray[1],'y' => $dateArray[2]);
}

function DateConvertSql($date){
    $dateArray = explode('-',$date);
    return $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
}

function DateCalculator($date){
 
    $CI =& get_instance();
    $CI->load->helper("formtool_helper");

    if(CheckInput($date))
    return false;

    $pattern = '/^([012][0-9]|[3][0-1])-[0-9]|[1][0-2]-[0-9]{4}$/';

    if(!preg_match($pattern,$date))
        return false;

    $year = date("Y");
    $month = date('m');
    $day = date("d");

    if($month[0] == 0){
        $month = $month[1]; 
    }

    if($day[0] == 0){
        $day = $day[1]; 
    }


    $monthesDays = Array(
        1 =>31,
        2 =>$year%4==0?29:28,
        3 =>31,
        4 =>30,
        5 =>31,
        6 =>30,
        7 =>31,
        8 =>31,
        9 =>30,
        10 =>31,
        11 =>30,
        12 =>31
    );



    $dateArray = explode('-',$date);

    if($dateArray[0][0] < 1){
        $dateArray[0] = $dateArray[0][1];
    }

    if($dateArray[1][0] < 1){
        $dateArray[1] =  $dateArray[1][1];
    }
   
    
    if(!is_numeric($dateArray[2]) || !is_numeric($dateArray[1]) || !is_numeric($dateArray[0]))
        return false;

    if($dateArray[1] > ($month+1) && $month != 1)
        return false;
      
    if($month == 1){
        if($dateArray[1] > $month+2)
            return false;

        if($day <= $monthesDays[2] && $dateArray[1] == 3)
            return false;


        if($day > $monthesDays[2] && $dateArray[1] > $month+1){
            if($dateArray[0] > (31-$monthesDays[2])){
                return false;
            }
        }
    }

    if($dateArray[1] == $month && $dateArray[0] < $day)
        return false;

    if(($dateArray[1] == ($month+1) || ($month + 1) > 12) && $month != 1){
        if($dateArray[0] > $day + (31 - $monthesDays[$month]))
            return false;
    }

    if($dateArray[2] < $year || $dateArray[1] < 1 || $dateArray[0] < 1)
        return false;

    if($dateArray[2] > $year){
        if($dateArray[1] != 12 || $dateArray[2] > ($year+1)){
            return false;
        }
    }

    if($dateArray[0] > 31)
        return false;


    if($dateArray[1] == 2){
        if(($dateArray[0] > 28 && $dateArray[2] %4 != 0) || $dateArray[0] > 29){
            return false;
        }
    }else if($dateArray[0] > $monthesDays[$dateArray[1]]){
        return false;
    }

    if($dateArray[1] < $month && $month != 12){
        return false;
    }

    if($month == 12){
        if($dateArray[1] != 1 || $dateArray[1] != 12){
            return false;
        }
        if($dateArray[1] == 1){
            if($dateArray[2] != $year+1)
                return false;
        }
    }

    return true;

 
}