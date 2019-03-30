<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DefaultModel extends CI_Model
{

    public function GetEngineersAsArray($userId){
       $getEngineer = $this->db->order_by('name','ASC')->where("userId",$userId)->get('engineers');
        return $getEngineer;
    }

     public function GetAppointmentsForUserArray($userId,$date,$engineerId){
         $stat = Array(
            "userId" => $userId,
            "dateSql >=" => $date,
            "engineerId" => $engineerId
         );
         $query = $this->db->order_by('engineerId','ASC')->where($stat)->get('appointments');
         return $query;
     }

     public function GetAppointmentsArray($userId,$date){
        $stat = Array(
            "userId" => $userId,
            "dateSql >=" => $date,
         );

         $query = $this->db->order_by('engineerId','ASC')->where($stat)->get('appointments');
         return $query;
     }


}
