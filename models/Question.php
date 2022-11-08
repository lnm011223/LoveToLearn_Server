<?php

use yii\validatoers;

class Question extends BaseModel {

    public function tableName() {
        return '{{question_bank}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
      
        return array(
            array('class', 'required', 'message' => '{attribute} 不能为空'),
            array('book_name', 'required', 'message' => '{attribute} 不能为空'),
            array('question_type', 'required', 'message' => '{attribute} 不能为空'),
            array('question', 'required', 'message' => '{attribute} 不能为空'),
			array(  'id,class,classNum,book_name,author,section,test_type,question_type,question_id,question,question_img,select1,select2,selcet3,select4,select5,ans,has_image,input_area','safe'), 
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
			  'id' =>  'id',
              'class' =>  '年级',
              'classNum' => '年级编码',
              'book_name' =>  '书名',
              'author' =>  '作者',
              'section' =>  '章节（单元）',
              'test_type' =>  '测试类型',
              'question_type' =>  '题目类型',
              'question_id' =>  '问题序号',
              'question'=>  '题目',
              'question_img' => '题目图片',
              'select1' =>  '选项A',
              'select2'=>  '选项B',
              'select3'=>  '选项C',
              'select4' =>  '选项D',
              'select5'=>  '选项E',
              'ans' =>  '答案',
              'has_image' => '是否含有图片(0:没有,1:题目有,2:选择有,3:两者都有)',
              'input_area' => '填空数量',
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
