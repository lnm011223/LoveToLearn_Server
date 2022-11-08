<?php
class BaseLib  extends BaseModel {
    public $show_line='';
    public function tableName() {
        return '{{base_code}}';
    }
    /**  * 模型验证规则 */
    public function rules() {
        return array(    );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

  public function picInput($form,$model,$attributes,$pic='jpg',$inputer=1,$div="<div>") {
   return  $this->upload($form,$model,$attributes,$pic,$inputer,$div);     
  }
   
    public static function downList($datalist,$idname,$showname,$selectname,$pvalue='0') {
      $html='<select name="'.$selectname.'">';
      $html.='<option value="">请选择</option>';
      foreach($datalist as $v){
       $html.='<option value="'.$v[$idname].'"'.(($v[$idname]==$pvalue) ? ' selected >' :'>');
         $html.=$v[$showname].'</option>';
       }   
       return  $html.'</select>';
    }
   
 public static function emptyArray($n=10) {
        $rs=array();
        for($i=0;$i<$n;$i++) $rs[]='';
        return $rs;
    }

  public static function sameStr($str1,$n=10) {
        $rs='';$b1='';
        for($i=1;$i<=$n;$i++) {
          $rs.=$b1.$str1.$i;
          $b1=',';
        }
        return $rs; 
    }

  public function getDown($id,$title,$data,$key,$name){
    $value=Yii::app()->request->getParam($id);                
    $s1='<span>'.$title.'：</span>';
    $s1.='<select class="singleSelect" style="width: 130px;" name="'.$id.'">';
    $s1.='<option value="">请选择</option>';
    foreach($data as $v){
       $s2=$v->{$key};
       $s3=($s2==$value) ? ' selected' : '';
       $s1.='<option value="'.$s2.'" '.$s3.'>'.($v->{$name}).'</option>';
    }
    return $s1.'</select>';
  }

  public function tdWidth($n,$wdstr){
    $rs=$this->emptyArray($n);
    if(!empty($wdstr)){
        $data=explode(',',$wdstr);
        foreach($data as $v){
           $ds=explode(':',$v);
           $rs[$ds[0]]="style='text-align: center;width:".$ds[1].";'";
        }
    }
    return $rs;
  }

 public  function  getRandStr($length){
   //字符组合
   $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
   $len = strlen($str)-1;
   $randstr = '';
   for ($i=0;$i<$length;$i++) {
    $num=mt_rand(0,$len);
    $randstr .= $str[$num];
   }
   return $randstr;
 }


public  function listArray($stra) {
   $rs=array();
    foreach ($stra as $v){
      $rs[$v]=$v;
    }
    return $rs;
  }

public  function tableLine($msg) {
      $s1='<table><tr class="table-title">';
      $s1.='<td>'.$msg.'</td></tr><table>';
      return $s1;
  }

public  function fieldSet($form,$v,&$i,$rtmp) {
      $s1=$this->ln().'<fieldset>'.$this->ln();
      $s1.='<legend>'.$v->f_name.'</legend>'.$this->ln().'<div>'.$this->ln();
      $s1.='<table><tr class="table-title">'.$this->ln();
      $s1.='<td>'.$this->ln();
      //,array( 'left' => '居左' , 'right' => '居右' ));
       $stra=$v->f_items; 
       $i++;
       $s1.= $form->radioButtonList($rtmp, 'f_checka['.$i.']',$this->listArray($stra) , $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')).$this->ln();
        $s1.="</td>".$this->ln()."</tr>".$this->ln()."</table>".$this->ln();
        $s1.='</div>'.$this->ln();
        $s1.='</fieldset>'.$this->ln();
      return $s1;
   }

public  function tableSet($form,$tmp,$tname,$rtmp,&$i) {
      $ln=$this->ln();
      $s1=$ln.'<fieldset>'.$ln.'<legend>'.$tname.'</legend>'.$ln.'<div>';
      $s1.=$ln.'<table>';
      
      foreach ($tmp as $v){
      $s1.=$ln.'<tr class="table-title">';
      $s1.=$ln.'<td >'.$v->f_name.'<span class="required">*</span></td><td>';
      //,array( 'left' => '居左' , 'right' => '居右' ));
       $stra=$v->f_items;
      $i++;
     
       $s1.= $form->radioButtonList($rtmp, 'f_checkb['.$i.']',$this->listArray($stra) , $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')).$ln;
       $s0=$form->error($rtmp, $v->f_name, $htmlOptions = array());
       $s1.=$s0."</td>".$ln."</tr>".$ln;
       }
      $s1.=$ln.'</table></div>';
      $s1.=$ln.'</fieldset>';
      return $s1;
   }

 public  function ln() {
      return chr(13).chr(10);
   }

  //  当前界面：单位审核》基本信息》<span style="color:DodgerBlue">信息审核</span>
public function title($vt,$vt1='') {
  $vt1=(empty($vt1)) ? $vt :$vt1;
  $ds=Role::model()->optername();
  return '当前界面：'.$ds[0].'》'.$vt.'》<span style="color:DodgerBlue">'.$vt.$ds[1].'</span>';
}

//传入图片地址，id名（update用）
function show_pic($flie='',$id=''){
    $html='';
    $icon=BasePath::model()->fileIcon($flie);
    if($flie){
        $html=empty($id)?'<div style="max-width:80px; max-height:70px;overflow:hidden;">':
            '<div style="float: left; margin-right:10px" id="upload_pic_'.$id.'">';
        $html.= '<a href="'.$flie.'" target="_blank" title="点击查看">';
        $html.= (!empty($icon)) ? '<img src="'.$icon.'" style="max-height:30px; max-width:20px;">'
           : '<img src="'.$flie.'" style="max-height:80px; max-width:70px;">';
        $html.='</a></div>';
    }
    return $html;
}

public function uploadFile($model,$attribute,$pic='jpg',$inputer=1,$div="<div>") {
  $div1='';
  $rs="";
  $model->setUploadPath();
  if(!empty($div)){
   $div1='</div>';
  }
  if($inputer)
    $rs="<script>we.uploadpic('".get_class($model).'_'.$attribute."','".$pic."');</script>";
  return $div.$rs.$div1;
}

public function upload($form,$model,$attributes,$pic='jpg',$inputer=1,$div="<div>") {
  $ln=$this->ln();
  $d=explode(':',$attributes.':1:1');
  $fns=$d[0];
  //D(0)--D(4),s属性名，标签宽度，内容宽度，编辑去宽，和高度
  $s1='<td colspan="'.$d[1].'">'. $form->labelEx($model,$fns).'</td>';
  $s1.='<td colspan="'.$d[2].'">';
  $s1.=$form->hiddenField($model, $fns, array('class' => 'input-text fl')); 
  $s1.=$this->show_pic($model->{$fns},get_class($model).'_'.$fns);
  $s1.=$this->uploadFile($model,$fns,$pic,$inputer,$div);
  $s1.= $form->error($model,$fns, $htmlOptions = array());
  $s1.= '</td>';
  return $s1;
}

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function getTableLine($form,$m,$str,$tr="1",$rd='') {
   return  $this->trInput($form,$m,$str,$tr,$rd);     
}

public function trInput($form,$m,$str,$tr="1",$rd='',$aselect=array()) {
  $ln=$this->ln();
  $d1=explode(',',$str);
  $tr0=(!empty($this->show_line)) ? $this->show_line : '<tr style="text-align:center;">';
  $s1=($tr=="1") ? $tr0.$ln : "";
  foreach($d1 as $v1){
      if(!empty($v1)){
          $ds0=$this->checkInputType($v1);
          $v1=$ds0[0];$s2=$ds0[1];
          $sm=$ds0[2];//数据选择的模型
          if($s2=='text')
             $s1.=$this->tdInput($form,$m,$v1);
          if($s2=='pic')
             $s1.=$this->upload($form,$m,$v1);
          if($s2=='YN'||$s2=='yn')
             $s1.=$this->selectYn($form,$m,$v1);
          if($s2=='html')
             $s1.=$this->edit($form,$m,$v1);
          if($s2=='list'){
             $s1.=$this->tdList($form,$m,$v1,$sm);
          }
          if($s2=='action'){
             $td='<td>';
             if(indexof($sm,'/notd')>0){
               $sm=str_replace('/notd','',$sm);
               $s1=substr($s1,0, -5);
               $td='';
             }
             $d2=explode('/',$sm);//函数/提示 
             $s1.=$td.$this->getSearchCmd($d2[1],$v1,$d2[0]).'</td>';
          }
          if($s2=='check')
             $s1.=$this->edit($form,$m,$v1);
          if($s2=='date') $s1.=$this->tdInputDate($form,$m,$v1);
          if($s2=='radio')
             $s1.=$sm::model()->radioByData($form,$m,$v1,$data,$shownName,$onchange,$noneshow);
        }
    }
   return  $s1 .(($tr=="1") ? '</tr>' : "").$ln;     
}

//str=模型名称/下拉动作
public function selectAction($str,$ac='downSelect') {
  $d2=explode('/',$str.'/'.$ac);
  if(empty($d2[1])) $d2[1]=$ac;
  return  $d2;
}


//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function tdList($form,$m,$field,$maction) {
    $ds= $this->selectAction($maction);
    $model=$ds[0];$action=$ds[1];
    return $model::model()->{$action}($form,$m,$field);
}


//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function tdInput($form,$m,$str) {
    $ln=$this->ln();
    $s1='';
    if(!empty($str)){
      $ad=array('class'=>'input-text','style'=>'height:25px');
      $ds=explode(':',$str.":1:1");
      $td0='<td  style="padding:15px;" '.(($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"').' > ';
      $td1='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').' > '; 
      $s1=$form->labelEx($m,$ds[0]);
      $s1=$td0.$s1.'</td>'.$ln;
      $s1.=$td1.$form->textField($m,$ds[0],$ad);
      $s1.=$form->error($m,$ds[0], $htmlOptions = array()); 
      $s1.='</td>'.$ln;
   }
   return  $s1 ;     
}


//str=name:1:2,其中NAME为属性名，1表示跨表格，2是右边 
public function getAd($ad,$str) {
  $d2=explode(':',$str);
  foreach($d2 as $vs){
      $vsd=explode('=',$vs); 
      $ad[$vsd[0]]=$vsd[1];     
  }
  return  $ad;     
}

//str=name:1:2,其中NAME为属性名称，1表示属性跨表格数，2是输入框表格数
// $form 界面控件
// $M 数据模型
// $str 属性串表，用,分开
// $tr 表示生成行
public function show_td($form,$m,$str,$tr="1") {
   return $this->tableInput($form,$m,$str,$tr);
}

public function tableInput($form,$m,$str,$tr="1") {
  $d=explode(';',$str);$s1='';
  $this->show_line='';
  $vlise=0;
  $vlise1=0;
  $vlise2=0;
  
  foreach($d as $v){
    $b1='';$b2='';
    $n1=indexof($v,'<');$n2=indexof($v,'>');
    if($n1>=0){
       $vlise+=1;
       $vlise1=1;
       $v=str_replace('<','',$v);
    }
    if($n2>=0 ){
       $v=str_replace('>','',$v);
    }
    if( $vlise1==1){
      $vlise2+=1;
      $this->show_line='<tr id="block_'.$vlise.'_'.$vlise2.'" style="display:none">';
    }
    $s1.=$this->getTableLine($form,$m,$v,$tr);
    if($n2>=0 ){
       $this->show_line='';$vlise1=0; $vlise2=0;
    }
   }
   return  $s1;     
}

public function saveDataHtml(&$tmp){
   $ds=get_session('edit_name');
   $r=0;
   if(is_array($ds)){
       foreach($ds as $v){
        $s1='html_tmp'.$r;$r+=1;
        $tmp->{$v}= $tmp->{$s1};
      }
   }
}


public function getHtmlName($hname){
   $sn=get_session('html_edit');
   set_session('html_edit',$sn+1);
   return 'html_tmp'.$sn;
}

public function edit($form,$m,$str,$tr="1") {
  $ln=$this->ln();
  $dtr=$this->checkTr($str);
  if(indexOf($str,":")<0){
    $str.=":1:1";
  }
  $d=explode(':',$str.":300:50%");
  //D(0)--D(4),s属性名，标签宽度，内容宽度，编辑去宽，和高度
  $fildsname=$d[0];
  $s21=$fildsname;//."_temp";
  $s22=get_class($m);
  $s31=$s22."_".$s21;
  $s32=$s22."[".$s21."]";
  
  $s1=($dtr[0]==1) ? '<tr>' : '';

  $s1.='<td>'.$form->labelEx($m,$fildsname).'</td>'.$ln;
  $s1.='<td colspan="'.$d[2].'">'.$ln;
  $s1.=$form->hiddenField($m,$fildsname, array('class' => 'input-text')).$ln; 
  $s1.='<script>'.$ln;
  $s1.="we.editor('".$s31."','".$s32."','".$d[3]."','".$d[4]."');".$ln;
  $s1.='</script>'.$ln;
  $s1.=$form->error($m,$fildsname, $htmlOptions = array()).$ln; 
  $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
  return  $s1;     
}

public function checkTr(&$str) {
  $tr=(indexOf($str,"[")>=0) ? 1 : 0;
  $btr=(indexOf($str,"]")>=0) ? 1 : 0;
  $str=str_replace('[','',$str);
  $str=str_replace(']','',$str);
  return array($tr,$btr);     
}
public function checkKeyWord($str,$str1) {
   $s1=':'.strtolower($str1);
   $s2=strtolower($str);
   return (indexOf($s2,$s1)>=0) ? $str1 :'';     
}

public function checkInputType($str) {
  $r='';$r1='';
  $r=$this->checkKeyWord($str,'pic');
  if(empty($r)) $r=$this->checkKeyWord($str,'YN');
  if(empty($r)) $r=$this->checkKeyWord($str,'html');
  if(empty($r)) $r=$this->checkKeyWord($str,'radio');
  if(empty($r)) $r=$this->checkKeyWord($str,'date');
  if(empty($r)) $r=$this->checkKeyWord($str,'time');
  if(empty($r)) $r=$this->checkKeyWord($str,'check');
  if(empty($r)) $r=$this->checkKeyWord($str,'list');
  if(empty($r)) $r=$this->checkKeyWord($str,'action');
  if(empty($r)) $r='text';
  if(($r=='check')||($r=='list')||($r=='radio')||($r=='action')){
    $d1=explode('(',$str);
    $d2=explode(')',$d1[1]);
    $r1=$d2[0];
    $str=str_replace("(".$r1.")","",$str);
  }
  $str=str_replace(':'.$r,'',$str);
  $str=str_replace(':HTML','',$str);
  return array($str,$r,$r1);     
}


public function show_read($form,$m,$str,$tr="1") {
  $d=explode(';',$str);
  $s1='';
  foreach($d as $v){
    $s1.=$this->getTableLine($form,$m,$v,$tr,'1');
   }
   return  $s1;     
}

public function listByData($form,$m,$atts,$data,$sp,$onchange='',$noneshow='') {
   return  $this->selectFrom($form,$m,$atts,$data,$sp,$onchange,$noneshow);
}

public function selectFrom($form,$m,$atts,$data,$sp,$onchange='',$noneshow='') {
   $atts0.=':1:'.$sp;
   $shownName="f_name:f_name";
   return  $this->selectByData($form,$m,$atts0,$data,$shownName,$onchange,$noneshow);
}

public function selectInit($form,$m,$atts,$data,$shownName,$onchange,$noneshow,&$s1,&$s01,&$s02) {
   $dtr=$this->checkTr($atts);
   $ds=explode(':',$atts.":1:1");
   $atts=$ds[0];
   $ds1=explode(':',$shownName.":".$shownName);
   $ln=$this->ln();

   $s1=($dtr[0]==1) ?'<tr>' :'';
   if($ds[1]!=='0'){ //标识只显示一列
       $s1.='<td '.(($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"').'>'.$ln;
       if(!empty($noneshow)) $s1.='<span id="'.$atts.'_label" style="display: none">';
       $s1.= $form->labelEx($m,$atts);
       if(!empty($noneshow)) $s1.='<span class="required">*</span></span>';
       $s1.='</td>'.$ln;
    }
   if(!empty($noneshow)) $s1.='<span id="'.$atts.'_content" style="display: none">';
   $s1.='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').'>'.$ln;
   $s01=Chtml::listData($data, $ds1[0], $ds1[1]);
   $s02=array('prompt'=>'请选择','style'=>'width:95%;');
   if(!empty($onchange)){
     $s02['onchange'] =$onchange;
   } 
}

public function selectByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
   $s1='';$s01='';$s02='';
   $dtr=$this->checkTr($atts0);
   $ds=explode(':',$atts0.":1:1");
   $this->selectInit($form,$m,$atts0,$data,$shownName,$onchange,$noneshow,$s1,$s01,$s02);
   $ln=$this->ln();
   $s1.=Select2::activeDropDownList($m,$ds[0],$s01,$s02);
   $s1.=$ln.$form->error($m,$ds[0], $htmlOptions = array());
   if(!empty($noneshow)) $s1.='</span>';
   $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
   return $s1;
}
 
public function radioByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
   $s1='';$s01='';$s02='';
   $dtr=$this->checkTr($atts0);
   $ds=explode(':',$atts0.":1:1"); 
   $this->selectInit($form,$m,$atts0,$data,$shownName,$onchange,$noneshow,$s1,$s01,$s02);
   $ln=$this->ln();
   $s1.=$form->radioButtonList($m,$ds[0], $s01, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
   $s1.=$ln.$form->error($m,$ds[0], $htmlOptions = array());
   if(!empty($noneshow)) $s1.='</span>';
    $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
   return $s1;
}

public function checkByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
  $s1=$form->checkBoxList($model, 'tmp_opter2['.$ri.']['.$ri1.']',$tmenu, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>', 'onclick' => 'opterClickb()'));
  return $s1;
 }

public  function searchBy($title,$field,$datas,$id='id'){
    $ds=explode(":",$id.':'.$id);
    return $this->searchByData($title,$field,$datas,$ds[0],$ds[1]);
  }

  public  function searchByData($title,$field,$datas,$id='id',$name='name'){
    $s01=Yii::app()->request->getParam($field);
    $s01=(empty($s01)) ?'':$s01;
    $s1='<label style="margin-right:25px;">';
    $s1.='<span>'.$title.'：</span>';
    $s1.='<select name="'.$field.'" id="'.$field.'" >';
    $s1.='<option value="">请选择</option>';
    foreach($datas as $v2){
     $s2=$v2[$id];
     $s1.='<option value="'.$v2[$name].'"'.(($s01==$s2) ?' selected="selected"':'').'>';
     $s1.=$v2[$name].'</option>';
    }
    return $s1.'</select></label>';
  }

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function inputSearch($title,$keywords) {
    $ln=$this->ln();
    $s1='<label style="margin-right:10px;">'.$ln;;
    $s1.='<span>'.$title.'：</span>'.$ln;
    $s1.='<input style="width:100px;height=25px;" class="input-text" type="text" name="'.$keywords.'"';
    $s1.=' value="'.Yii::app()->request->getParam($keywords).'">'.$ln;
    $s1.=' </label>'.$ln;
   return  $s1 ;     
}

/*
  S利用字符串生产相关命令
  参数：search:查询;save:确认
     <button class="btn btn-blue" onclick="$('#oper').val('search');" type="submit">查询</button>
    <button class="btn btn-blue" onclick="$('#oper').val('save');" type="submit">确认</button>
 */
  public function getSubmit($str) {
      $d=explode(';',$str);
      $ln=$this->ln();$s1='';
      foreach($d as $v){
        $d1=explode(':',$v);
        $s1.='<button class="btn btn-blue" onclick="$('."'#oper').val('".$d1[0]."');".'"';
        $s1.=' type="submit">'.$d1[1].'</button>'.$ln;
      }
      return  $s1;     
    }
/* */
  public function creatCommand($thisp,$title,$command,$pic) {
      $s1=$this->ln(); 
      $s1.='<a class="btn" href="'.$thisp->createUrl($command).'">';
      $s1.='<i class="fa '.$pic.'"></i>'.$title.'</a>';
      return  $s1;     
    }
// 标题设置
  public function titleSet($thisp,$oper_name) {
      $ln=$this->ln(); 
      $s1=$ln.'<span class="back">';
      if(indexof($oper_name,'添加')>=0) 
         $s1.= $this->creatCommand($thisp,'添加','create',"fa-plus");
      if(indexof($oper_name,'刷新')>=0) 
         $s1.= $this->creatCommand($thisp,'刷新','index',"fa-refresh");
      $s21='';$s22='';
      if(indexof($oper_name,'批删除')>=0) $s21='批删除';
      if(indexof($oper_name,',删除')>=0) $s22='删除';
      $s1.=show_command($s21,'',$s22);  
      return  $s1.$ln.'</span>';     
  }

// 设置标题内容选择
  public function setRowCheck($id,$index=0) {
      $ln=$this->ln(); 
      $s1=$ln.'<td class="check check-item"><input class="input-check" type="checkbox" value="';
      $s1.=$ln.CHtml::encode($id);
      $s1.=$ln.'"></td>';
      $s1.=($index) ? '<td>'.$index.'</td>' :'';
      return  $s1;
  }

  //操作设置内容'编辑:update,删除,更多:workOrderProcess/index:icoclass';
  public function setDateOPter($thisp,$id,$opname='编辑,删除') {
      $ln=$this->ln(); 
      $s1= $ln.'<td>';
      $d=explode(',',$opname); 
      foreach($d as $v){
         $d1=explode(':',$v.':');
          if(indexof($v,'删除')>=0){
            $s1.=$ln.'<a class="btn" href="javascript:;" onclick="we.dele('."'".$id."'";
            $s1.=$ln.', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>';
          } else{
            $opico='edit';
            if(isset($d1[2])&&(!empty($d1[2]) )) $opico=$d1[2];
            $s1.=$ln.'<a class="btn" href="'.$thisp->createUrl($d1[1], array('id'=>$id));
            $s1.=$ln.'" title="'.$d1[0].'"><i class="fa fa-'.$opico.'"></i></a>';
          }
       }
      $s1.=$ln.'</td>';
      return  $s1.$this->setDeleteOP($thisp);     
    }

  //操作设置内容
  public function setDeleteOP($thisp) {
      $s1='';
      if(get_Session("setDelete")=='1'){
        $s1='<script> var deleteUrl ="'. $thisp->createUrl('delete', array('id'=>'ID')).'";</script>';
        set_Session("setDelete",'0');
       }
      return  $s1;     
    }


   function strToArray($str) {
    $r=array();
    $ds0=explode(';', $str);
    foreach($ds0 as $v0){
      $ds1=explode(',', $v0);
      $r1=array();
      foreach($ds1 as $v1){
       $ds2=explode(':', $v1);
       $r1[$ds2[0]]=$ds2[1];
      }
      $r[]=$r1;
    }
    return $r;
   }
    
  public function selectYn($form,$m,$atts,$onchange='',$noneshow=''){
     $data=$this->strToArray('f_id:1,f_name:是;f_id:0,f_name:否');
     return $this->radioByData($form,$m,$atts,$data,'f_id:f_name',$onchange,$noneshow);
    }

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function tdInputd($form,$m,$str) {
    $ln=$this->ln();
    $ad=array('class'=>'input-text click_time','style'=>'height:25px');
    $ds=explode(':',$str.":1:1");
    $td0='<td  style="padding:15px;" '.(($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"').' > ';
    $td1='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').' > '; 
    $s1=$form->labelEx($m,$ds[0]);
    $s1=$td0.$s1.'</td>'.$ln;
    $s1.=$td1.$form->textField($m,$ds[0],$ad);
    $s1.=$form->error($m,$ds[0], $htmlOptions = array()); 
    $s1.='</td>'.$ln;
   return  $s1 ;     
}

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function dateSearch($title,$keywords) {
    $ln=$this->ln();
    $v=Yii::app()->request->getParam($keywords);
    if(empty($v)) $v=date('Y-m-d');
    $s1='<label style="margin-right:10px;">'.$ln;;
    $s1.='<span>'.$title.'：</span>'.$ln;
    $s1.='<input style="width:120px;height=25px;" class="input-text click_time" type="text" ';
    $s1.=' id="'.$keywords.'" name="'.$keywords.'"';
    $s1.=' value="'.$v.'">'.$ln;
    $s1.=' </label>'.$ln;
   return  $s1 ;     
}

//日期输入下拉框，js
public function script_Date($str,$m1=''){
     $ln=$this->ln();
     $ds=explode(':',$str.":1:1");
     $m=(empty($m1)) ?'' : get_class($m1);
     $sn=(($m=='') ? '' : $m.'_').$ds[0];
     $s0=$ln.'<script>'.$ln;// name="ClubListGys[apply_name]" id="ClubListGys_apply_name"
       $s0.=" var $".$sn."=$('#".$sn."');".$ln;
       $s0.=" $".$sn.".on('click', function(){".$ln;
       $s0.=" WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});".$ln;
       $s0.=" });".$ln;
     $s0.="</script>".$ln;
     return $s0;
    }

public function tdInputDate($form,$m,$str){
     $s1=$this->tdInputd($form,$m,$str);
     $s1.=$this->script_Date($str,$m);
     return $s1;
  }

public function inputDate($title,$str){
     $s1=$this->dateSearch($title,$str);
     $s1.=$this->script_Date($str);
     return $s1;
    }
//查找输入框处理
public function boxSearch($str='关键字:keywords'){
     $ln=$this->ln();
     $this->submitCmd='';
     $str=str_replace(';',',@',$str);
     $ds=explode(';',$str.";");
     $str=$ds[0];
     $s1=$ln.'<form action="'.Yii::app()->request->url.'" method="get"><p>';
     $s1.=$ln.'<input type="hidden" name="r" value="'.Yii::app()->request->getParam('r').'">';
     $d=explode(',',$str);
   //  $s00='𣳽𣳽';
     //put_msg('lin='.$s00);
     foreach($d as $v){
         $pg='';
         if(indexof($v,'@')>=0){
           $pg="</p><p>";
           $v=str_replace('@','',$v);
         }
          $s1.=$pg.$this->getSearchInput($v);
       }
     $s1.=(empty($this->submitCmd)) ? $ln.'<button class="btn btn-blue" type="submit">查询</button>' : '';
     return  $s1.$ln.'</p></form>';
    }

public $submitCmd='';
public function getSearchCmd($title,$idname,$fn){
   $this->submitCmd='1';
   $s1=$this->ln().'<span style="display;"><a style="display;" id="'.$idname.'" class="btn" href="javascript:;"';
   $s1.=' onclick="'.$fn.'();">'.$title.'</a></span>';
    return $s1;
  }



/*
  echo Level::model()->downSearch('年级','levelname');
    echo Subject::model()->downSearch('课程','subject');
    echo BaseLib::model()->inputSearch('关键字','keywords');
    echo BaseYear::model()->downSearch('年份','examyear');
 */
    public function getSearchInput($str) {
      $d1=explode('=',$str);
      $m=$d1[0];//标题$v1=$d1[1];//属性和表输入一样
      $ds0=$this->checkInputType($d1[1]);
      $v1=$ds0[0];$s2=$ds0[1];$s1='';
      $sm=$ds0[2];//数据选择的模型
      if($s2=='text')
         $s1=$this->inputSearch($m,$v1);
      if($s2=='YN')
         $s1=$this->selectYn($m,$v1);
      if($s2=='list')
         $s1=$this->searchList($m,$v1,$sm);
      if($s2=='date')
         $s1=$this->inputDate($m,$v1);
       if($s2=='action')
         $s1=$this->getSearchCmd($m,$v1,$sm);
       return $this->ln().$s1 ;     
    }

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function searchList($m,$field,$maction) {
    $ds= $this->selectAction($maction,'downSearch');
    $model=$ds[0];$action=$ds[1];
    return $model::model()->{$action}($m,$field);
}


  //扩充 记录对象转换成数组
  public function recToArray($tmp,$afieldstr) {
    $arr=array();
    $afieldstmp=explode(',',$afieldstr);
    if($tmp) //$rec=$tmp->attributes;
    foreach($afieldstmp as $v1){
      $a=explode(':',$v1);
      $r=$a[0]; $s1='';
      $r0=$r; $v20=0;
       if(isset($a[2])) {
         $s1= $a[2];//默认值
         $v20=1;
       }
      if(isset($a[1])){
          $r=(empty($a[1]))  ? $r : $a[1];//有别名
      }
      if($v20==0){ 
         $s1= $tmp->{$r0};//表的值
       }      
      $arr[$r]=$s1;
    }
    return $arr;
  }

    //扩充 记录对象转换成数组
    function toArray($cooperation,$afieldstr,$def_array=array())
    {
        $arr=$def_array;
        if(is_array($cooperation))
          foreach ($cooperation as $v) {
              $arr[]=$this->recToArray($v,$afieldstr);       
          }
        return $arr;
    }

     /**输出模块**/
    //输出JSON数据   第一个数组用于附加res.data 第二个数组附加res.data.data
public function echoEncode($rs,$code='200',$msg='获取成功',$ecode='400',$emsg='获取失败'){
    $rs['code']=$code;
    $rs['msg']=$msg;
    $rs['time'] = time();
    echo CJSON::encode($rs);
  }

public function echoAjxCode($data,$dateItem=''){
     if (!empty($dateItem)) $data=array($dateItem=>$data,'total'=>count($data));
     $r=array('data'=>$data);
     $this->echoEncode($r);
  }


public  function noNameArray($cooperation,$afieldstr)
 {
    $arr = array();$r=0;
    $afields=explode(',',$afieldstr);
    $cn=count($afields);
    if($cn>1){
        $arr=$this->moreArray($cooperation, $afields);
    } else{
      $v1=$afields[0];
      foreach ($cooperation as $v) {
         $arr[] =$v[$v1];
      }  
    }
    return $arr;
  }

 public  function moreArray($cooperation, $afields)
 {
    $arr = array();$r=0;
    foreach ($cooperation as $v) {
      $arr0 = array();
         foreach($afields as $v1){
             $vs=$v[$v1];
             if(empty($vs)){
                $vs="";
             }
             $arr0[] = $vs;
        }
        $arr[]= $arr0;
    }
    return $arr;
  }
  
    //扩充 记录对象转换成数组
    //=$title=array('当前界面：系统》查询》','明细信息','添加,刷新,批删除')
    function indexTitle($thisp,$title) {
        $ln=$this->ln();
        $s2=$this->titleSet($thisp,$title[2]);
        $s1=$ln.'<div class="box-title c">';
        $s1.=$ln.'<h1>'.$title[0].'<a class="nav-a">'.$title[1].'</a></h1>';
        $s1.=$ln.$s2;
        $s1.=$ln.'</div><!--box-title end-->';
        return $s1;
    }

    //扩充 记录对象转换成数组
    function indexSearch($pscmd='') {
        $ln=$this->ln();
        $s1= $ln.'<div >';//class="box-search"
        $s1.=(!empty($pscmd)) ? $ln.$this->boxSearch($pscmd) :'';
        $s1.= $ln.'</div><!--box-search end-->';
        return $s1;
    }

    public function indexSearchContent($pscmd='') {
        $ln=$this->ln();
        echo '<div class="box-content">';
        $s1= $ln.'<div >';//class="box-search"
        $s1.=(!empty($pscmd)) ? $ln.$this->boxSearch($pscmd) :'';
        $s1.= $ln.'</div><!--box-search end-->';
        $s1=$ln.'<div class="box-table">';
        $s1.=$ln.'<table class="list">';
        echo $s1;
    }

 function indexGridHead($model,$pindex,$pfields,$pwidths){
        $ln=$this->ln();
        $s1=$ln.' <tr class="table-title">';
        $s1.=($pindex==0) ?'' : $ln.'<th style="text-align:center; width:25px;">序号</th>';
        $s1.=$ln.'<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>';
        $s1.=$ln.$model->gridHead($pfields,$pwidths);
        $s1.=$ln.'<th>操作</th>';
        return  $s1.$ln.'</tr>';
    }

   function indexGridRow($thisp,$v,$id,$index=0,$coumnName,$cmdstr){
        $ln=$this->ln(); 
        $s1=$ln.' <tr>'.$this->setRowCheck($id,$index);
        $s1.=$ln.$v->gridRow($coumnName);
        $s1.=$ln.$this->setDateOPter($thisp,$id,$cmdstr).'</tr>';
        return $s1;
    }
 
    function indexGridRows($thisp,$arclist,$index0,$idname,$coumnName,$cmdstr){
        $index = 0;
        $s1='';
        foreach($arclist as $v){ 
          $id=$v[$idname];$index+=$index0; 
          $s1.=$this->indexGridRow($thisp,$v,$id,$index,$coumnName,$cmdstr);
        }
        return $s1;
    }
/*
     $ht='positionCode,positionName,positionType,positionWidth,positionHeight,dataFlag';
           $hw='0:10%,1:25%,2:10%,3:10%,4:10%,5:10%,6:5%';//每列的宽度
           $index=0;//是否显示序号 0 不显示  1 显示
           $idName='positionId';//关键字的属性名称
           $cmd='编辑:update,删除';//操作的命令
          $gridset=array($index,$idName,$hfiels,$hw,$cmd);
           echo  BaseLib::model()->indexTable($this,$data,$arclist); 
*/
   // function indexTable($thisp,$model,$gridset,$arclist){
   //      $ln=$this->ln();
   //      $s1=$ln.'<div class="box-table">';
   //      $s1.=$ln.'<table class="list">';
   //      $s1.=$this->indexGridHead($model,$gridset[0],$gridset[2],$gridset[3]);
   //      $s1.=$this->indexGridRows($thisp,$arclist,$gridset[0],$gridset[1],$gridset[2],$gridset[4]);
   //      $s1.='</table>';    
   //      return $s1.$ln.'</div><!--box-table end-->';
   //  }
 
   function indexEchoHtml($thisp,$data,$pages,$title,$searchCmd){
        $ln=$this->ln();
        echo $this->indexTitle($thisp,$title);
        echo $ln.'<div class="box-content">';
        echo $this->indexSearch($thisp,$searchCmd);
        echo $this->indexTable($thisp,$data);
        $s1=$ln.'<div class="box-page c">'.$thisp->page($pages).'</div>';
        $s1=$ln.'</div><!--box-content end-->';
        echo $s1;
    }
 
    public function updateTitle($title='数据明显设置处理'){
        $ln=$this->ln();
        $st1='';//Munu::model()->getTitle();
        $s1=$ln.'   <h1><i class="fa fa-table">'.$st1.'</i><span style="color:DodgerBlue">'.$title.'</span></h1>';
        $s1.=$ln.'<span class="back"><a class="btn" href="javascript:;" onclick="we.back();">';
        $s1.=$ln.'<i class="fa fa-reply"></i>返回</a>';
        $s1.=$ln.'</span>';
        return $s1;
    }

    public function updateTitleBox($title){
        $ln=$this->ln();
        $s1=$ln.'<div class="box-title c">';
        $s1.=$ln.$this->updateTitle($title);
        return $s1.$ln.'</div>';
    }

    public  function tableInputBox($form,$model,$comstr){
        $ln=$this->ln();
        $s1=$ln.'<div class="box-detail-bd">';
        $s1.=$ln.'<div style="display:block;" class="box-detail-tab-item">';
        $s1.=$ln.'<table>';
        $s1.=$this->tableInput($form,$model,$comstr);
        $s1.='</table></div></div><!--box-detail-bd end-->';
        return $s1;
    }

  
    public function updateSave($comstr){
       $ln=$this->ln();
        $afields=explode(',',$comstr);
        $cmd=array();
        if(!empty($afields))
        foreach ($afields as $v1) {
           $v2=explode(':',$v1);
          if(count($v2)>=2) $cmd[$v2[1]]=$v2[0];
        }  
        $s1=show_shenhe_box($cmd);
        $s1.=$ln.'<button class="btn" type="button" onclick="we.back();">取消</button>';
        return  $s1;
    }
   
   public function updateSaveBox($comstr){
        $ln=$this->ln();
        $s1=$ln.'<div class="box-detail-submit">';
        $s1.=$ln.$this->updateSave($comstr);
        return $s1.$ln.'</div>';
    }
 

 //设置格式多列的样式 1:3=$inputCmd)
  public function checkColspan($inputCmd){
     $ds=explode('=',$inputCmd);
     if(count($ds)>1){
           $s2=$ds[1];
            $s2=str_replace(",",";+",$s2);
            $ds1=explode(';',$s2);
            $s2=':'.$ds[0];
            $s1='';
            foreach ($ds1 as $v1) {
              if(!empty($v1)){
                  $d2=explode(':',$v1);
                  $s1.=';'.$v1.((count($d2)>2) ? '' : $s2);
               }
            }
            $s2=substr($s1,1);//删除前面的';'
            $inputCmd=str_replace(";+",",",$s2);
        }
        return $inputCmd;
    }
 

  public function updateBox( $thisv,$model,$inputCmd,$title,$comstr){
      $ln=$this->ln();
      $inputCmd=$this->checkColspan($inputCmd);
      $s1=$ln.'<div class="box">';
      $s1.=$this->updateTitleBox($title);
      echo $s1.$ln.'<div class="box-detail">';
      $form = $thisv->beginWidget('CActiveForm', get_form_list());
      echo $this->tableInputBox($form,$model,$inputCmd);
      echo $this->updateSaveBox($comstr);
      $thisv->endWidget();
      echo $ln.'</div><!--box-detail end--></div><!--box end-->';
  }

    /*
        $coumnName='positionCode,positionName,positionType,positionWidth,positionHeight,dataFlag:YN';
        $hw='0:15%,1:25%,2:10%,3:10%,4:10%,5:10%,6:5%';//每列的宽度
        $index=0;//是否显示序号 0 不显示  1 显示
        $idName='positionId';//关键字的属性名称
        $cmd='编辑:update,删除';//操作的命令
        $data=array($index,$idName,$coumnName,$hw,$cmd);
    */
    public function showTableData($thisv,$model,$seachcomstr,$data,$arclist,$pages){
        $ln=$this->ln();
        echo '<div class="box-content">';
        if(!empty($seachcomstr)){
            echo $this->indexSearch($seachcomstr); 
        }
        echo  $this->indexTable($thisv,$model,$data,$arclist); 
        echo '</div><div class="box-page c">';
        $thisv->page($pages);
        echo '</div>';
    }

    public function indexShow($thisv,$model,$title,$seachcomstr,$data,$arclist,$pages){
        $ln=$this->ln();
        echo $this->indexTitle($thisv,$title);
        echo '<div class="box-content">';
        echo $this->indexSearch($seachcomstr);   
        echo  $this->indexTable($thisv,$model,$data,$arclist); 
        echo '<div class="box-page c">';
        $thisv->page($pages);
        echo '</div>';
    }

    function indexTable($thisp,$model,$gridset,$arclist){//1,2,5,6
        $ln=$this->ln();
        $s1=$ln.'<div class="box-table">';
        $s1.=$ln.'<table class="list">';
        $s1.=$this->indexGridHead($model,$gridset[0],$gridset[2],$gridset[3]);
        $s1.=$this->indexGridRows($thisp,$arclist,$gridset[0],$gridset[1],$gridset[2],$gridset[4]);
        $s1.='</table>';    
        return $s1.$ln.'</div><!--box-table end-->';
    }

    public function updateTitleContent($thisp,$title,$backn=0) {
    $ln=$this->ln();
    $c1=(strlen($title[2])<=40) ? 'class="box-title c"' :'';
    $s1=$ln.'<div '.$c1.'>';//class="box-title c"
    $s1.=$ln.'<h1>'.$title[0].'<a class="nav-a">'.$title[1].'</a></h1>';
    $s1.=$ln.$this->titleSet($thisp,$title[2]);
    if($backn) $s1.=$this->backPage();
    echo $s1.$ln.'</div><!--box-title end-->';
  }


  public function updateTableContent($thisv,$model,$inputCmds){
    $ln=$this->ln();
    echo $this->tableInputBox($form,$model,$inputCmd);
    echo '<div class="box-content">';
  }

  public function updateBottom($thisv,$model,$comstr=''){
    $ln=$this->ln();
    if(!empty($comstr)){
      echo $this->updateSaveBox($comstr);
    }
    $thisv->endWidget();
    echo $ln.'</div><!--box-detail end-->';
    echo $ln.'</div><!--box end-->';
  }


}  //end class
