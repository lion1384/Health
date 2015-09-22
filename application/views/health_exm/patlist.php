<div class="container">
<table  class="table table-hover">
  <thead>
  <tr>
    <th>ID</th>
    <th>姓名</th>
    <th>性别</th>
    <th>生命体征</th>
    <th>内科</th>
    <th>外科</th>
    <th>妇科</th>
    <th>耳鼻喉科</th>
    <th>口腔科</th>
    <th>眼科</th>
    <th>健康建议</th>
    <th>更新时间及报告</th>
  </tr>
  </thead>
  <tbody>
<?php foreach ($patients as $patient): 
		$fin=true;?>
  <tr>
    <td width=10%><a href="./wrt_record_w_id/<?php echo $patient['_id'] ?>">[<?php echo $patient['ID'] ?>]</a></td>
    <td width=2%><?php echo $patient['name'] ?></td>
    <td width=3%><?php if (array_key_exists('Gender',$patient)) echo $patient['Gender'] ?></td>
    <td width=10%><?php if (array_key_exists('生命体征',$patient)) echo $patient['生命体征'];
     else {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('内科',$patient)) echo $patient['内科'];
     else {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('外科',$patient)) echo $patient['外科'];
     else {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('妇科',$patient)) echo $patient['妇科'];
     elseif ($patient['Gender']=='female') {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('耳鼻喉科',$patient)) echo $patient['耳鼻喉科'];
     else {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('口腔科',$patient)) echo $patient['口腔科'];
     else {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('眼科',$patient)) echo $patient['眼科'];
     else {
     	echo '<font color=\'red\'>未完成</font>';
     	$fin=false;
     }?></td>
    <td width=10%><?php if (array_key_exists('健康建议',$patient)) echo $patient['健康建议'];
    else {
        echo '<font color=\'red\'>未完成</font>';
        $fin=false;
    }?></td>
    <td width=5%><?php if (array_key_exists('LastUpdatedTime',$patient)) echo $patient['LastUpdatedTime'];
     else {
     	echo '<font color=\'red\'>未开始</font>';
     	$fin=false;
     }
     if ($fin) echo '<p><a href="./report/'.$patient['_id'].'">report</a></p>'?><p><a href="./patient_info/<?php echo $patient['_id']?> ">修改个人信息</a></p></td>
  </tr>
<?php endforeach ?></tbody>
</table>
</div>

