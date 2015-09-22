<?php

class HR extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('HR_model');
		$this->load->helper('url');
		$this->load->helper('cookie');
        
        $this->_upload_error = '';
        $this->_uploaded_file_name = '';
        $this->_rec_suc='';
        $this->_rec_err='';
        define('_today', date('Y-m',time()));
        
	}
	
	public function index()
	{
		//redirect('health_exm/set_patient','refresh');
	}
	
	
    public function setalot($n=0)
    {
    	for ($x=1; $x<=$n; $x++) {

    	$staff_data['ID']='MZ'.sprintf("%03d",$x);
    	$staff_data['cID']=''.$x;
    	$this->HR_model->set_staff($staff_data);
    	//$staff_data['ID']=$this->input->post('ID');
    	//var_dump($staff_data);
    	}
    	
    	echo 'suss';

    }
    
  	public function set_staff($ID='new')
  	{
      $data['title'] = $ID.'新建人员';
      
      $this->load->helper('form');
      $this->load->library('form_validation');
      
      
      $this->form_validation->set_rules('name', '姓名', 'trim|required');
      //$this->form_validation->set_rules('lastnameE', '姓', 'trim|required');
      //$this->form_validation->set_rules('firstnameE', '名', 'trim|required');
      $this->form_validation->set_rules('gender', '性别', 'trim|required');
      $this->form_validation->set_rules('birthday', '生日', 'trim|required');
      $this->form_validation->set_rules('cID', '打卡机编号', 'trim|required');
      //$this->form_validation->set_rules('title', '职位', 'trim|required');
      
      $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
	
      if ($ID!='new')
      {
          $staffarr = $this->HR_model->find_staff($ID);
          //$checkpat_arr = iterator_to_array($checkpat_obj);
          if (count($staffarr)){
          	$staff_data = current($staffarr);
          }else{
          	$staff_data['ID']=strtoupper($ID);
          }
          $this->form_validation->set_rules('ID', '工号', 'trim|required|strtoupper');
          //$pat_uid=key($checkpat_arr);
      }else{
          $this->form_validation->set_rules('ID', '工号', 'trim|required|strtoupper');
      }
      
      if ($this->input->post('submit')==='删除' && $this->input->post('fixID'))
      { 
              $data['error']=$this->HR_model->remove_staff($this->input->post('ID'));
              redirect("HR/set_staff?error=".$this->input->post('ID')."removed",'refresh');
      }
      
      if ($this->input->post('submit')==='恢复' && $this->input->post('fixID'))
      {
      	$data['error']=$this->HR_model->unremove_staff($this->input->post('ID'));
      	redirect("HR/set_staff?error=".$this->input->post('ID')."unremoved",'refresh');
      }
      
      if ($this->form_validation->run() === FALSE)
      {
          $this->load->view('templates/header', $data);
  		if (isset($staff_data))
  		{
  			if (array_key_exists('birthday',$staff_data))  $staff_data['birthday']=date('Y-m-d',$staff_data['birthday']->sec);
            $this->load->view('HR/set_staff',$staff_data);
  		}
  		else 
  		{
  			$this->load->view('HR/set_staff');
  		}
  		#$this->load->view('templates/footer');
  
  	}
  	else
  	{
        
        $staff_data['ID']=$this->input->post('ID');
        $staff_data['name']=$this->input->post('name');
        $staff_data['gender']=$this->input->post('gender');
        $staff_data['birthday']=new MongoDate(strtotime($this->input->post('birthday')));
        $staff_data['cID']=$this->input->post('cID');
        //$staff_data['ID']=$this->input->post('ID');
        
        $this->HR_model->set_staff($staff_data);
        //$this->input->set_cookie('ID',$pat_uid,86400 * 365 * 5);
  		redirect('HR/set_staff','refresh');

  	}
  }
  
    public function upload_record()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        
        $data['title']='上传打卡记录';
        
        $this->form_validation->set_rules('note', '打卡记录', 'trim');
        
        if ($this->form_validation->run() === FALSE)
        {
            #$this->load->view('templates/header', $data);
            $data['error']=$_FILES['record']['name'];
            $this->load->view('HR/upload_record',$data);
            #$this->load->view('templates/footer');
            
        }
        else
        {
            if(!empty($_FILES['record']['name']))
            {
                $upload_result = $this->_do_upload();
                
                if($upload_result !== TRUE)		// Upload image failed
                {
                    $data['error'] = $this->_upload_error;
                    $this->load->view('HR/upload_record', $data);
                }
                else	// Upload file success
                {
                    
                    $result = $this->_analysis_record($this->_uploaded_file_name);
                    if ($result) $data['error'] = 'success'.$result."\n"; else{
                        $data['error']='fail'."\n";
                        @unlink('./uploads/'.$this->_uploaded_file_name);
                    }
                    $this->load->view('HR/upload_record', $data);
                }
            }
        }
    }
    
    private function _do_upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'txt';
        $config['max_size']	= '3000';	// 3000 kb

        
        $this->load->library('upload', $config);
        
        $field_name = 'record';
        
        if ( ! $this->upload->do_upload($field_name) )
        {
            $this->_upload_error = $this->upload->display_errors();
            
            return FALSE;
        }
        else
        {
            $upload_data = $this->upload->data();
            $this->_uploaded_file_name = $upload_data["file_name"];
            return TRUE;
        }
    }
    
    private function _analysis_record($filename)
    {
        $directory = './uploads/';
        $this->load->helper('file');
        $alltext=read_file($directory.$filename);
        $txtarr=explode("\n",$alltext);
        if (!preg_match("/^No\s+TMNo\s+EnNo/", array_shift($txtarr))) return FALSE;
        $i=0;
        foreach ($txtarr as $line){
            if (trim($line)) $wordarr=explode("\t",$line);
            $result=$this->HR_model->save_record($wordarr[2],$wordarr[6],$filename);
            if ($result){
                $this->_rec_suc=$this->_rec_suc.$line."\n";
                $i=$i+1;
            }else{
                $this->_rec_err=$this->_rec_err.$line."\n";
            }
        }
        
        return $i;
    }
    


    public function reclist($ID,$year,$month){
    	$start=new MongoDate(strtotime($year.'-'.$month.'-1'));
    	$end=new MongoDate(strtotime($year.'-'.(intval($month)+1).'-1'));
    	$recdata=$this->HR_model->get_checklist($ID,$start,$end);
    	$recli=$recdata['reclist'];
    	
    	$start=new DateTime($year.'-'.$month.'-1');
    	$end=new DateTime($year.'-'.(intval($month)+1).'-1');
    	
    	$ctime=array_shift($recli);
    	$wkday=array('1'=>'星期一','2'=>'星期二','3'=>'星期三','4'=>'星期四','5'=>'星期五','6'=>'星期六','0'=>'星期日');
    	$Callist=array();
    	while ($start<$end){
    		$tmp=clone $start;
    		$start->modify( '+1 day' );
    		$Strday=$tmp->format('Y-m-d').' '.$wkday[$tmp->format('w')];
    		while ($ctime>$tmp && $ctime<$start){
    			if (isset($intime)) $outtime=clone $ctime; else $intime=clone $ctime;
    			//echo $ctime->format('Y-m-d H:i:s ');
    			$rec=array_shift($recli);
    			if ($rec){
    				$ctime=$rec;}
    				else break;
    		}
    		
    		if (isset($intime)){
    			if (!isset($outtime) && intval($intime->format('H'))>=12) {
    				$outtime=clone $intime;
    				$Strin='';
    				unset($intime);
    			}else{
    				$Strin=$intime->format('H:i:s');
    				unset($intime);}
    		}else $Strin='';

    		if (isset($outtime)){
    			$Strout=$outtime->format('H:i:s');
    			unset($outtime);
    		}else $Strout='';
    		
			$tmparr=array('day'=>$Strday,'in'=>$Strin,'out'=>$Strout);
			array_push($Callist,$tmparr);   	
    	}
    	$data['Callist']=$Callist;
    	$data['start']=new DateTime($year.'-'.$month.'-1');
    	$data['end']=new DateTime($year.'-'.(intval($month)+1).'-1');
    	$data['ID']=$ID;
    	if (array_key_exists('name',$recdata))
    	$data['name']=$recdata['name'];
    	$this->load->view('templates/header', $data);
    	$this->load->view('HR/test', $data);
    }
    
    //public function Cal($year)

  	
  	public function setAgenda($month=_today,$tempID=null,$ID=null){
  		echo $ID.$month.$tempID;
  		$start=new DateTime($year.'-'.$month.'-1');
  		$end=new DateTime($year.'-'.(intval($month)+1).'-1');
  		 
  		$Callist=array();
  		while ($start<$end){
  			$tmp=clone $start;
  			$start->modify( '+1 day' ); 
  		}
  		var_dump($this->HR_model->getAgenda(array('MZ033','MZ032'),$month));
  		
  	}
  	
  	public function setAgendaTime($ID=null,$datestr,$TtempID=null,$FtempID=null){
  		if ($ID){
  		$start=new DateTime($datestr);
  		$end=new DateTime($datestr);
  		$startstr='PT9H30M';
  		$endstr='PT20H30M';
  		$start->add(new DateInterval($startstr));
  		$end->add(new DateInterval($endstr));
  		var_dump($start);
  		Var_dump($end);
  		//var_dump($this->HR_model->setAgendaTime($ID,$start,$end));
  		var_dump($this->HR_model->setAgenda($ID,$start,$end));
  		
  		//var_dump($this->HR_model->getAgenda(array('MZ033','MZ032'),$datestr));
  		}
  		//redirect('HR/setAgenda/'.$ID.'/'.$start->format('Y-m').'/'.$tempID,'refresh');
  	}
  	
  	public function setAgendaAffair($tempID,$ATid){
  		
  	}
}