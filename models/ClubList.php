<?php
class ClubList extends BaseModel {
	public $club_list_pic='';
    public function tableName() {
        return '{{club_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
      
        return array(
            array('club_code', 'required', 'message' => '{attribute} 不能为空'),
            array('club_name', 'required', 'message' => '{attribute} 不能为空'),
			//array('apply_time', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
			//array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
     
			array('club_code,club_name,dispay_xh,club_list_pic','safe',), 
			//array($s1,'safe'),
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
             'no' => '序号',
			 'club_code' => '社区编码',
			// 'financial_code' => '财务编码',
			 'club_name' => '名称',
			 'club_logo_pic' => '缩略图',
			 'apply_club_gfnick' => '法人',
			 'apply_club_id_card' => '法人身份证号',
			 'apply_club_phone' => '法人电话',
			 'apply_club_email' => '法人邮箱',
		
 ); 
         return array(
             'id' => 'ID',
                        'no' => '序號',
             'club_code' => '社區編碼',
            // 'financial_code' => '財務編碼',
             'club_name' => '名稱',
             'club_logo_pic' => '縮略圖',
             'apply_club_gfnick' => '法人',
             'apply_club_id_card' => '法人身份證號',
             'apply_club_phone' => '法人電話',
             'apply_club_email' => '法人郵箱',
        
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
