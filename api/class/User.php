<?php


require_once __DIR__ . '/Error.php';

class User
{
//    数据库连接对象，PDO，
    private PDO $_db;

    /**
     * @param $_db
     */
    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }


//    用户注册
    public function register($username, $password)
    {
        if (empty($username)) {
            throw new Exception("empty username", ErrorCode::USERNAME_CANNOT_NULL);
        }
        if (empty($password)) {
            throw new Exception("password empty", ErrorCode::PASSWORD_CANNOT_NULL);

        }
        if ($this->isUserNameExists($username)) {
            throw new Exception("user exist", ErrorCode::USERNAME_EXIST);
        }

        $sql = "insert into `user`(`name`,`password`,`create_time`) value(:username,:password,:addtime)";
        $addtime = date("Y-m-d H:i:s", time());
        $sm = $this->_db->prepare($sql);
        $password = $this->_md5($password);
        $sm->bindParam(':username', $username);
        $sm->bindParam(':password', $password);
        $sm->bindParam(':addtime', $addtime);

        if (!$sm->execute()) {
            throw new Exception("fail to register", ErrorCode::REGISTER_FAIL);
        }

        return [
            'username' => $username,
            'user_id' => $this->_db->lastInsertId(),
            'addtime' => $addtime
        ];
    }

    /**
     * user login
     * @param $username string
     *
     * @param $password string
     * @return mixed
     * @throws Exception
     */
    public function login($username, $password)
    {
        if (empty($username)) {
            throw new Exception("empty username", ErrorCode::USERNAME_CANNOT_NULL);
        }
        if (empty($password)) {
            throw new Exception("password empty", ErrorCode::PASSWORD_CANNOT_NULL);

        }
        $sql = <<<EOF
select * from `user` where `name`=:username and `password`=:password
EOF;

        $sm = $this->_db->prepare($sql);
        $password = $this->_md5($password);
        $sm->bindParam(":username", $username);
        $sm->bindParam(":password", $password);
        if (!$sm->execute()) {
            throw new Exception("login fail", ErrorCode::LOGIN_FAIL);
        }


        $re = $sm->fetch(PDO::FETCH_ASSOC);
        if (!$re) {
            throw new Exception("username or password error", ErrorCode::USERNAME_OR_PASSWORD_ERROR);
        }
        return $re;
    }

    private function isUserNameExists($username)
    {
        $sql = "SELECT * from `user` where `name`=:username";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':username', $username);

        $sm->execute();
        $re = $sm->fetch(PDO::FETCH_ASSOC);
        return !empty($re);
    }

    private function _md5($password)
    {
        return md5($password . SALT);
    }


}