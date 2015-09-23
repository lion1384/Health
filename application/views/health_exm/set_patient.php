<div class="container">

      <!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
<h2>选择病人</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('health_exm/set_patient',array('class' => 'form-inline')); ?>
<?php   if(isset($error)) {?>
                        <div class="alert alert-warning">
                        <?php echo $error;	?>
                        </div>
                        <?php }?>
<div class="form-group">
  <label for="ID" class="control-label">ID</label> 
  <input type="input" name="ID" id="ID_input" class=" form-control" value="<?php echo set_value('ID',isset($ID) ? $ID:''); ?>" >
</div>
  
<input type="submit" name="submit" class="btn btn-primary" value="set patient" > 
<script type="text/javascript">

document.getElementById("ID_input").select();
</script>
</form>
</div>
</div>
