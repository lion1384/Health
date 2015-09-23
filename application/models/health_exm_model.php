<?php
class health_exm_model extends CI_Model {

  public function __construct()
  {
    #$this->load->database();
  	#$this->$m = new MongoClient("mongodb://localhost/");
  }
  
  public function set_patient()
  {
  	#$this->load->helper('url');
  	$m = new MongoClient("mongodb://localhost/");
  	$HIS = $m->HIS;
  	$collection = $HIS->patient;
  	
  
  	$data = array(
  			'ID' => $this->input->post('ID'),
  			'name' => $this->input->post('name'),
  			'Birthday' => $this->input->post('birthday'),
  			'Gender' => $this->input->post('gender')
  	);
  
  	$collection->insert($data);
 
  	$obj= $m->HIS->patient->find(array("ID" => $this->input->post('ID')));
  	$checkpat_arr = iterator_to_array($obj);
  	return key($checkpat_arr);
  }
  

  public function update_patient($pat_uid)
  {
  	$m = new MongoClient("mongodb://localhost/");
  	$HIS = $m->HIS;
  	$collection = $HIS->patient;
  	$data = array(
  			'ID' => $this->input->post('ID'),
  			'name' => $this->input->post('name'),
  			'Birthday' => $this->input->post('birthday'),
  			'Gender' => $this->input->post('gender')
  	);
  	$respond = $m->HIS->patient->update(array("_id" => new MongoId($pat_uid)), array('$set' => $data));
  	
  	return $respond;
  }
  
  public function remove_patient($pat_uid)
  {
  	$m = new MongoClient("mongodb://localhost/");
  	$HIS = $m->HIS;
  	$collection = $HIS->patient;
  	return $collection->remove(array('_id'=>new MongoID($pat_uid)), array("justOne" => true));
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