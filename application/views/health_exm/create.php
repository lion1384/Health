
<div class="container">
<h2>修改/新建客人</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('health_exm/create', array('class' => 'form-horizontal')) ?>
  	<div class="form-group">
 		<label for="ID" class="col-sm-2 control-label hidden-xs">病历号</label> 
  		<div class="col-sm-10">
  			<input type="input" class="form-control" name="ID" placeholder="Enter ID" value="<?php echo set_value('ID',isset($ID) ? $ID :''); ?>" >
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
				<option value="male" <?php echo set_select('gender', 'male', ( isset($Gender) and ($Gender=='male' ? TRUE : '') ) ); ?>>男</option>
				<option value="female" <?php echo set_select('gender', 'female', ( isset($Gender) and ($Gender=='female' ? TRUE : '') )); ?>>女</option>
			</select></div>	
	</div>
	<div class="form-group">
        <label for="birthday" class="col-sm-2 control-label hidden-xs">生日</label>
        <div class="col-sm-10">
        	<input name="birthday" type="text" placeholder="生日" value="<?php echo set_value('birthday',isset($Birthday) ? $Birthday :''); ?>" readonly class="form-control form-date">
		</div>
	</div>

	<input type="submit" name="submit" class="col-sm-offset-2 btn btn-primary" value="保存" /> <input type="submit" class="btn btn-danger" name="submit" value="删除" /></div> 

</form>
</div>

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