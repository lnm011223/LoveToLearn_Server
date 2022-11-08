<?php
class Course extends BaseModel {

    public function tableName() {
        return '{{Course}}';//考试科目设置
    }

 /**
     * 属性标签
     */
    public function attributeLabels() {
     
        return array(
        'id' => 'ID',
        'code' =>'编码',
        'value'  => '名称',
        'subjectsetting' => '课程设置'

 );
}
    /**
     * 模型验证规则
     */
    public function rules() {
      
        return array(
            array('code', 'required', 'message' => '{attribute} 不能为空'),
            array('value', 'required', 'message' => '{attribute} 不能为空'),
			array('code,value','safe',), 
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
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	

  
}
