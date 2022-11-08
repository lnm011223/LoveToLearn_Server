<?php

class WxUserController extends IoBaseController
{
    public $model;
    public $s;


    public function init()
    {
        $this->model = 'Userinfo';
        // $this->s = Userinfo::model()->WxField();
        parent::init();
    }

    //获取个人信息接口
    //登录接口
    //http://localhost/sanli/index.php?r=WxUser/GetUserInfo&
    //传参：openid
    //获得参数：所有个人信息
    public function actionGetUserInfo(){
        $data_code = getParam('data');
        $key_code = getParam('key');
        $key = RSA_decrypt($key_code);

        $data = base64_decode(AES_decrypt(base64_decode($data_code),$key));
        //put_msg("25 ".$data);
        $data = CJSON::decode($data);
        $username=$data['name'];
        $phone=$data['phone'];
        $idnum=$data['idNum'];
        $id_flag=$data['id_flag'];
        $idnum = md5(md5($idnum).'s1c2n3u4csyyds');  //MD5不可逆

        //put_msg("33".$data);
        $criteria = new CDbCriteria();
        $criteria ->condition=get_where('1=1',$phone,'phone',$phone,'"');
        $criteria ->condition=get_where($criteria ->condition,$username,'name',$username,'"');
        $criteria ->condition=get_where($criteria ->condition,$idnum,'idnum',$idnum,'"');
        //判断角色
        if($id_flag=='student'){
            $tmp=Userinfo::model()->find($criteria);
            $flag="学生";
        }
        else if($id_flag=='teacher'){
            $tmp=Teacher::model()->find($criteria);
            $flag="老师";
        }
        else{
            $tmp=UserParent::model()->find($criteria);
            $flag="家长";
        }
        if(empty($tmp)) {
            $this->JsonFail(array('该用户未注册'));
        }
        else{
            switch ($flag) {
                case "学生":
                    $s1 = 'id,openid,unionid,header,name,birthday,education,nikename,phone,schoolname,grade';
                    $s1 .= ',province,city,district,sex,sexid,registerdate,idnum,parents,p_phone,class,aller';
                    break;
                case "老师":
                    $s1 = 'id,openid,unionid,header,name,salary,phone,sexid,sex,birthday,province,city,district,';
                    $s1 .= 'idnum,type,resume,grade,class,school';
                    break;
                case "家长":
                    $s1 = 'id,openid,unionid,header,name,nikename,phone,sex_id,sex,province,city,district,idnum,kids';
                    $tmpArray = explode('|', trim($tmp->k_id_set, '|'));
                    break;
            }
            $da1 = BaseLib::model()->oneToArray($tmp, $s1);
            if ($da1) {
                if (isset($tmpArray))
                    Basefun::model()->echoEncode(array('data' => $da1, 'kids_id' => $tmpArray, 'role' => $flag));
                else {
                    Basefun::model()->echoEncode(array('data' => $da1, 'role' => $flag));
                }
            }
        }
    }
    public function actionGetUserInfo2()
    {
        $openid = getParam('openid');
        $id_flag=getParam("id_flag");
        $criteria = new CDbCriteria();
        $criteria->condition = get_where('1=1', $openid, 'openid', $openid, '"');
        //判断角色
        if($id_flag=='student'){
            $tmp=Userinfo::model()->find($criteria);
            $flag="学生";
        }
        else if($id_flag=='teacher'){
            $tmp=Teacher::model()->find($criteria);
            $flag="老师";
        }
        else{
            $tmp=UserParent::model()->find($criteria);
            $flag="家长";
        }   if(empty($tmp)){
        $this->JsonFail(array('该用户未注册'));
    }
    else{
        switch ($flag)
        {
            case "学生":
                $s1='id,openid,unionid,header,name,birthday,education,nikename,phone,schoolname,grade';
                $s1.=',province,city,district,sex,sexid,registerdate,idnum,parents,p_phone,class,aller';
                break;
            case "老师":
                $s1='id,openid,unionid,header,name,salary,phone,sexid,sex,birthday,province,city,district,';
                $s1 .='idnum,type,resume,grade,class,school';
                break;
            case "家长":
                $s1='id,openid,unionid,header,name,nikename,phone,sex_id,sex,province,city,district,idnum,kids';
                $tmpArray = explode('|',trim($tmp->k_id_set,'|'));
                break;
        }
        $da1 = BaseLib::model()->oneToArray($tmp,$s1);
        if($da1)
        {
            if(isset($tmpArray))
                Basefun::model()->echoEncode(array('data'=>$da1,'kids_id'=>$tmpArray,'role'=>$flag));
            else
            {
                Basefun::model()->echoEncode(array('data'=>$da1,'role'=>$flag));
            }
        }
    }
    }
    //注册接口
    public function actionRegister($modelName='Userinfo'){
        $data_code = getParam('data');
        $key_code = getParam('key');
        //put_msg($data_code);
        $key = RSA_decrypt($key_code);
        //put_msg($key);
        $userInfo = base64_decode(AES_decrypt(base64_decode($data_code),$key));
        $modelData = CJSON::decode($userInfo);
        //put_msg("138 ".AES_decrypt($data_code,$key));
        $tmp1=new $modelName();
//        if(is_string($userInfo)){
//            $modelData=CJSON::decode($userInfo);
//        }
        $tmp1->attributes = $modelData;
        $phone = $tmp1['phone'];
        $openid=$tmp1['openid'];
        //$tmp1 = $modelName::model()->find("openid='".$openid."'");
        $tmp = $modelName::model()->find("phone='".$phone."'");
        /*if($tmp1){
            $this->JsonFail(array('msg'=>'该微信已注册'));
        }
        else */if($tmp){
            $this->JsonFail(array('msg'=>'该手机号已注册'));
        }else{
            //put_msg(154);
            $tmp=new $modelName;
            $tmp->attributes = $modelData;
            $tmp->save();
            $this->JsonSuccess(array('msg'=>'注册成功'));
        }
    }

    //添加注册信息
    public function actionCreateRegister($modelName){
        $this->CreateOne($modelName);
    }
    //内部注册id和学生wxid绑定接口
    //http://localhost/sanli/index.php?r=WxUser/IdBindWxid
    //传参：openid unionid name phone idnum
    //获得参数：所有个人信息
    public function actionIdBindWxid($openid){
        $para=getParameter('name:-1,phone:-1,idnum:-1');
        $criteria = new CDbCriteria();
        $criteria ->condition=get_where('1=1',$para['name'],'name',$para['name'],'"');
        $criteria ->condition=get_where($criteria ->condition,$para['phone'],'phone',$para['phone'],'"');
        $criteria ->condition=get_where($criteria ->condition,$para['idnum'],'idnum',$para['idnum'],'"');
        $tmp = Userinfo::model()->find($criteria);
        if(empty($tmp))
        {
            $this->JsonFail(array('该用户未注册'));
        }
        else
        {
            $tmp->openid = $openid;
            $tmp->save();
        }

    }
    // 获取年级的题库列表
    //key没有用到，data传入的是年级
    public function actionGetQuestionList($key="",$data=""){
        $model = Question::model();
        $grade = "";
        switch($data){
            case "1":{
                $grade = "一年级";
                break;
            }
            case "2":{
                $grade = "二年级";
                break;
            }
            case "3":{
                $grade = "三年级";
                break;
            }
            case "4":{
                $grade = "四年级";
                break;
            }
            case "5":{
                $grade = "五年级";
                break;
            }
            case "6":{
                $grade = "六年级";
                break;
            }
        }
        $s="book_name,author,section,test_type,question_type";
        $criteria = new CDbCriteria;
        $criteria->condition=get_where("1=1",$grade,'class',$grade,'"');
        $criteria->order='id desc';
        $criteria->distinct=true;
        $da1=$model->recToArray($criteria,$s);
        $rs=array('data'=>$da1,'total'=>count($da1));
        Basefun::model()->echoEncode($rs);
    }
    //获取题目详情
    //作者，书名，问题类型，章节，测试类型
    public function actionGetQuestionDetail($author='',$book_name='',$question_type='',$section='',$test_type=''){
        $data=array();
        $model = Question::model();
        //目前仅仅根据书名来进行查找
        $question = $model->findAll("book_name = '".$book_name."'");
        // put_msg("235".CJSON::encode($question));
        $num = count($question)>5?5:count($question);
        shuffle($question);//打乱顺序
        for($i=0;$i<$num;$i++){
            $temp=array();
            put_msg("241".$question[$i]['question_type']);
            if($question[$i]['question_type'] == "多选题")//多选题处理
            {
                $c_index = 'A';
                $ans_str = $question[$i]['ans'];
                for($j=0;$j<5;$j++)
                {
                    $select_val = $question[$i]['select'.($j+1)];
                    if($select_val=="")
                        break;
                    $cur_index = chr(ord($c_index)+$j);
                    $temp[$j] = array($cur_index => $select_val);
                    if(strstr($ans_str, $cur_index))
                        $temp[$j] += array('isAns' => 1);
                    else
                        $temp[$j] += array('isAns' => 0);
                }

                // print_r($temp);              
                // shuffle($temp);
                $cur_ans = "";
                for($j=0;$j<count($temp);$j++)
                {
                    if($temp[$j]['isAns'])
                        $cur_ans = $cur_ans.chr(ord($c_index)+$j);
                }
                // print($ans_str);
                // print($cur_ans);

                // print_r($temp);
                $question[$i]["ans"] = $cur_ans;
            }
            $temp[0]=$question[$i]['select1'];
            $temp[1]=$question[$i]['select2'];
            $temp[2]=$question[$i]['select3'];
            $temp[3]=$question[$i]['select4'];
            $temp[4]=$question[$i]['select5'];
            $temp = array_diff($temp, [""]); //去除空白选项
            $data[$i]=$question[$i];
            // TODO 删除多余的select
            $data[$i]['select1']=$temp;
        }
        echo CJSON::encode($data);
    }
    // 新增用户信息
    public function actionCreateUserInfo($modelName){
        $this->CreateOne($modelName);
    }

    // 更新用户信息
    public function actionUpdateUserInfo($modelName){
        $this->UpdateByPk($modelName);
    }


    // //测试用接口
    // public function actionTest($tid = 1){
    //     $teacher = Teacher::model()->find("id = ".$tid);
    //     $school = $teacher->school;
    //     $class = $teacher->class;
    //     $grade = $teacher->grade;

    //     $s1 = 'userid,username,sex,school,grade,class,status';
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = get_where('1=1',$cid,'courseid',$cid,'"');
    //     $criteria->condition = get_where($criteria->condition,$school,'school',$school,'"');
    //     $criteria->condition = get_where($criteria->condition,$grade,'grade',$grade,'"');
    //     $criteria->condition = get_where($criteria->condition,$class,'class',$class,'"');
    //     $criteria->condition .= 'AND id not in (select userid from registration where courseid='.$cid.')';
    //     $sign = Userinfo::model()->recToArray($criteria, $s1);

    //     $rs = array('success'=>$sign);
    //     Basefun::model()->echoEncode($rs);
    // }
    //获取openid
    public function actiongetOpenId(){
        $json=$_REQUEST; //小程序请求
        $appid = Basefun::model()->get_appid();  //appId
        $secret = Basefun::model()->get_secret(); //appSecret 验证你是服务器
        $code = $json["code"];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $json_obj = json_decode($res, true);

        put_msg($json_obj);

        //生成并返回token
        Yii::$enableIncludePath = false;
        // Yii::import('application.extensions.JWT', 1);
        $payload=array(
            'openid'=>$json_obj["openid"],
            'session_key'=>$json_obj["session_key"]);
        echo CJSON::encode($payload);
    }
    //微信登录
    public function actionWxLogin() //获取openid，自定义登录态
    {
        $data=array();
        $json=$_REQUEST; //小程序请求
        $appid = Basefun::model()->get_appid();  //appId
        $secret = Basefun::model()->get_secret(); //appSecret 验证你是服务器
        $code = $json["code"];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $json_obj = json_decode($res, true);
        //生成并返回token
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.JWT', 1);
        $payload=array(
            'openid'=>$json_obj["openid"],
            'session_key'=>$json_obj["session_key"]);
        $jwt=new Jwt;
        $token=$jwt->getToken($payload);  //加密,形成token
        $w1="openid='".$json_obj["openid"]."'";  //
        //返回token用于用户识别
        $data['user']=Userinfo::model()->get_userinfo($w1);//用户基本信息名称之类
        $userid=$data['user']['id'];
        $rs=array('id'=>$userid,'data'=>$data,'code'=>'200','msg'=>'调用登录成功',);
        $rs['token'] =$token;//token
        echo CJSON::encode($rs);
    }


//upload UpImg 保存用户上传头像
    public function actionSaveImg() {
        //put_msg("396 上传");
        $data = array();
        $file1=$_FILES['file'];
        $newName=$_POST['newName'];//更改图片名字
        $id=$_POST['id'];
        $modelName=$_POST['modelName'];
        $file_type=$_POST['file_type'];
        if(empty($file1)||$file1['error']==4) ajax_exit(array('status' => 0, 'msg' => '上传失败，稍后再试'));
        if($file1['error']==5) ajax_exit(array('status' => 0, 'msg' => '上传失败，上传文件大小为0'));
        if($file1['error']==1) ajax_exit(array('status' => 0, 'msg' => '上传文件大小超出范围'));
        //修改php.ini中的upload_max_filesize来增大范围
        $attach = CUploadedFile::getInstanceByName('file');
        $savepath = ROOT_PATH . '/uploads/temp/image/';
        $sitepath = SITE_PATH . '/uploads/temp/image/';
        if($file_type=='pdf'){
            $savepath = ROOT_PATH . '/uploads/temp/resume/';
            $sitepath= SITE_PATH . '/uploads/temp/resume/';
        }
        $prefix='';
        $datePath = date('Y') . '/' . date('m') . '/' . date('d') . '/';
        if (!is_dir($savepath . $datePath)) {
            mk_dir($savepath . $datePath);
        }
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/octet-stream',
                'content' => file_get_contents($attach->tempName),
            ),
        );
        $file = stream_context_create($options);
        $fileName=$datePath.$newName. '.'.$attach->extensionName;
        $savepath1 = 'image/';
        // 保存简历位置
        if($file_type=='pdf'){
            $modelName::model()->updateAll(array('resume'=>'resume/'.$fileName),'id='.$id);

        }else{
            if($modelName=='Teacher')$savepath1='https://sanli-tracks.com/sanli/uploads/temp/image/';
            $modelName::model()->updateAll(array('header'=>$savepath1.$fileName),'id='.$id);
        }
        if ($attach->saveAs($savepath . $fileName))
        {
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'savename' => $newName. '.'.$attach->extensionName, 'allpath' => $sitepath . $fileName));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }
        echo json_encode($data);
    }


    public function actionSaveMoreImg() {
        //put_msg("上传");
        $data = array();
        $file1=$_FILES['file'];
        $newName=$_POST['newName'];//更改图片名字
        $userid=$_POST['id'];
        //$modelName=$_POST['modelName']; //到底是SignList 还是 teaSignList
        $file_type=$_POST['file_type'];
        if(empty($file1)||$file1['error']==4) ajax_exit(array('status' => 0, 'msg' => '上传失败，稍后再试'));
        if($file1['error']==5) ajax_exit(array('status' => 0, 'msg' => '上传失败，上传文件大小为0'));
        if($file1['error']==1) ajax_exit(array('status' => 0, 'msg' => '上传文件大小超出范围'));
        //修改php.ini中的upload_max_filesize来增大范围
        $attach = CUploadedFile::getInstanceByName('file');
        $savepath = ROOT_PATH . '/uploads/temp/code_image/';
        $sitepath = SITE_PATH . '/uploads/temp/code_image/';
        if($file_type=='pdf'){
            $savepath = ROOT_PATH . '/uploads/temp/code_resume/';
            $sitepath= SITE_PATH . '/uploads/temp/code_resume/';
        }
        $prefix='';
        $datePath = date('Y') . '/' . date('m') . '/' . date('d') . '/';
        if (!is_dir($savepath . $datePath)) {
            mk_dir($savepath . $datePath);  //创建一个文件夹
        }
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/octet-stream',
                'content' => file_get_contents($attach->tempName),
            ),
        );
        $file = stream_context_create($options);
        $fileName = $datePath.$prefix . uniqid('', true) . timeToFilename(). '.' . $attach->extensionName;
//        $savepath1 = 'code_image/';
//        // 保存简历位置
//        if($file_type=='pdf'){
//            $modelName::model()->updateAll(array('resume'=>'code_resume/'.$fileName),'id='.$userid);
//
//        }else{
//            //if($modelName=='teaSignList')$savepath1='https://sanli-tracks.com/sanli/uploads/temp/image/';
//            //报名表的附件名称为 img
//            $modelName::model()->updateAll(array('img'=>$savepath1.$fileName),'userid='.$userid);
//        }
        if ($attach->saveAs($savepath . $fileName))
        {
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'savename' => $newName. '.'.$attach->extensionName, 'allpath' => $sitepath . $fileName));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传-失败'));
        }
        echo json_encode($data);
    }




    //修改附件的接口
//{"A":"code_image\/2022\/07\/05\/1.png","B":"code_image\/2022\/07\/05\/2.png","C":"code_image\/2022\/07\/05\/3.png","D":"code_image\/2022\/07\/05\/4.png"}
    public function actionChangeMoreFile()
    {//获取订单号，JSON字符串,modelName :老师 TeaSignList  学生  SignList
        //$para=getParameter("id,more_file,modelName");
        //put_msg(CJSON::encode($_POST));
        $img = $_POST['more_file'];
        $modelName = $_POST['modelName'];
        $id = $_POST['id'];
        $sign = $modelName::model()->find('id = '.$id);
        $sign->img = $img;
        $sign->save();
    }


    //获取附件JSON的接口
    public function actionGetMoreFile()
    {//modelName :老师 TeaSignList  学生  SignList
        $para=getParameter('id,modelName');
        $id = $para['id'];
        $modelName = $para['modelName'];
        $res = $modelName::model()->find('id = '.$id);
        if(!$res)
        {
            echo CJSON::encode("无此报名记录");
        }
        else{
            echo $res->img;
        }

    }




    public function actionunbond($id='',$modelName='Userinfo')
    {
        $flag=0;
        $criteria = new CDbCriteria();
        $criteria ->condition=get_where('1=1',$id,'id',$id,'"');
        $model = $modelName::model();
        $user = $model->find($criteria);
        if(!empty($user)) $user->openid="";
        $flag=$user->save();
        $flag?$this->JsonSuccess(array('code'=>1,'msg'=>'解绑成功')):$this->JsonSuccess(array('code'=>0,'msg'=>'发生错误'));
    }




}