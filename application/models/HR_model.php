<?php
class HR_model extends CI_Model {

  public function __construct()
  {
    #$this->load->database();
  	#$this->$m = new MongoClient("mongodb://localhost/");
  }
  
    public function save_record_old($cID,$time,$file) #cID 打卡ID
    {
  	#$this->load->helper('url');
        $m = new MongoClient("mongodb://localhost/");
  	
        $collection = $m->HIS->checkrecord;
        $cTime=new MongoDate(strtotime($time));
  
        $data = array(
  			'cID' => $cID,
  			'cTime' => $cTime,
  			'cFile' => $file,
  			'rTime' => new MongoDate(strtotime('now'))
                  );
  
        $obj= $m->HIS->checkrecord->find(array("cID" => $cID,"cTime"=>$cTime));
        if ($obj->count()===0){
            $m->HIS->checkrecord->insert($data);
            return true;
        }else{
            return false;
        }
  }
  
  public function save_record($cID,$time,$file) #cID 打卡ID
  {
  	#$this->load->helper('url');
  	$m = new MongoClient("mongodb://localhost/");

  	$cTime=new MongoDate(strtotime($time));
  
  	$data = array(
  			//'cID' => $cID,
  			'cTime' => $cTime,
  			'cFile' => $file,
  			'rTime' => new MongoDate(strtotime('now'))
  	);
  
  	$obj= $m->HIS->staff->find(array("cID" => $cID,"checkrecord.cTime"=>$cTime));
  	$check_staff= $m->HIS->staff->find(array("cID" => $cID));
  	if ($obj->count()===0 && $check_staff->count()!=0){
  		$response=$m->HIS->staff->update(array('cID' => $cID), array('$push' => array('checkrecord'=> $data)));
  		return $response;
  	}else{
  		return false;
  	}
  }

  public function set_staff($data)
  {
  	$m = new MongoClient("mongodb://localhost/");
  	$respond = $m->HIS->staff->update(array('ID' => $data['ID']), array('$set' => $data), array('upsert'=>true));
  	return $respond;
  }
    
    public function find_staff($ID)
    {
        $m = new MongoClient("mongodb://localhost/");
        $obj= $m->HIS->staff->find(array("ID" => $ID));
        return iterator_to_array($obj);
    }
    
  
  public function remove_staff($ID)
  {
  	$staffarr=$this->find_staff($ID);
  	$data=current($staffarr);
  	$data['removed']=true;
  	return $this->set_staff($data);
  }
  
  public function unremove_staff($ID)
  {
  	$staffarr=$this->find_staff($ID);
  	$data=current($staffarr);
  	$data['removed']=false;
  	return $this->set_staff($data);
  }
  
  public function get_checklist($ID,$start,$end){
  	$m = new MongoClient("mongodb://localhost/");
  	$obj= $m->HIS->staff->find(array("ID" => $ID,"checkrecord.cTime"=>array('$gt' => $start,'$lte' => $end)));
  	$Tstart=new DateTime(date('Y-m-d H:i:s',$start->sec));
  	$Tend=new DateTime(date('Y-m-d H:i:s',$end->sec));
  	$arr=current(iterator_to_array($obj));
  	$returnarr=array();
  	if ($arr){
  	foreach ($arr['checkrecord'] as $rec){
  		$ctime=new DateTime(date('Y-m-d H:i:s',$rec['cTime']->sec));
  		if ($ctime>$Tstart && $ctime<$Tend) array_push($returnarr,$ctime);
  	}}
  	asort($returnarr);
  	$data['reclist']=$returnarr;
  	if ($arr) if (array_key_exists('name',$arr))  $data['name']=$arr['name'];
  	return $data;
  }
  
  public function setAgenda($ID,$start,$end,$affair=null){
  	$mdb=new MongoClient("mongodb://localhost/");
  	$mstart=new MongoDate(strtotime($start->format(DateTime::ISO8601)));
  	$mend=new MongoDate(strtotime($end->format(DateTime::ISO8601)));
  	$mdaystart=new MongoDate(strtotime($start->format('Y-m-d')));
  	$dayend=clone $start;
  	$dayend->modify( '+1 day' );
  	$mdayend=new MongoDate(strtotime($dayend->format('Y-m-d')));
  	$data=array('ID'=>$ID,'start'=>$mstart,'end'=>$mend,'affair'=>$affair);
  	
  	//是否新的一天
  	$result=$mdb->HIS->agenda->find(array('ID'=>$ID,'start'=>array('$gte'=>$mdaystart,'$lt'=>$mdayend)));
  	return iterator_to_array($result);
  }
  
  public function setAgendaTime($ID,$start,$end){
  	$m = new MongoClient("mongodb://localhost/");
  	$mstart=new MongoDate(strtotime($start->format(DateTime::ISO8601)));
  	$mend=new MongoDate(strtotime($end->format(DateTime::ISO8601)));
  	$data=array('ID'=>$ID,'start'=>$mstart,'end'=>$mend);
  	$result=$m->HIS->agenda->update(array('ID' => $ID,'$or'=>array(array('start'=>array('$gte' => $mstart,'$lt' => $mend)),array('end'=>array('$gt' => $mstart,'$lte' => $mend)))), array('$set' => $data), array('upsert'=>true,'multiple'=>true));
  	if ($result['n']>1) {
  		$resultn=iterator_to_array($m->HIS->agenda->find(array('ID' => $ID,'start'=>$mstart,'end'=>$mend)));
  		$i=count($resultn);
  		for ($x=1;$x<$i;$x++){
  			$m->HIS->agenda->remove(array('_id'=>new MongoId(key($resultn))));
  			next($resultn);
  		}
  	}
  	return $result;
  }
  
  
  
  public function setAgendaTmpT($tmpname,$start,$end,$note){
  	
  }
  
  public function setAgendaTmpF($tmpname,$where,$task,$note){
  	
  }
  
  public function getAgenda($IDs,$datestr){
  	list($year,$month)=explode('-',$datestr);
  	$start=new MongoDate(strtotime($year.'-'.$month.'-1'));
  	$end=new MongoDate(strtotime($year.'-'.(intval($month)+1).'-1'));
  	$m = new MongoClient("mongodb://localhost/");
  	$cursor=$m->HIS->agenda->find(array('ID' => array('$in'=>$IDs),'start'=>array('$gte' => $start,'$lt' => $end)));
  	$cursor->sort(array('ID' => 1));
  	return iterator_to_array($cursor);
  }
  
  
  
  
  public function get_patlist()
  {
  	$m = new MongoClient();
  	return $m->HIS->patient->find();
 
  }
  
  public function get_patlist_today()
  {
  	$m = new MongoClient();
  	$today=date("Y-m-d");
  	return $m->HIS->patient->find(array("LastUpdatedTime" => new MongoRegex("/$today/")));
  
  }
  
  public function find_pat($ID)
  {
  	$m = new MongoClient();
  	return $m->HIS->patient->find(array("_id" => new MongoId($ID)));
  }
  
  public function get_id($uid)
  {
  	$m = new MongoClient();
  	$checkpat_obj = $m->HIS->patient->find(array("_id" => new MongoId($uid)));
  	$checkpat_arr = iterator_to_array($checkpat_obj);
  	$pat_data = current($checkpat_arr);
  	return $pat_data['ID'];
  }
  
  public function find_pat_by_id($ID)
  {
  	$m = new MongoClient();
  	return $m->HIS->patient->find(array("ID" => $ID));
  }
  
  public function wrt_MR($ID,$dpt,$MR)
  {
  	$m = new MongoClient();
  	
  	$data = array(
  			$dpt => $MR,
  			'LastUpdatedTime' => date("Y-m-d H:i:s"),
  	);
  	
  	#if($processed_image_name) $data['Image'] = $processed_image_name;	//如果用户未上传Image，则$processed_image_name为空。此时不应更新数据库，应保留原有数据
  	
  	$respond = $m->HIS->patient->update(array("_id" => new MongoId($ID)), array('$set' => $data));
  	
  	return $respond;
  }
  
  public function set_template($dpt,$template)
  {
      $m = new MongoClient();
      
      $data = array(
                    'department' => $dpt,
                    'template' => $template,
                    );
      
      #if($processed_image_name) $data['Image'] = $processed_image_name;	//如果用户未上传Image，则$processed_image_name为空。此时不应更新数据库，应保留原有数据
      
      $respond = $m->HIS->template->update(array('department' => $dpt), array('$set' => $data), array('upsert'=>true));
      return $respond;
  }
    
    public function find_template($dpt)
    {
        $m = new MongoClient();
        return $m->HIS->template->find(array("department" => $dpt));
    }
  
  
  public function set_by_list($list)
  {
  	$m = new MongoClient();
  	
  	foreach (explode(';', $list) as $pat_info)
  	{
  		list($ID, $name, $Gender, $Birthday) = explode(',', $pat_info);
  		$data = array('ID' => $ID,
  			  	'name' => $name,
  				'Birthday' => $Birthday,
  				'Gender' => $Gender);
  		$m->HIS->patient->insert($data);
  	}
  	return $list;
  }
}