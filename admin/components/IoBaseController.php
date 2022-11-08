<?php

class IoBaseController extends CController {

    /**类似工厂方法**/
    //列表搜索
    public function GetList($modelName='',$mapStr='id',$condition='1',$order_by='id',$order_rule='ASC'){
        $limit=getParam('limit','10');
        $offset=getParam('offset','0');
        $order_by=getParam('order',$order_by);
        $order_rule=getParam('order_rule',$order_rule);
        $key=getParam('keywords','');
        $key=(!$key)?' ':" and name like '%".$key."%' ";
        $tmp =$modelName::model()->findAll($condition.$key.' order by '.$order_by.' '.$order_rule.' limit '.$offset.','.$limit);

        $this->DataToWX($tmp,$mapStr,'获取列表信息成功',array('isHideLoadMore'=>count($tmp)==$limit?false:true),array());
    }

    //根据主键返回记录
    public function GetRecByPk($modelName,$id=''){
        $id=getParam('id',$id);
        return $modelName::model()->findAllByPk($id);
    }

    //返回记录详情
    public function GetDetailByPk($modelName,$s){
        $tmp = $this->GetRecByPk($modelName);
        $this->DataToWx($tmp,$s,'获取详情成功');
    }

    //删除记录
    public function DeleteByPk($modelName){
        $tmp = $this->GetRecByPk($modelName);
        if($tmp){
            $tmp[0]->delete();
            $this->JsonSuccess();
        }
        else{
            $this->JsonFail(array('不存在该ID，删除失败'));
        }
    }

    //更新记录
    public function UpdateByPk($modelName){
        $tmp=$this->GetRecByPk($modelName);
        if ($tmp){
            $this->saveData($modelName,$tmp[0]);
            $this->JsonSuccess(array('id'=>$tmp[0]->id,'msg'=>'绑定成功'));
        }
        else{
            $this->JsonFail(array('msg'=>'不存在该ID，修改失败'));
        }
    }

    //保存
    public function saveData($modelName,$tmp){

        $modelData = getParam($modelName);
        if(is_string($modelData)){
            $modelData=CJSON::decode($modelData);
        }
        $tmp->attributes = $modelData;
        $tmp->save();
//        $this->JsonSuccess(array('id'=>$tmp->id));
    }

    public function CreateOne($modelName){
        $this->saveData($modelName,new $modelName());
    }
    /**输出模块**/
    //输出JSON数据   第一个数组用于附加res.data 第二个数组附加res.data.data
    public function DataToWx($tmp,$s,$msg,$arr=array(),$arr2=array()){
        $data = toIoArray($tmp,$s,$arr2);
        $total=is_array($tmp)?count($tmp):1;
        $rs=array('data'=>$data,'total'=>$total,'code'=>'200','msg'=>$msg,'time' => time());
        $rs=array_merge($rs,$arr);
        echo CJSON::encode($rs);
    }

    //输出200状态
    public function JsonSuccess($data=array(),$ecode='200'){
        $rs = array('data'=>$data,'time'=>time(),'code'=>$ecode,'request'=>$_REQUEST);
        echo CJSON::encode($rs);
    }

    //输出500状态
    public function JsonFail($data=array()){
        $this->JsonSuccess($data,'500');
    }

    public function getApiField($modelName,$s){
        return $s;
//        return empty($s)?$modelName::model()->apiField():$s;
    }

    /**
     * 安全：模型方法补充字段
     * apiField()获取模型方法apiMapper自定义的映射，基于safeField替换
     * 不安全：API接口指定字段
     * 函数传参限制输出映射字段
     **/

    /**公共接口模块**/
    //获取所有记录
    public function actionGetAllList($s=''){
        $modelName=$this->model;
        $s = $this->getApiField($modelName,$s);
        $this->GetList($modelName,$s);
    }

    //获取所有符合条件记录
    public function actionGetAllListByCondition($condition='',$s=''){
        $modelName=$this->model;
        $s = $this->getApiField($modelName,$s);
        $this->GetList($modelName,$s,$condition);
    }


    //获取一条记录根据主键
    public function actionGetOneByPk($s='',$modelName){

        $s = $this->getApiField($modelName,$s);
        $this->GetDetailByPk($modelName,$s);
    }
    //新建一条记录
    public function actionCreateOne(){
        $this->createOne($this->model);
    }

    //修改一条记录
    public function actionUpdateOneByPk(){
        $this->UpdateByPk($this->model);
    }

    //删除一条记录
    public function actionDeleteOneByPk(){
        $this->DeleteByPk($this->model);
    }

}

