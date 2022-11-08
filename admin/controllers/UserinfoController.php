<?php

class UserinfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($province='',$city='',$district='',$grade='',$class='',$keywords="",$keywords2="",$idnum_encode="") {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='1=1';
        $criteria->condition=get_where($criteria->condition,$grade,'grade',$grade,'"');
        $criteria->condition=get_where($criteria->condition,$class,'class',$class,'"');
        $criteria->condition=get_like($criteria->condition,'schoolname,name',$keywords,'');
        if($_SESSION['F_ROLENAME']==='省级主管部门')
            $criteria->condition=get_where($criteria->condition,$_SESSION['F_province'],'province',$_SESSION['F_province'],'"');
        if($_SESSION['F_ROLENAME']==='市级主管部门')
            $criteria->condition=get_where($criteria->condition,$_SESSION['F_city'],'city',$_SESSION['F_city'],'"');
        if($_SESSION['F_ROLENAME']==='县级主管部门')
            $criteria->condition=get_where($criteria->condition,$_SESSION['F_district'],'district',$_SESSION['F_district'],'"');
        if($_SESSION['F_ROLENAME']==='学校') $criteria->condition=get_where($criteria->condition,$_SESSION['TUNIT_id'],'update_unitid',$_SESSION['TUNIT_id'],'"');
        if($_SESSION['F_ROLENAME']==='服务机构') $criteria->condition=get_where($criteria->condition,$_SESSION['adminid'],'update_userid',$_SESSION['adminid'],'"');
        $data = array();
        $idnum_decode = '';
        if($idnum_encode!='') {
            $idnum_decode = md5(md5($idnum_encode) . 's1c2n3u4csyyds');
            $criteria->condition=get_where($criteria->condition,$idnum_decode,'idnum',$idnum_decode,'"');
        }
        if (is_numeric($province)) {
            $p=location::model()->find('id='.$province)->name;
            $criteria->condition=get_where($criteria->condition,$p,'province',$p,'"');
            $data['city'] = Location::model()->findAll('pid=' . $province);
        }
        else{
            $criteria->condition=get_where($criteria->condition,$province,'province',$province,'"');
        }
        if (is_numeric($city)) {
            $c=location::model()->find('id='.$city)->name;
            $criteria->condition=get_where($criteria->condition,$c,'city',$c,'"');
            $data['district'] = Location::model()->findAll('pid=' . $city);
        }
        else{
            $criteria->condition=get_where($criteria->condition,$city,'city',$city,'"');
        }
        if (is_numeric($district)) {
            $d=location::model()->find('id='.$district)->name;
            $criteria->condition=get_where($criteria->condition,$d,'district',$d,'"');
        }
        else{
            $criteria->condition=get_where($criteria->condition,$district,'district',$district,'"');
        }

        $_SESSION['criteria_userinfo'] = CJSON::encode($criteria);

        $data['province'] = Location::model()->findAll('pid=0');
        parent::_list($model, $criteria, 'index', $data,20);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        parent::_create($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $temp=$_POST[$modelName];
            $this-> saveData($model,$temp);
        }
    }

    public function actionUpdateTime()
    {
        $students = Userinfo::model()->findAll();
        $class = BaseClass::model()->findAll();
        foreach ($students as $v)
        {
            $v->grade = $v->grade + 1;
            $v->save();
        }
        foreach ($class as $v)
        {
            $v->grade = $v->grade + 1;
            $v->save();
        }
        $date =  Date('Y-m-d H:i:s');
        $update_time = new UpdateTime();
        $update_time->time = $date;
        $update_time->save();
        echo "<script>alert('更新成功!');window.location.href='".$this->createUrl("Userinfo/index")."';</script>";
        // $this->render('index');
    }

    public function actionReGrade()
    {
        $students = Userinfo::model()->findAll();
        $class = BaseClass::model()->findAll();
        foreach ($students as $v)
        {
            if( $v->grade > 1)
                $v->grade = $v->grade - 1;
            $v->save();
        }
        foreach ($class as $v)
        {
            if( $v->grade > 1)
            {
                $v->grade = $v->grade - 1;
                $v->save();
            }
        }
        echo "<script>alert('递减成功!');window.location.href='".$this->createUrl("Userinfo/index")."';</script>";
    }

    public function actionCreateByImp() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('import', $data);
        }else{
            $this->saveData1($model,$_POST[$modelName],1);
        }
    }


    public function actionDelete($id) {
        parent::_clear($id);
    }

    function saveData($model,$post) {
        if(isset($post['idnum']))
        {
            $idnum = $post['idnum'];
            $post['idnum'] = md5(md5($idnum).'s1c2n3u4csyyds');
            $post['find_id'] = AES_encrypt($idnum);
            $post['idnum_display'] = substr($idnum,0,2).'**************'.substr($idnum,16,2);
        }
        $model->attributes =$post;
        show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    function saveData1($model,$post,$is_import=0) {
        if(empty($_POST['Userinfo']['schoolid'])||empty($_POST['Userinfo']['schoolname']))
        {
            show_status(0,'保存成功', get_cookie("_currentUrl_"),"学校信息未填写");
        }
        else{
            $status=1;
            if($is_import){
                $status=0;
                $path=ROOT_PATH.'/uploads/temp/'. $post['excelPath'];
                $nameArray=array(
                    'name','sex','education','phone','birthday',
                    'grade','class','province','city','district',
                    'idnum','parents','p_phone','p_idnum','aller');
                //从B列 4行开始导入
                $Import = new ImportExcel();
                //put_msg(9999);
                $status=$Import->importUserinfo($_POST['Userinfo']['schoolname'],$_POST['Userinfo']['schoolid'],$path,$this->model,$nameArray,'B',4);
            }
            show_status($status===true,'保存成功', get_cookie("_currentUrl_"),$status);
        }
    }



    private function DeleteImage($id)
    {
        $imagePath=ROOT_PATH.'/uploads/image/column/';
        $array = explode(",", $id);
        foreach ($array as $v) {
            $model=NewsColumn::model()->find('id='.$v);
            if($model->image!=''&&file_exists($imagePath.$model->image))
            {
                unlink($imagePath.$model->image);
            }
        }

    }

    public function actionExcel(){

        //利用excel导出插件PHPExcel
        // 引入phpexcel核心类文件
        require_once ROOT_PATH . '/admin/extensions/PHPExcel/PHPExcel.php';
        // 实例化excel类
        $objPHPExcel = new PHPExcel();
        // 操作第一个工作表
        $objPHPExcel->setActiveSheetIndex(0);
        // 设置sheet名
        $objPHPExcel->getActiveSheet()->setTitle('学生信息总表');
        //设置表格宽度
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);


        // 列名表头文字加粗
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
        // 列表头文字居中
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 列名赋值
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '性别');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '学历');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '手机号');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '出生日期');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '学校');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '年级');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '班级');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '省份');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '城市');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '镇区');//条件
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '身份证号');//条件
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '监护人');//条件
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '监护人手机号');//条件
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '监护人身份证号');//条件


        //$criteria -> select = array('id','userid','username','sex','grade','class','status','teacher','groupnum','car_id','car','room_id','room','school_teacher');   //筛选字
       // $criteria -> condition = get_where($criteria -> condition,$id,'courseid',$id);  //筛选课程（可传递参数）
       // $criteria -> condition = get_where($criteria -> condition,3,'status',3,'"');    //筛选成功报名的名单
        //$criteria -> order = 'groupnum asc,grade asc,class asc';   //指定排序

        //$criteria = new CDbCriteria();
        //$criteria -> condition = ('1=1');
       // $criteria -> condition = get_where($criteria -> condition,$_SESSION['F_city'],'city',$_SESSION['F_city'],'"');


        $criteria = CJSON::decode($_SESSION['criteria_userinfo']);
        //查找最新的固化数据
        $search = Userinfo::model()->findAll($criteria);

        // 数据起始行
        $row_num = 2;
        $cnt=1;
        // 向每行单元格插入数据
        foreach($search as $res)
        {
            $idnum = AES_decrypt($res->find_id);
            $p_idnum  =AES_decrypt($res->find_p_id);
            // 设置所有垂直居中
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row_num . ':' . 'P' . $row_num)->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // 设置价格为文本格式
            $objPHPExcel->getActiveSheet()->getStyle('J' . $row_num)->getNumberFormat()
                ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $objPHPExcel->getActiveSheet()->getStyle('D' . $row_num)->getNumberFormat()
                ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            // 居中
            $objPHPExcel->getActiveSheet()->getStyle('E' . $row_num . ':' . 'P' . $row_num)->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // 设置单元格数值
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_num, $cnt++);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_num, $res->name);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_num, $res->sex);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_num, $res->education);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'. $row_num,$res->phone,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_num, $res->birthday );
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_num, $res->schoolname );
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row_num, $res->grade );
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row_num, $res->class );
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row_num, $res->province );
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row_num, $res->city );
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $row_num, $res->district );
            //$objPHPExcel->getActiveSheet()->setCellValue('J' . $row_num, $res->idnum);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('M'. $row_num,$idnum,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $row_num, $res->parents );
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'. $row_num,$res->p_phone,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('P'. $row_num,$p_idnum,PHPExcel_Cell_DataType::TYPE_STRING);
            $row_num++;
        }
        ob_end_clean();
        $outputFileName = 'student_' . time() . '.xls';
        $xlsWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="' . $outputFileName . '"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
//        header("Content-Type: application/vnd.ms-execl");
//        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
//        header("Content-Disposition: attachment; filename=$outputFileName");
//        header("Pragma: no-cache");
//        header("Expires: 0");
        $xlsWriter->save("php://output");
        echo file_get_contents($outputFileName);
    }

}

