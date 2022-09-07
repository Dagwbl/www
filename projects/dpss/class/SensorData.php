<?php

require_once __DIR__.'/ErrorCode.php';

class SensorData
{
    private PDO $_db;

    /**
     * @param PDO $_db
     */
    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }

    public function getAll(){
        $sql = "select * from `sensordata`";
        $sm = $this->_db->prepare($sql);
        if (!$sm->execute()){
            throw new Exception("获取失败",ErrorCode::EXECUTE_FAIL);
        }
        $re = $sm->fetchAll();
        return $re;


    }

    public function byFilter($condition){
        $sql = "select * from `sensordata` $condition";
        dump($sql);
        $sm = $this->_db->prepare($sql);
        if (!$sm->execute()){
            throw new Exception("获取失败",ErrorCode::EXECUTE_FAIL);
        }
        $re = $sm->fetchAll();
        return $re;
    }

    public function delete($condition){
        $sql = "delete from `sensordata` where $condition";
        dump($sql);
        $sm = $this->_db->prepare($sql);
        if (!$sm->execute()){
            throw new Exception("删除失败",ErrorCode::DELETE_FAIL);
        }
        $re = $sm->fetchAll();
        return $re;
    }

}