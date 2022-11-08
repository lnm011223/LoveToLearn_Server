<?php
class MerchantIntention extends BaseModel {
    public function tableName() {
        return '{{merchant_intention}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
      
        return array(
            array('merchant_name', 'required', 'message' => '{attribute} 不能为空'),
            array('merchant_nature', 'required', 'message' => '{attribute} 不能为空'),
            array('merchant_address', 'required', 'message' => '{attribute} 不能为空'),
            // array('营业期限', 'required', 'message' => '{attribute} 不能为空'),
            array('business_start_time', 'required', 'message' => '{attribute} 不能为空'),
            array('business_end_time', 'required', 'message' => '{attribute} 不能为空'),
            // array('business_license', 'required', 'message' => '{attribute} 不能为空'),
            
            array('contact_GF_account', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_name', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_email', 'required', 'message' => '{attribute} 不能为空'),
            array('id,merchant_name,merchant_nature,merchant_address,business_end_time,business_start_time,merchant_num,merchant_detail_address,business_license,contact_GF_account,contact_name,contact_phone,contact_email,intention_state','safe'),
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
             'id' => 'ID',
             'merchant_num'=>'单位管理账号',
             'merchant_name' => '申请单位',
             'merchant_nature' => '商家性质',
             'merchant_address' => '单位所在地',
             'merchant_detail_address'=> '详细地址',
             'business_start_time'=>'开始日期',
             'business_end_time'=>'截止日期',
             'business_license'=>'营业执照',
             'contact_GF_account'=>'GF账号',
             'contact_name' => '联系人',
             'contact_phone' => '联系人电话',
             'contact_email'=>'联系人邮箱',
             'intention_state' => '状态',

        
 ); 
 //         return array(
 //             'id' => 'ID',
 //                        'no' => '序號',
 //             'club_code' => '社區編碼',
 //            // 'financial_code' => '財務編碼',
 //             'club_name' => '名稱',
 //             'club_logo_pic' => '縮略圖',
 //             'apply_club_gfnick' => '法人',
 //             'apply_club_id_card' => '法人身份證號',
 //             'apply_club_phone' => '法人電話',
 //             'apply_club_email' => '法人郵箱',
        
 // );
}

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    

    public function getCode() {
        return $this->findAll('1=1');
    }

    //上传文件
    protected function afterFind() {
        parent::afterFind();
        $basepath = BasePath::model()->getPath(124);
        $this->business_license=getUploadPath().$this->business_license;   
        return true;
    }

    protected function beforeSave() {
       parent::beforeSave(); 
       $this->business_license=str_replace(getUploadPath(),'',$this->business_license);
       $this->business_start_time = date('Y-m-d H:i:s');
       $this->business_end_time = date('Y-m-d H:i:s');
       return true;
    }

}
