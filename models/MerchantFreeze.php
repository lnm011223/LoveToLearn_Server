<?php
class MerchantFreeze extends BaseModel {
    public function tableName() {
        return '{{merchant_freeze}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
      
        return array(
            
            array('id,merchant_num,merchant_freeze_treatment,
             merchant_freeze_reason,
             merchant_freeze_date,
             merchant_freeze_remain_time,
             merchant_freeze_state,
             merchant_freeze_apply_time','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
         'merchant_intention'=>array(self::HAS_ONE,'merchant_intention','','on'=>'t.merchant_num=merchant_num'),  
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
             'merchant_freeze_treatment' => '冻结处理',
             'merchant_freeze_reason' => '冻结原因',
             'merchant_freeze_date' => '冻结时间',
             'merchant_freeze_remain_time' => '冻结剩余时间',
             'merchant_freeze_state' => '冻结状态',
             'merchant_freeze_apply_time' => '冻结申请时间',
 ); 
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

}
