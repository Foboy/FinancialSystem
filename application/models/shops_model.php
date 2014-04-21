<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/4/17 20:23:22
 */
class ShopsModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增shops
	public function insert($name,$description,$cover_pictureid,$brand_id,$tags,$mobile,$telphone,$city_id,$area_id,$district_id,$street_id,$address,$longitude,$latitude,$booking_num,$view_num,$comm_num,$check_status,$add_adminid,$add_time,$flag,$sys_time,$pos_rate,$lakala_rate) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from Crm_Shops where name = :name and description = :description and cover_pictureid = :cover_pictureid and brand_id = :brand_id and tags = :tags and mobile = :mobile and telphone = :telphone and city_id = :city_id and area_id = :area_id and district_id = :district_id and street_id = :street_id and address = :address and longitude = :longitude and latitude = :latitude and booking_num = :booking_num and view_num = :view_num and comm_num = :comm_num and check_status = :check_status and add_adminid = :add_adminid and add_time = :add_time and flag = :flag and sys_time = :sys_time and pos_rate = :pos_rate and lakala_rate = :lakala_rate" );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag,
                   ':sys_time' => $sys_time,
                   ':pos_rate' => $pos_rate,
                   ':lakala_rate' => $lakala_rate
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into Crm_Shops(name,description,cover_pictureid,brand_id,tags,mobile,telphone,city_id,area_id,district_id,street_id,address,longitude,latitude,booking_num,view_num,comm_num,check_status,add_adminid,add_time,flag,sys_time,pos_rate,lakala_rate) values (:name,:description,:cover_pictureid,:brand_id,:tags,:mobile,:telphone,:city_id,:area_id,:district_id,:street_id,:address,:longitude,:latitude,:booking_num,:view_num,:comm_num,:check_status,:add_adminid,:add_time,:flag,:sys_time,:pos_rate,:lakala_rate)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag,
                   ':sys_time' => $sys_time,
                   ':pos_rate' => $pos_rate,
                   ':lakala_rate' => $lakala_rate
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from Crm_Shops where name = :name and description = :description and cover_pictureid = :cover_pictureid and brand_id = :brand_id and tags = :tags and mobile = :mobile and telphone = :telphone and city_id = :city_id and area_id = :area_id and district_id = :district_id and street_id = :street_id and address = :address and longitude = :longitude and latitude = :latitude and booking_num = :booking_num and view_num = :view_num and comm_num = :comm_num and check_status = :check_status and add_adminid = :add_adminid and add_time = :add_time and flag = :flag and sys_time = :sys_time and pos_rate = :pos_rate and lakala_rate = :lakala_rate" );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag,
                   ':sys_time' => $sys_time,
                   ':pos_rate' => $pos_rate,
                   ':lakala_rate' => $lakala_rate
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改shops
	public function updateRate($id,$pos_rate,$lakala_rate) {
		$sql = " update Crm_Shops set pos_rate = :pos_rate,lakala_rate = :lakala_rate where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':pos_rate' => $pos_rate,
                   ':lakala_rate' => $lakala_rate
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除shops
	public function delete($id) {
		$sql = " delete from Crm_Shops where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':id' => $id
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 分页查询shops
	public function searchByPages($sname,$area_id,$create_time1,$create_time2,$pos_rate1,$pos_rate2,$lakala_rate1,$lakala_rate2, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		if(!empty($sname))
		{
				
			$sname=" and
    (a.name like '%".trim($sname)."%'
        or b.name like '%".trim($sname)."%'
        or a.mobile like '%".trim($sname)."%'
        or a.telphone like '%".trim($sname)."%'
        or a.address like '%".trim($sname)."%') ";
		}else
		{
			$sname="";
		}
		
		$create_time="";
		if(!empty($create_time1) and !empty($create_time2))
		{
			$create_time="  and a.Create_Time between $create_time1 and $create_time2 ";
		}
		$pos_rate=0;
		if(!empty($pos_rate1) and !empty($pos_rate2))
		{
			$create_time="  and a.pos_rate between $pos_rate1 and $pos_rate2 ";
		}
		$lakala_rate=0;
		if(!empty($lakala_rate1) and !empty($lakala_rate2))
		{
			$create_time="  and a.lakala_rate between $lakala_rate1 and $lakala_rate2 ";
		}
		
		$sql = " SELECT 
    a . *, b.name area_name
FROM
    Crm_Shops a
        left join
    Crm_area_district b ON a.area_id = b.id
 where ( b.id = :area_id or :area_id=0 ) $sname  limit $lastpagenum,$pagesize" ;
	
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
                   ':area_id' => $area_id
		) );
		$objects = $query->fetchAll ();
		
		$sql=" select count(*)  from (SELECT 
    a . *, b.name area_name
FROM
    Crm_Shops a
        left join
    Crm_area_district b ON a.area_id = b.id
 where ( b.id = :area_id or :area_id=0 ) $sname
		
		) aa ";
		
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
                   ':area_id' => $area_id
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部shops
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shops " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取shops
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shops WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>