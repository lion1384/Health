
<div class="container">

<?php echo validation_errors(); ?>

<?php echo form_open('health_exm/'.$this->uri->segment(2), array('class' => 'form-horizontal', 'onsubmit'=>'formSubmit(this)')) ?>

<?php   if(isset($error)) {?>
                        <div class="alert alert-warning">
                        <?php echo $error;	?>
                        </div>
                        <?php }?>

  <h2><?php echo $name;?> <small>ID：<?php echo $ID;?>  科室：<?php echo $dpt;?></small></h2><br />
  <?php if (isset($vitalsign)){?>
  <blockquote>
  <p><?php echo $vitalsign;?></p>
  </blockquote>
  <?php }?>
 	<textarea id="MR" name="MR" style="display:none"></textarea>
  
 
  <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
			    <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>
      
      <!-- <div class="btn-group">
        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
      </div> -->
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>
      <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
    </div>

    <div id="editor"><?php
        if ($MR==='') {
            if (isset($temp)) echo $temp;
        }else{
            echo $MR;
        }
        #{
      #switch ($dpt) {
      #case '口腔科':
      #echo "面型：对称/不对称\n开唇露齿：   无\n口腔卫生状况：牙石 +++ 软垢 +++ 牙周袋深度（PD）  mm 探诊出血指数（BI） 3\n牙龈炎： 轻中重度 \n牙周炎 ：轻中重度\n覆牙合：深覆牙合\n覆盖：   深覆盖\n反牙合：  无\n龋齿情况：\n浅龋：\n中龋：\n深龋：\n牙髓炎：\n根尖炎：\n牙体缺损：\n楔狀缺损：\n残根：\n残冠：\n智齿：\n隐裂：\n劈裂：\n牙列不齐：\n牙齿松动：\n牙列缺损：\n牙列缺损：\n氟斑牙：\n四环素牙：\n乳牙滞留：\n 治疗计划：\n\t牙周治疗洁牙，刮治\n\t拔除 智齿  残根\n\t充填\n\t必要时根管治疗\n\t根管治疗+桩核冠修复\n\t修复缺失牙");
      #	break;
      #case '内科':
      #	echo nl2br("既往史:否认高血压，糖尿病史。否认结核、肝炎等传染病史。否认手术及重大外伤史。否认输血史。否认药物过敏史。\r\n个人史:生于       ，久居北京。吸烟：      支/天，    X年，戒除     年。饮酒：   两/天， X年。否认疫区旅行，否认接触放射性或其他有毒有害物质。\r\n家族史:父：健在，体健。母：健在，体健。兄弟姐妹及子女体健。\r\n体格检查:胸廓对称，无明显畸形。双侧呼吸运动对称，双肺呼吸音清，未闻及干湿啰音。心前区无隆起，未见明显心尖搏动，心界无明显扩大，心率     次/分，律齐，各瓣膜区未闻及明显病理性杂音。腹部无明显膨隆，腹软、无压痛、反跳痛，肝脾肋下未及，Murphy（-），肠鸣音可闻及，无明显亢进，双肾区无叩痛，四肢活动自如，膝反射正常，Babinski征未引出。");
      #	break;
      #case '外科':
      #	echo nl2br("甲状腺：\t正常\t甲状腺肿\t结节\t肿物\n淋巴结：\t正常 \t肿大 \t炎症\n乳腺：\t正常 \t肿物 \t炎症 \t溢液 \n外生殖器：\t正常 \t包茎 \t包皮过长 \t精索静脉曲张 \t肿物 \n肛门：\t正常 \t外痔 \t内痔 \t混合痔 \t肛瘘 \t肛裂。\n肛门指诊：正常\t直肠肿物\t指套有血迹\t前列腺增生\t前列腺结节\t拒查\n其他：\t体表肿物 \t下肢静脉曲张 \t脊柱侧弯\t腹部疝");
      #	break;
      #case '眼科':
      #	echo nl2br("裸眼视力:\tVOD  VOS\nBCVOD  BCVOS  非接触眼压：OD  OS  双眼结膜无明显充血，角膜请，前房中深，周边约1/2CT，虹膜纹理清，瞳孔圆，对光反射（+），晶体清，玻璃体清，视盘边清色可，C/D约 0.2，视网膜在位。");
      #	break;
      #case '妇科':
      #	echo nl2br("月经史:平素月经规律，/天，量，痛经 \n LMP:\n婚育史：\n避孕方法：\n是否服用激素类药物：\n外阴：\t已婚型     色素沉着：有  无     色素减退：有  无     赘生物：有  无     溃疡：有  无 \n\t尿道口：                          阴道口:\n阴道：\t阴道粘膜：粉红色  苍白  萎缩     阴道畸形：有  无     阴道壁囊肿：有  无\n\t分泌物：量        颜色        色泽        异味  \n宫颈：\t大小：             肥大:             柱状上皮外翻：轻度  中度  重度\n\t息肉：\n\t赘生物：\n子宫：\t位置：前位  中位  后位     \n\t大小：             活动度：             软硬度：             压痛：有  无\n双附件：\t增粗：有  无\n\t包块：有  无\n\t压痛：有  无\n三合诊：\t骶韧带增粗：有  无\n\t直肠子宫陷凹:\n\t直肠粘膜：                                        指套血染：有  无")	;
      #	break;
      #case '耳鼻喉科':
      #	echo nl2br("耳：\t耳廓：正常  异常\n\t外耳道：正常  异常\n\t鼓膜：正常  异常\n鼻：\t鼻腔：正常\n\t粘膜：  正常\n\t鼻中隔：正常\n咽：正常\t咽后壁：正常\n\t扁桃体：正常");
      #	break;
      #case '生命体征':
      #	echo nl2br("体温  ℃ \t脉搏 次/分\t血压 / mmHg\t体重  kg\t身高 cm");
      #	break;
      #default:
      #	break;
        #}
        ?>
</div>
	<br />
  <input type="submit" name="submit" class="btn btn-primary" value="保存完成" /> 
	<input type="button" id="re_temp" class="btn btn-default" value="重载模板" />
	<input type="submit" name="submit" class="btn btn-default" value="取消" /> 
</form>

<script type="text/javascript">
document.getElementById("editor").focus();
</script>


<script type="text/javascript"> 
function formSubmit(form){
    document.getElementById('MR').value = document.getElementById('editor').innerHTML;
    return true;
} 
</script> 
<script>
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      $('#voiceBtn').hide();
      // if ("onwebkitspeechchange"  in document.createElement("input")) {
      //   var editorOffset = $('#editor').offset();
      //   $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      // } else {
      //   $('#voiceBtn').hide();
      // }
    };
    initToolbarBootstrapBindings();  
    $('#editor').wysiwyg();
    window.prettyPrint && prettyPrint();
  });
</script>
<script type="text/javascript">
$(document).ready(function(){
                  $('#re_temp').click(function(){
                               $('#editor').html('<?php if (isset($temp))echo trim(str_replace("'", "\\'",$temp));?>');
                               });
                  });
</script>
</div>