<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
	
	<link href="<?php site_url("lib/bootstrap-wysiwyg/external/google-code-prettify/prettify.css")?>" rel="stylesheet">
	
	
	<link href="<?php echo site_url("/lib/css/navbar-fix-top.css");?>" rel="stylesheet">
    <title><?php echo $title?></title>

    <!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="<?php echo site_url("/lib/bootstrap/css/bootstrap.min.css");?>">
	<link rel="stylesheet" href="<?php echo site_url("/lib/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css");?>">
	<!-- 可选的Bootstrap主题文件（一般不用引入） -->
	<link rel="stylesheet" href="<?php echo site_url("");?>../lib/bootstrap/css/bootstrap-theme.min.css">

	<link href="<?php echo site_url("lib/Font-Awesome/css/font-awesome.css");?>" rel="stylesheet">

	<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
	<script src="<?php echo site_url("/lib/js/jquery.min.js");?>"></script>

	<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="<?php echo site_url("/lib/bootstrap/js/bootstrap.min.js");?>"></script>
	<script src="<?php echo site_url("/lib/bootstrap-datepicker/js/bootstrap-datetimepicker.js");?>"></script>
	
	<script src="<?php echo site_url("lib/bootstrap-wysiwyg/external/jquery.hotkeys.js")?>"></script>
	<script src="<?php echo site_url("lib/bootstrap-wysiwyg/external/google-code-prettify/prettify.js")?>"></script>
	<script src="<?php echo site_url("lib/bootstrap-wysiwyg/bootstrap-wysiwyg.js")?>"></script>
  </head>
<body>


    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top hidden-print">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">健康评估</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($this->uri->segment(2)=='set_patient') echo 'class="active"';?>><a href="<?php echo site_url("health_exm/set_patient");?>">选择病人</a></li>
            <li <?php if ($this->uri->segment(2)=='set_dpt') echo 'class="active"';?>><a href="<?php echo site_url("health_exm/set_dpt");?>">更改科室</a></li>
            <li <?php if ($this->uri->segment(2)=='create') echo 'class="active"';?>><a href="<?php echo site_url("health_exm/create");?>">更改客人信息</a></li>
            <li <?php if ($this->uri->segment(2)=='set_template') echo 'class="active"';?>><a href="<?php echo site_url("health_exm/set_template");?>">更改模板</a></li>
          	<li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">客户列表<span class="caret"></span></a>
          		<ul class="dropdown-menu" role="menu">
            		<li><a href="<?php echo site_url("health_exm/patlist_today");?>">今日客户列表</a></li>
            		<li><a href="<?php echo site_url("health_exm/patlist");?>">全部客户列表</a></li>
          		</ul>
        	</li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="<?php echo site_url("health_exm/set_dpt");?>">当前科室：<?php if($this->input->cookie('dpt',true)) echo $this->input->cookie('dpt',true)?><span class="sr-only">(current)</span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>




