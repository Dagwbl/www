<?php

class Rest
{
    /**
     * @var User
     */
    private $_user;

    /**
     * @var Article
     */
    private $_article;

    /**
     * 请求方法
     * @var
     */
    private $_requestMethod;

    /**请求资源
     * @var
     */
    private $_requestResource;

    private $_allowResource = ['users','articles'];
    /**
     * 常见的状态码
     * @var string[]
     */
    private $_statusCode=[
        200=>'OK',
        204=>'No Content',
        400=>'Bad Request',
        404=>'Not Found',
        405=>'Method Not Allowed',
        500=>'Server Internal Error'
    ];

    /**
     * 允许被请求的方法
     * @var string[]
     */
    private $_allowMethod = ['GET','POST','PUT','DELETE'];

    /**
     * 版本号
     * @var
     */
    private $_version;

    /**
     * 资源标识
     * @var
     */
    private $_requestURL;
    /**
     * @param User $_user
     * @param Article $_article
     */
    public function __construct(User $_user, Article $_article)
    {
        $this->_user = $_user;
        $this->_article = $_article;
    }

    /**
     * api 启动方法
     * @return void
     */
    public function run(){
        try {
            $this->setMethod();
            $this->setResource();
            if ($this->_requestResource=='users'){
                $this->sendUsers();
            }else{
                $this->sendArticles();
            }
        }catch (Exception $e){
            $this->_json($e->getMessage(),$e->getCode());
        }

    }

    /**
     *设置api请求方法
     * @return void
     * @throws Exception
     */
    private function setMethod()
    {
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
        if (!in_array($this->_requestMethod,$this->_allowMethod)){
            throw new Exception("请求方法不被允许",405);
        }
    }

    /**
     * 数据输出
     * @param string $getMessage 提示信息
     * @param mixed $getCode 提示状态码
     * @return void
     */
    private function _json(string $getMessage, mixed $getCode)
    {
        if ($getCode!==200){
            header('HTTP/1.1 '.$getCode.' '.$this->_statusCode[$getCode]);
        }

        header("Content-Type:application/json;charset:utf-8");
        if (!empty($getMessage)){
            echo json_encode(['message'=>$getMessage,'code'=>$getCode]);
        }

    }

    /**
     * 处理资源
     * @return void
     * @throws Exception
     */
    private function setResource()
    {
        $path = $_SERVER['REQUEST_URI'];
        $paramas = explode('/',$path);

//        dump($paramas);
        $this->_requestResource = $paramas[2];
        if (!in_array($this->_requestResource,$this->_allowResource)){
            throw new Exception("请求资源不被允许",405);
        }
        $this->_version = $paramas[2];

        if (!empty($paramas[3])){
            $this->_requestURL = $paramas[3];
        }



    }

    /**
     * 处理用户逻辑
     * @return void
     */
    private function sendUsers()
    {
        if ($this->_requestMethod !=='POST'){
            throw new Exception("请求方法不被允许",405);
        }
        if (!$this->_requestURL){
            throw new Exception("请求参数错误",400);
        }
        if ($this->_requestURL=='login'){
            $this->doLogin();

        }
        elseif ($this->_requestURL=='register'){
            $this->doRegister();
        }else{
            throw new Exception("请求资源不被允许",405);
        }
    }

    /**
     * 处理文章逻辑
     * @return void
     */
    private function sendArticles()
    {
    }

    /**
     * 用户登录
     * @return void
     */
    private function doLogin()
    {
        $data = $this->getBody();
        if (empty(['name'])){
            throw new Exception("用户名不能为空",400);

        }
        if (empty($data['password'])){
            throw new Exception("用户密码不能为空",400);
        }
        $user = $this->_user->login($data['name'],$data['password']);
        if ($user){
            $this->_json("登录成功",200);
        }
    }

    /**
     * 用户注册
     * @return void
     */
    private function doRegister()
    {
        $data = $this->getBody();
        if (empty(['name'])){
            throw new Exception("用户名不能为空",400);

        }
        if (empty($data['password'])){
            throw new Exception("用户密码不能为空",400);
        }
        $user = $this->_user->register($data['name'],$data['password']);
        if ($user){
            $this->_json("注册成功",200);
        }
    }

    private function getBody()
    {
        $data = file_get_contents("php://input");
        if (empty($data)){
            throw new Exception("请求参数错误",400);
        }
        return json_decode($data,true);
    }


}