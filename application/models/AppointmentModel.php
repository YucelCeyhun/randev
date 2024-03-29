<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AppointmentModel extends CI_Model
{

    public function GetEngineersAsArray($userId){
       $result = $this->db->order_by('name','ASC')->where("userId",$userId)->get('engineers')->result();
        return $result;
    }
    
   public function GetEngineerAsRow($engineerId){
      $row = $this->db->where("id",$engineerId)->get('engineers')->row();
       return $row;
   }


    public function GetCompaniesAsArray($userId){
        $result = $this->db->order_by('name','ASC')->where("userId",$userId)->get('companies')->result();
        return $result;
     }

     public function GetAppointmentsForUserArray($userId,$date,$engineerId){
         $stat = Array(
            "userId" => $userId,
            "date" => $date,
            "engineerId" =>$engineerId
         );
         $query = $this->db->order_by('engineerId','ASC')->where($stat)->get('appointments');
         return $query;
     }

     public function CheckEngineer($userId,$engineerId){
        $stat = Array(
            "userId" => $userId,
            "id" =>$engineerId
         );

        $num = $this->db->where($stat)->get('engineers')->num_rows();
        if($num)
         return true;

         return false;
     }

     public function CreateAppointment($insertData){
        return $this->db->insert('appointments',$insertData);
     }

     public function CheckSameRow($builtname,$date){

      $stat = Array(
         'builtName' => $builtname,
         'date' => $date
      );

      $num = $this->db->where($stat)->get('appointments')->num_rows();

      if($num)
         return false;

      return true;

     }

     public function GetAppointmentEngineer($userId,$date,$page,$appointmentfind){

      $stat = Array(
         'appointments.userId' => $userId,
         'appointments.dateSql >=' => $date
      );
      
      $this->db->order_by('appointments.dateSql','ASC')->limit(5,(($page-1) * 5));
      $this->db->where($stat);
      $this->db->group_start();
      $this->db->or_like('engineers.name',$appointmentfind);
      $this->db->or_like('appointments.builtName',$appointmentfind);
      $this->db->group_end();
      $this->db->join('appointments','appointments.engineerId = engineers.id');
      $get = $this->db->get('engineers');

      $num = $get->num_rows();

      return Array($get,$num);

     }

     public function GetCompany($companyId){
      $result = $this->db->where("id",$companyId)->get('companies')->row();
      return $result;
      }

   public function GetAppointmentCount($userId,$date,$appointmentfind){
      $stat = Array(
         'appointments.userId' => $userId,
         'appointments.dateSql >=' => $date
      );


      $get =$this->db->where($stat)->get('appointments')->num_rows();
      return $get;
   }
   
   public function CheckAppointment($elementId,$userId){
      $stat = Array(
         'id' => $elementId,
         'userId' => $userId
      );
      $num = $this->db->where($stat)->get('appointments')->num_rows();
      return $num;
   }

   public function DeleteAppointment($elementId,$userId){
      $stat = Array(
         'id' => $elementId,
         'userId' => $userId
      );
      $del = $this->db->where($stat)->delete('appointments');
      return $del;
   }

   public function DeleteAppointmentForAdmin($elementId){
      $stat = Array(
         'id' => $elementId
      );
      $del = $this->db->where($stat)->delete('appointments');
      return $del;
   }

   public function GetAppointmentEngineerWithId($userId,$date,$engineers){

      $stat = Array(
         'appointments.userId' => $userId,
         'appointments.date' => $date,
         'appointments.engineerId' => $engineers
      );

      //$get = $this->db->order_by('homeDistance','ASC')->where($stat)->get('appointments');

      $get = $this->db->order_by('appointments.homeDistance','ASC')->join('appointments','appointments.companyId = companies.id')->where($stat)->get('companies');


      return $get;

     }

     public function GetAppointmentForExcelEx($userId,$dateFrom,$dateTo,$engineers){

      $stat = Array(
         'appointments.userId' => $userId,
         'appointments.dateSql >=' => $dateFrom,
         'appointments.dateSql <=' => $dateTo,
         'appointments.engineerId' => $engineers
      );

      $result = $this->db->order_by('appointments.engineerId','ASC')->join('appointments','appointments.companyId = companies.id')->where($stat)->get('companies')->result();

      return $result;

     }

     
     public function GetAppointmentForExcel($userId,$dateFrom,$dateTo){

      $stat = Array(
         'appointments.userId' => $userId,
         'appointments.dateSql >=' => $dateFrom,
         'appointments.dateSql <=' => $dateTo
      );

      $result = $this->db->order_by('appointments.engineerId','ASC')->join('appointments','appointments.companyId = companies.id')->where($stat)->get('companies')->result();


      return $result;

     }

   public function GetEngineerName($engineerId){
      $row = $this->db->where("id",$engineerId)->get('engineers')->row();
      $name = $row->name;
      return $name;
   }


}
