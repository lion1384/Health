
<div class="container">
<H2><?php echo $start->format('Y年m月'); if (isset($name)) echo $name;?>打卡记录 ID:<?php echo $ID?></H2>
<table class="table table-hover">
<thead>
  <tr>
    <th>日期</th>
    <th>上班</th>
    <th>下班</th>
  </tr>
  </thead>
<?php 
foreach($Callist as $dayrec){
	echo '<tr><td>'.$dayrec['day'].'</td><td>'.$dayrec['in'].'</td><td>'.$dayrec['out'].'</td></tr>';

}

?></table></div>