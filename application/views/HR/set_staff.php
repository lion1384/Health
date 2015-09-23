
<div class="container">
<h2>修改/新建员工</h2>

<?php echo validation_errors();
    echo $this->input->get('error');?>

<?php echo form_open('HR/set_staff', array('class' => 'form-horizontal')) ?>
	<?php if (isset($ID)) echo '<input type="hidden" name="fixID" value=true>'; ?> 
  	<div class="form-group">
 		<label for="ID" class="col-sm-2 control-label hidden-xs">工号</label>
  		<div class="col-sm-10">
  		<?php if (isset($ID)){?>
  		<p class="form-control-static"><?php if (isset($removed) && $removed) echo '<s>'.$ID.'</s>';else echo $ID; ?></p>
  		<input type="hidden" name="ID" value="<?php echo $ID;?>">
  		<?php }else{?>
  			<input type="input" class="form-control" name="ID" placeholder="Enter ID" value="<?php echo set_value('ID');?>">
  		<?php }?>
		</div>
	</div>
  	<div class="form-group">
  		<label for="name" class="col-sm-2 control-label hidden-xs">姓名</label>
  		<div class="col-sm-10">
  			<input type="input" name="name" class="form-control" placeholder="姓名" value="<?php echo set_value('name',isset($name) ? $name :''); ?>">
  		</div>
  	</div>
  	<div class="form-group">
  			<label for="gender" class="col-sm-2 control-label hidden-xs">性别</label>
  			<div class="col-sm-10">
  			<select name="gender" class="form-control">
				<option value="male" <?php echo set_select('gender', 'male', ( isset($gender) and ($gender=='male' ? TRUE : '') ) ); ?>>男</option>
				<option value="female" <?php echo set_select('gender', 'female', ( isset($gender) and ($gender=='female' ? TRUE : '') )); ?>>女</option>
			</select></div>	
	</div>
	<div class="form-group">
        <label for="birthday" class="col-sm-2 control-label hidden-xs">生日</label>
        <div class="col-sm-10">
        	<input name="birthday" type="text" placeholder="生日" value="<?php echo set_value('birthday',isset($birthday) ? $birthday :''); ?>" readonly class="form-control form-date">
		</div>
	</div>
    <div class="form-group">
    <label for="cID" class="col-sm-2 control-label hidden-xs">打卡机编号</label>
    <div class="col-sm-10">
    <input type="input" class="form-control" name="cID" placeholder="打卡机编号" value="<?php echo set_value('cID',isset($cID) ? $cID :''); ?>" >
    </div>
    </div>
	<input type="submit" name="submit" class="col-sm-offset-2 btn btn-primary" value="保存" /> 
	<?php if (isset($removed) && $removed){?>
	<input type="submit" class="btn btn-danger" name="submit" value="恢复" />
	<?php }else{?>
	<input type="submit" class="btn btn-danger" name="submit" value="删除" /><?php }?></div>

</form>
</div>

<script src="<?php echo site_url("/lib/js/jquery.min.js");?>"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="<?php echo site_url("/lib/bootstrap/js/bootstrap.min.js");?>"></script>
<script src="<?php echo site_url("/lib/bootstrap-datepicker/js/bootstrap-datetimepicker.js");?>"></script>


<script type="text/javascript">
    $(".form-date").datetimepicker({
        language: 'zh-CN',
    	weekStart: 1,
        todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0,
		format: 'yyyy-mm-dd'
    });
</script>    