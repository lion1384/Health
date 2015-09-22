<?php echo validation_errors(); ?>

<?php echo form_open('health_exm/create_pat_by_list') ?>

<input type="input" name="list" placeholder="ID,name,Gender(male or female),Birthday(yyyy-m-d);[other]"] />
<input type="submit" name="submit" value="submit" />
<?php echo $error?>