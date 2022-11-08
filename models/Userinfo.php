<?php

class Userinfo extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{userinfo}}';
    }

    public $excelPath="";
    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array($this->safeField(),'safe'),

//            array($this->safeField(),'safe'),
//            array($this->WxField(),'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(

        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'openid'=>'微信openid',
            'unionid'=>'用户微信unionid',
            'header'=>'照片',
            'name'=>'名称',
            'education'=>'在读学历',
            'nikename'=>'名称',
            'status'=>'状态',
            'phone'=>'手机号',
            'schoolname'=>'学校名称',
            'grade'=>'年级',
            'country'=>'国家',
            'province'=>'省',
            'city'=>'市',
            'district'=>'区',
            'sex'=>'性别',
            'sexid'=>'性别',
            'registerdate'=>'注册时间',
            'idnum'=>'身份证号码',
            'parents'=>'监护人',
            'p_phone'=>'监护人手机号码',
            'class'=>'班级',
            'pass_word'=>'密码',
            'aller'=>'过敏等信息',
            'update_userid'=>'上传人id',
            'update_username'=>'上传人姓名',
            'update_unitid'=>'上传人机构id',
            'update_unitname'=>'上传人机构名字',
            'birthday'=>'出生日期',
            'schoolid'=>'学校id',
            'find_id'=>'可逆加密身份证号码',
            'idnum_display'=>'身份证号',
        );
    }
    public function WxMap() {
        return array(
            'openid'=>'openid',
            'unionid'=>'unionid',
            'header'=>'avatar',
            'name'=>'stu_name',
            'education'=>'education',
            'nikename'=>'nikename',
            'status'=>'status',
            'phone'=>'phone',
            'schoolname'=>'schoolname',
            'grade'=>'grade',
            'country'=>'country',
            'province'=>'province',
            'city'=>'city',
            'gender'=>'gender',
            'registerdate'=>'register_date',
            'idnum'=>'id_num',
            'parents'=>'parents',
            'p_phone'=>'parent_phone',
            'class'=>'class',
            'aller'=>'aller',
            'birthday'=>'birthday',
            'schoolid'=>'schoolid',
            'find_id'=>'find_id',
           'idnum_display'=>'idnum_display',
           // 'salt'=>'盐',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        if($this->isNewRecord)
        {
            if(isset($_SESSION['adminid'])){    //自动保存上传人身份
                $this->update_userid=$_SESSION['adminid'];
                $this->update_username=$_SESSION['name'];
                $this->update_unitid=$_SESSION['TUNIT_id'];
                $this->update_unitname=$_SESSION['TUNIT'];
            }
            $time=date("Y-m-d");
            $this->registerdate=$time;
//            $salt =  rand(1000,666666); //加盐
//            $this->salt = $salt;
            $this->find_id = AES_encrypt($this->idnum);
            $this->idnum_display = substr($this->idnum,0,2).'**************'.substr($this->idnum,16,2);
            $this->idnum = md5(md5($this->idnum).'s1c2n3u4csyyds');  //MD5不可逆
            $this->find_p_id = AES_encrypt($this->p_idnum);
            $this->p_idnum = md5(md5($this->p_idnum).'s1c2n3u4csyyds');  //MD5不可逆
        }
        $school=$this->schoolname;
        $class=$this->class;
        $grade=$this->grade;
        $criteria = new CDbCriteria;
        $criteria->condition=get_where('1=1',$school,'school',$school,'"');
        $criteria->condition=get_where($criteria->condition,$class,'class',$class,'"');
        $criteria->condition=get_where($criteria->condition,$grade,'grade',$grade,'"');
        $tmp=BaseClass::model()->find($criteria);
        if(empty($tmp))
        {
            $tmp = new BaseClass();
            $tmp->school = $school;
            $tmp->grade = $grade;
            $tmp->class = $class;
            $tmp->province=$this->province;
            $tmp->city=$this->city;
            $tmp->district=$this->district;
            $tmp->save();
        }
        return true;
    }

    public function picLabels() {
        return 'header';
    }

    public function WxField($s='') {
        $dm=$this->WxMap();
        $s1='';$b1='';
        foreach($dm as $k=>$v)
        {
            $s1.=$b1.$k.":".$v;
            $b1=',';
        }
        return $s1;
    }

    public function getParentCondition()
    {
        $ids=trim(implode(',',explode('|',$this->p_id_set)),','); //用   |  来分割字符串 
        //trim函数 把 , 从字符串中移除
        //put_msg($ids);
        $w = 'id in (' . $ids . ')';
        //put_msg($w);
        if (!$ids) $w = '0';
        return $w;
    }

    public function getParent(){
        $w = $this->getParentCondition();
        $tmp = UserParent::model()->findAll($w);
        return $tmp;  //找到监护人

    }

    protected function afterFind()
    {
        return parent::afterFind();
    }


    public function getParentInfo(){
        $p = $this->getParent();
        $res='';
        if($p){
            foreach($p as $v){
                $res .= ",".$v->name.'('.$v->phone.')';
            }
            // put_msg($res);
            $res = trim($res,',');
        }
        return $res;
    }
}
