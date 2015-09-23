




<div class="container">

      <!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
        <h2>请选择科室</h2>
        <?php echo validation_errors(); ?><?php echo form_open('health_exm/set_dpt') ?>
		<div class="btn-group" role="group" aria-label="...">
  			<input type="submit" class="btn btn-default" name="dpt" value="生命体征" /> 
  			<input type="submit" class="btn btn-default" name="dpt" value="内科" /> 
			<input type="submit" class="btn btn-default" name="dpt" value="外科" /> 
			<input type="submit" class="btn btn-default" name="dpt" value="口腔科" /> 
			<input type="submit" class="btn btn-default" name="dpt" value="妇科" /> 
			<input type="submit" class="btn btn-default" name="dpt" value="耳鼻喉科" />
			<input type="submit" class="btn btn-default" name="dpt" value="眼科" />
            <input type="submit" class="btn btn-default" name="dpt" value="健康建议" />
		</div></form>
	</div>
</div>
	
