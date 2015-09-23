<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('HR/upload_record');?>

<input type="file" name="record" size="20" />
<input type="text" name="note" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>