<?php

class BasePath extends BaseModel {

    public function tableName() {
        return '{{base_path}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                //array('', 'safe'),
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
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

    public function getPath($f_id) {
    return  'http://localhost/hsyii/uploads/temp/';
  //    return $this->find('f_id=' . $f_id);
    }

}
