<?php

class UserController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        parent::_clear($id,'','userId');
    }

    public function actionTest($name=''){
        $t=TestList::model()->find('apply_name='.$name);
        $data=array();
        $data['ID']=$t->id;
        $data['NAME']=$t->name;
        echo CJSON::encode($data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if(!empty( $model->check_button))
            $model->check_button =  explode(',',  $model->check_button );
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    function saveData($model, $post) {
        $s1='0';$msg='保存成功';$redirect=get_cookie('_currentUrl_');
        if($_POST['submitType'] == 'baocunPWD') {
            $model->TPWD=md5(md5($_POST['User']['TPWD']));
            $res=preg_match("/(?=.*[0-9])(?=.*[a-zA-Z]).{8,16}/", $_POST['User']['TPWD']);
            if($res) $s1=$model->save();
            $msg='修改密码成功';
            $redirect='';
        }
        else {$model->attributes = $post;
        $s1=$model->save();
            }
        show_status($s1, $msg,$redirect, '密码中必须包含字母、数字<br>且长度大于8，小于16');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','userName,userId,TUNAME,TCNAME',$keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionAdmin($keywords = '') {
        $modelName = $this->model;
        $model = $modelName::model()->find('userId='.Yii::app()->session['userId']);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('admin', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionIndexInfo($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model()->find('userId='.Yii::app()->session['userId']);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('indexInfo', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionUpdateInfo($keywords = '') {
        $modelName = $this->model;
        $model = $modelName::model()->find('userId='.Yii::app()->session['userId']);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('updateInfo', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    public function actionWxLogin() //获取openid，自定义登录态
    {
        $data=array();
        $json=$_REQUEST;
        $appid = Basefun::model()->get_appid();  //appId
        $secret = Basefun::model()->get_secret(); //appSecret
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
        $token=$jwt->getToken($payload);
        $w1="wx_openid='".$json_obj["openid"]."'";
        $data['isSaveSuccess']=$this->addUserInfo($json["encryptedData"],$json["iv"],$json_obj['session_key']);
        //返回token用于用户识别

        $data['user']=User::model()->get_userinfo($w1);
        $userid=$data['user']['userId'];
        // $address=UserAddress::model()->get_user_address($userid);
        // $data['address']=$address;
        $rs=array('userId'=>$userid,'data'=>$data,'code'=>'200','msg'=>'调用登录成功',);
        $rs['token'] =$token;
        echo CJSON::encode($rs);
    }




    public function actionWxLogin2() //获取openid，自定义登录态
    {
        $data=array();
        $json=$_REQUEST;
        $appid = Basefun::model()->get_appid();  //appId
        $secret = Basefun::model()->get_secret(); //appSecret
        $code = $json["code"];
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
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
        $token=$jwt->getToken($payload);

        $data['isSaveSuccess']=$this->addUserPhone($json["encryptedData"],$json["iv"],$json_obj['session_key']);
        $rs=array('data'=>$data,'code'=>'200','msg'=>'获取电话成功');
        $rs['token'] =$token;
        echo CJSON::encode($rs);
    }


    public function addUserInfo($encryptedData, $iv, $sessionKey){
        $data=$this->decryptData($encryptedData, $iv, $sessionKey);
        $s='login';
        $rs='false';

        if($data){
            //用电话登录的话可以改成用电话查找
            $user=User::model()->find("wx_openid='".$data['openId']."'");
            if(empty($user)){
                $user_info=new User();
                $user_info->isNewRecord=true;
                $user_info->wx_url=$data['avatarUrl'];
                $user_info->nickName=$data['nickName'];
                $user_info->userSex=$data['gender'];
                $user_info->province=$data['province'];
                $user_info->city=$data['city'];
                $user_info->country=$data['country'];
                $user_info->wx_openid=$data['openId'];
                $user_info->createTime=date('Y-m-d H:i:s',$data['watermark']['timestamp']);
                $user_info->userFrom=2;
                $user_info->userStatus=1;
                $s=$user_info->save();
                $rs=array('success'=>$s,'code'=>0,'msg'=>"注册已经成功!");
            }
            else{
                $user->wx_url=$data['avatarUrl'];
                $user->nickName=$data['nickName'];
                $user->userSex=$data['gender'];
                $user->province=$data['province'];
                $user->city=$data['city'];
                $user->country=$data['country'];
                $user->lastTime=date('Y-m-d H:i:s',$data['watermark']['timestamp']);
                $s=$user->save();
                $rs=array('success'=>$s,'code'=>0,'msg'=>"登录已经成功!");
            }
        }
        return $rs;
    }


    public function addUserPhone($encryptedData, $iv, $sessionKey){
        $data=$this->decryptData($encryptedData, $iv, $sessionKey);
        if($data){
            $user=User::model()->find("userId=".DecodeAsk('userId'));
            $user->PHONE=$data['phoneNumber'];
            $s=$user->save();
            $rs=array('isSave'=>$s,'code'=>0,'msg'=>"添加电话成功");
            return $rs;

        }
    }

    //获取用户信息：通过这三个参数将用户信息译码出来
    protected function decryptData($encryptedData, $iv, $sessionKey)
    {
        $appid = Basefun::model()->get_appid();
        if (strlen($sessionKey) != 24 || strlen($iv) != 24) {
            return false;
        }
        $aesKey = base64_decode($sessionKey);
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $data = json_decode($result, true);

        if(empty($data) || $data['watermark']['appid'] != $appid) {
            return false;
        }
        return $data;
    }

    //登录
    public function actionLoginin($userName='',$password=''){
        $modelName = $this->model;
//        $model = $modelName::model()->find('userId='.Yii::app()->session['userId']);
        if(!empty($userName) && !empty($password)){
            // $w = "name = '".$userName."' and password = '".$password."'";
            $w = "name = '".$userName."'";
            $user = $modelName::model()->find($w);
            if(isset($user)){
                if($user['password']==md5($password)){
                    $msg='登陆成功';
                    $code = 100;
                }
                else{
                    $msg='登陆失败，密码错误';
                    $code = 201;
                }
            }
            else{
                $msg='登陆失败，用户名错误或未注册';
                $code = 202;
            }
        }
        else{
            $msg='密码或用户名为空';
            $code = -1;
        }
        $rs = array('code'=>$code,'msg'=>$msg);
        // return json_decode($rs);//对数据进行json解码
        echo CJSON::encode($rs);
        // echo json_encode($rs);
    }
    public function actionRegisterin($userName='',$password='',$checkpassword='')   //注册
    {
        if ($password === $checkpassword){
            $w = "name = '".$userName."'";
            $User=User::model()->find($w);
            // put_msg($User);
            if(!empty($User)){
                $status = empty($User);
                $msg = '注册失败，该用户名已注册';
                $code = 202;
            }
            else{
                $User = new User();
                $User->name = $userName;
                $User->password = md5($password);//md5加密，不可逆
                $status = $User->save();
                $msg = '注册成功';
                $code = 100;
            }
        }
        else{
            $status = empty($User);
            $msg = '注册失败，两次输入的密码不一致';
            $code = 201;
        }
        $rs = array('code'=>$code,'msg'=>$msg,'status'=>$status);
        echo json_encode($rs);
    }

    //登录
    public function actionLogin($userName='',$password='') {
        if(!empty($userName) and !empty($password) ) {
            $para = $this->getLoginName();
            $this->checkPass($para['nickname'], $para['password'], $para['openid']);
        }
        else{
            $data = array();
            $data['error'] = "账号或密码不能为空";
            return $data;
        }
    }
    public function getLoginName() {
        $para=getParameter();
        $nickname="";
        $password="";
        if(isset($para['formData']['userName']))
            $nickname=$para['formData']['userName'];
        if(isset($para['userName']))
            $nickname=$para['userName'];
        if(isset($para['nickName']))
            $nickname=$para['nickName'];
        if(isset($para['formData']['password']))
            $password=$para['formData']['password'];
        if(isset($para['password']))
            $password=$para['password'];
        if(empty($para['openid']))
            $para['openid']='';

        $para['nickname']=$nickname;
        $para['password']=$password;
        return $para;
    }

    public function checkPass($userName='0',$password='0',$openid="") {
        $w1= "name='".$userName."'";
        $staff =User::model()->find($w1);
        $er=1;$userid=0;
        $msg='账号或密码错误';
        if($staff){
            if($staff['password']==md5($password.$staff['loginSecret'])){
                $userid=$staff['userId'];
                $msg="登录正确";
                $er=0;
            }
        }
        $this->get_adress($userid,$er,$msg);
    }

    public function get_adress($userid,$er,$msg) {
        if($er==0){
            $data=array('userId'=>$userid,'token'=>'1');
            $data['user']=User::model()->get_userinfo('userId='.$userid);
            $wx_userid=$userid;
            $rs=array('data'=>$data,'code'=>'200','msg'=>$msg);

        }
        else{
        $rs=array('code'=>'200','msg'=>$msg);
        }
        echo json_encode($rs);

    }

    public function actionRegister()   //注册
    {
        $data=array();
        $post=file_get_contents("php://input");
        $json=json_decode($post,true);
        $formdata=$json['formData'];
        $User=User::model()->find("account=?",[$formdata['userName']]);
        if(!empty($User)) $data['status']=-1;//status返回-1为已注册
        else{
            $User=new User();
            $User->account=$formdata['userName'];
            $User->password=$formdata['password'];
            $User->name=$formdata['name'];
//            $User->school=$formdata['school'];
//            $User->grade=$formdata['grade'];
//            $User->class=$formdata['classNum'];
            $data['status']=$User->save();
        }
        echo CJSON::encode($data);
    }
}
