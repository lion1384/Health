
<div class="container">
<h2><?php echo $pat_data['name'];?> <small>
<?php echo $pat_data['Gender']=='female' ?  '女士' : '先生';?></small></h2>
<h3>健康评估报告</h3>
<dl class="dl-horizontal">
  	<dt>一般情况：</dt>
  	<dd><?php if(array_key_exists('生命体征',$pat_data)) echo $pat_data['生命体征'];else echo '未完成';?></dd>
	<br />
	<dt>内科：</dt>
  	<dd><?php if(array_key_exists('内科',$pat_data)) echo trim($pat_data['内科']);else echo '未完成';?></dd>
	<br />
	<dt>外科：</dt>
  	<dd><?php if(array_key_exists('外科',$pat_data)) echo trim($pat_data['外科']);else echo '未完成';?></dd>
	<br />  
  	<?php if ($pat_data['Gender']=='female') {?>
  	<dt>妇科：</dt>
<dd><?php if (array_key_exists('妇科',$pat_data)) echo trim($pat_data['妇科']); else echo '未完成';?></dd>
  	<br />
  	<?php }?>
  	<dt>耳鼻喉科：</dt>
  	<dd><?php if(array_key_exists('耳鼻喉科',$pat_data)) echo trim($pat_data['耳鼻喉科']);else echo '未完成';?></dd>
  	<br />
	<dt>眼科：</dt>
  	<dd><?php if(array_key_exists('眼科',$pat_data)) echo trim($pat_data['眼科']);else echo '未完成';?></dd>
	<br />
	<dt>口腔：</dt>
  	<dd><?php if(array_key_exists('口腔科',$pat_data)) echo trim($pat_data['口腔科']);else echo '未完成';?></dd>
    <br />
    <dt>结论与建议：</dt>
    <dd><?php if(array_key_exists('健康建议',$pat_data)) echo trim($pat_data['健康建议']);else echo '未完成';?></dd>

</dl>
</div>
</body>
</html>