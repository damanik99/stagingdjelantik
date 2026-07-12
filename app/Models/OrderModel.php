<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'ID';

    function view_data($program_id)
    {
        
        $sql    = "SELECT * FROM orders a,users b,member c WHERE  a.UserID=b.users_id AND b.member_id=c.member_id AND a.program_id='$program_id'";
        $query  = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    
    
    function view_data_detailorder($orderid,$program_id)
    {
        
        $sql    = "SELECT *,DATE(OrderDate) AS OrderDate FROM orders a,users b,member c,orders_detail d 
                    WHERE  a.UserID=b.users_id AND b.member_id=c.member_id AND a.OrderID=d.OrderID AND a.OrderID='$orderid' AND a.program_id='$program_id' ";
        $query  = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    
    
     function view_totalorder($orderid,$program_id)

    {

        $sql  = "SELECT SUM(d.PricePoint * d.Qty) AS PricePoint,SUM(d.Qty) AS Qtyc FROM orders a,users b,member c,orders_detail d 
                 WHERE  a.UserID=b.users_id AND b.member_id=c.member_id AND a.OrderID=d.OrderID AND a.program_id='$program_id' AND a.OrderID='$orderid'";
        $query = $this->db->query($sql);
        $result = $query->getRowArray();
        return $result;

    }
    
    function getDataReport($program_id,$startdate,$enddate)
    {

        $sql  = "SELECT *,DATE(a.`OrderDate`) AS OrderDate,e.`name` AS programname  
                    FROM orders a,users b,member c,orders_detail d,program e
                    WHERE  a.UserID=b.users_id AND b.member_id=c.member_id AND a.OrderID=d.OrderID AND a.`Program_id`=e.`program_id` AND a.program_id='$program_id' 
                    AND DATE(a.`OrderDate`) BETWEEN '$startdate' AND '$enddate' ORDER BY a.`ID` DESC";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;

    }

   

   
}