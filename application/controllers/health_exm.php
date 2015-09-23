<?php

class health_exm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('health_exm_model');
		$this->load->helper('url');
		#$this->load->library('session');
		$this->load->helper('cookie');
	}
	
	public function index()
	{
		redirect('health_exm/set_patient','refresh');
	}
  
  public function create()
  {
  	$this->load->helper('form');
  	$this->load->library('form_validation');
  
  	$data['title'] = '修改/新建客人';
  	
  
  	$this->form_validation->set_rules('ID', 'ID', 'trim|numeric|min_length[9]|max_length[10]|required');
  	$this->form_validation->set_rules('name', '姓名', 'trim|required');
  	$this->form_validation->set_rules('gender', '性别', 'trim|required');
  	$this->form_validation->set_rules('birthday', '生日', 'trim|required');
  	$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
	if ($this->input->cookie('ID',true)& $this->input->cookie('ID',true)!='template')
	{
        $checkpat_obj = $this->health_exm_model->find_pat($this->input->cookie('ID'));
  		$checkpat_arr = iterator_to_array($checkpat_obj);
  		$pat_data = current($checkpat_arr);
  		$pat_uid=key($checkpat_arr);

	}
  	if ($this->form_validation->run() === FALSE)
  	{
  		
  		if ($this->input->post('submit')==='删除')
  		{
  			if (isset($pat_uid)){
  				$this->health_exm_model->remove_patient($pat_uid);
  				delete_cookie('ID');
  				redirect('health_exm/wrt_record','refresh');
  			}
  			else
  			{
  				redirect('health_exm/create','refresh');
  			}
  		}
  		$this->load->view('templates/header', $data);
  		if (isset($pat_data))
  		{
  			$this->load->view('health_exm/create',$pat_data);
  		}
  		else 
  		{
  			$this->load->view('health_exm/create');
  		}
  		#$this->load->view('templates/footer');
  
  	}
  	else
  	{
  		if ($this->input->post('submit')==='删除')
  		{
  			if (isset($pat_uid)){
  				$this->health_exm_model->remove_patient($pat_uid);
  				delete_cookie('ID');
  				
  			}
  		}
  		else 
  		{
  			if (isset($pat_uid)){
  				$this->health_exm_model->update_patient($pat_uid);
  			}else
  			{
  				$pat_uid=$this->health_exm_model->set_patient();
  			}
  		
  			$this->input->set_cookie('ID',$pat_uid,86400 * 365 * 5); 
  		}
  		redirect('health_exm/wrt_record','refresh');

  	}
  }
  
  public function patlist()
  {
  	$data['patients'] = $this->health_exm_model->get_patlist();
  	$data['title'] = 'patient list';
  	
  	$this->load->view('templates/header', $data);
  	$this->load->view('health_exm/patlist', $data);
  	#$this->load->view('templates/footer');
  }
  
  public function patlist_today()
  {
  	$data['patients'] = $this->health_exm_model->get_patlist_today();
  	$data['title'] = 'patient list today';
  	 
  	$this->load->view('templates/header', $data);
  	$this->load->view('health_exm/patlist', $data);
  	#$this->load->view('templates/footer');
  }
  
  public function wrt_record()
  {
    if(!$this->input->cookie('ID',true)|$this->input->cookie('ID',true)==='template') redirect('health_exm/set_patient?error=ID', 'refresh');
  	if(!$this->input->cookie('dpt',true)) redirect('health_exm/set_dpt?error=ID', 'refresh');
  	
    $this->load->helper('form');
  	$this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
  	
  	$this->form_validation->set_rules('MR', '病历记录', 'required');
  	
  	
  	$dpt=$this->input->cookie('dpt');
  	$ID=$this->input->cookie('ID');
  	$checkpat_obj = $this->health_exm_model->find_pat($this->input->cookie('ID'));
  	$checkpat_arr = iterator_to_array($checkpat_obj);
  	$pat_data = current($checkpat_arr);
  	$data['ID']=$pat_data['ID'];
  	$data['name']=$pat_data ['name'];
  	$data['dpt']=$dpt;
  	$data['title']=$dpt.':'.$pat_data['name'];
  	
  	if (array_key_exists($dpt,$pat_data))
  		{
  			$data['MR']=$pat_data[$dpt]; 
  		}
  	else
  		{
  			$data['MR']= '';
  		}
      
      #模板调用
      $checkpat_obj = $this->health_exm_model->find_template($dpt);
      $checkpat_arr = iterator_to_array($checkpat_obj);
      if (count($checkpat_arr) > 0) {
          $temp_data = current($checkpat_arr);
          $data['temp']=$temp_data['template'];
      }else
      {
          $data['temp']='';
      }
  	#加生命体征
  	if (array_key_exists('生命体征',$pat_data)) $data['vitalsign']=$pat_data['生命体征'];
  	if ($this->form_validation->run() === FALSE)
  	{
  		$this->load->view('templates/header', $data);
  		$this->load->view('health_exm/wrt_record',$data);
  		#$this->load->view('templates/footer');
        if ($dpt=='健康建议'){
                $data['pat_data']=$pat_data;
                $this->load->view('health_exm/report',$data);
                }
  	
  	}
  	else
  	{
		if ($this->input->post('submit')==='重载模板')
		{
			$data['MR']='';
			$this->load->view('templates/header', $data);
			$this->load->view('health_exm/wrt_record',$data);
    
		}
		elseif ($this->input->post('submit')==='取消')
		{
			delete_cookie('ID');
			redirect('health_exm/set_patient','refresh');
		}
		else
		{
			$this->health_exm_model->wrt_MR($ID,$dpt,$this->input->post('MR'));
			delete_cookie('ID');
            redirect('health_exm/set_patient','refresh');
		}

  	}
  }
    
  
  public function set_dpt()
  {
  	$this->load->helper('form');
  	$this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
  	
  	$this->form_validation->set_rules('dpt', '科室', 'required');
  	$data['title']='请选择科室';
  	if ($this->form_validation->run() === FALSE)
  	{
  		$this->load->view('templates/header', $data);
  		$this->load->view('health_exm/set_dpt');
  		#$this->load->view('templates/footer');
  	
  	}
  	else
  	{
  		$this->input->set_cookie('dpt',$this->input->post('dpt'),86400 * 365 * 5);
  		if (!$this->input->cookie('ID',true)) {
  			redirect('/health_exm/set_patient', 'refresh');
  		}else
  		{
  			redirect('/health_exm/wrt_record', 'refresh');
  		}
  	}
  }
  	public function set_patient()
  	{
  		if (!$this->input->cookie('dpt',true)) redirect('/health_exm/set_dpt', 'refresh');
  			$this->load->helper('form');
  			$this->load->library('form_validation');
  			$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
  			$this->form_validation->set_rules('ID', 'ID', 'trim|numeric|min_length[9]|max_length[10]|required');
  			$data['title']='请选择客户';
  			if ($this->input->cookie('ID',true)&$this->input->cookie('ID',true)!='template') $data['ID']=$this->health_exm_model->get_id($this->input->cookie('ID',true));
  			if ($this->form_validation->run() === FALSE)
  			{
  				$this->load->view('templates/header', $data);
  				$this->load->view('health_exm/set_patient');
  				#$this->load->view('templates/footer');
  				 
  			}
  			else
  			{
  				$checkpat_obj = $this->health_exm_model->find_pat_by_id($this->input->post('ID'));
  				$checkpat_arr = iterator_to_array($checkpat_obj);
  				if (count($checkpat_arr) > 0)
  				{
  					$this->input->set_cookie('ID',key($checkpat_arr),86400 * 365 * 5); 
  					redirect('health_exm/wrt_record','refresh');
  				} 
  				else
  				{
  					$data['error']= '无此客户';
  					$this->load->view('templates/header', $data);
  					$this->load->view('health_exm/set_patient', $data);
  				}
  			}
  	}
  	
  	public function create_pat_by_list()
  	{
  		$this->load->helper('form');
  		$this->load->library('form_validation');
  		$this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
  		 
  		$this->form_validation->set_rules('list', 'list', 'required');

  		if ($this->form_validation->run() === FALSE)
  		{
  			$this->load->view('health_exm/create_pat_by_list');
  		}
  		else
  		{
  			$data['error']=$this->health_exm_model->set_by_list($this->input->post('list'));
  			#redirect('/health_exm/patlist', 'refresh');
  			#$data['error']=$this->input->post('list'];
  			$this->load->view('health_exm/create_pat_by_list',$data);
  		}
  	}
  	
  	public function patient_info($uid)
  	{
  		$this->input->set_cookie('ID',$uid,86400 * 365 * 5);
  		redirect('health_exm/create','refresh');
  	}
  	public function report($uid)
  	{
  		$this->input->set_cookie('ID',$uid,86400 * 365 * 5);
  		$checkpat_obj = $this->health_exm_model->find_pat($uid);
  		$checkpat_arr = iterator_to_array($checkpat_obj);
  		$pat_data = current($checkpat_arr);
  		$data['pat_data']=$pat_data;
  		$data['title']='report';
  		
  		$this->load->view('templates/header',$data);
  		$this->load->view('health_exm/report',$data);
  	}
  	public function wrt_record_w_id($uid)
  	{
  		$this->input->set_cookie('ID',$uid,86400 * 365 * 5);
  		redirect('health_exm/wrt_record','refresh');
  	}
  	public function set_template()
  	{
        $this->input->set_cookie('ID','template',86400 * 365 * 5);
        if(!$this->input->cookie('dpt',true)) redirect('health_exm/set_dpt?error=ID', 'refresh');
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        
        $this->form_validation->set_rules('MR', '病历记录', 'required');
        
        
        $dpt=$this->input->cookie('dpt');
        $data['ID']='';
        $data['name']='模板';
        $data['dpt']=$dpt;
        $data['title']=$dpt.':模板';
        
        $checkpat_obj = $this->health_exm_model->find_template($dpt);
        $checkpat_arr = iterator_to_array($checkpat_obj);
        if (count($checkpat_arr) > 0) {
            $temp_data = current($checkpat_arr);
            $data['MR']=$temp_data['template'];
        }else
        {
            $data['MR']='';
        }
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('health_exm/wrt_record',$data);
            #$this->load->view('templates/footer');
        }
        else
        {
            
            if ($this->input->post('submit')==='取消')
            {
                delete_cookie('ID');
                redirect('health_exm/set_patient','refresh');
            }
            else
            {
                $this->health_exm_model->set_template($dpt,$this->input->post('MR'));
                delete_cookie('ID');
                redirect('health_exm/set_patient','refresh');
            }
            
        }
  	}
    
    public function show_cal()
    {
        $prefs = array(
                       'show_next_prev'  => TRUE,
                       'next_prev_url'   => 'http://localhost:8080/health_exm/show_cal/'
                       );
        
        $prefs['template'] = array(
                                   'table_open'           => '<table class="calendar">',
                                   'cal_cell_content'       => '<font color="red">{day}</front>',
                                   'cal_cell_content_today' => '<font color="red"><bold>{day}</bold></front>'
                                   );
        
        $data = array(
                      3  => 'http://example.com/news/article/2006/03/',
                      7  => 'http://example.com/news/article/2006/07/',
                      13 => 'http://example.com/news/article/2006/13/',
                      26 => 'http://example.com/news/article/2006/26/'
                      );
        
        $this->load->library('calendar', $prefs);
        
        echo $this->calendar->generate($this->uri->segment(3), $this->uri->segment(4), $data);
    }
}