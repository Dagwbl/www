<?php

require_once __DIR__ . './ErrorCode.php';

class PhysicalPole
{
    private PDO $_db;

    /**
     * @param $_db
     */
    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }

    public function getALL()
    {
        $sql = "select * from `physical_pole`";
        $sm = $this->_db->prepare($sql);
        if (!$sm->execute()) {
            throw new Exception("获取失败", ErrorCode::EXECUTE_FAIL);
        }
        $re = $sm->fetchAll();
        return $re;

    }

    public function add($location)
    {
        $sql = "insert into `physical_pole`(`location`) value(:location)";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(":location", $location);

    }

    public function edit($id, $location, $sensor, $switch, $beep, $sensor_id)
    {

        $sql = "update `physical_pole` 
                set 
                    `id`=:id, 
                    `location`=:location, 
                    `sensor`=:sensor,
                    `switch`=:switch,
                    `beep`=:beep,
                    `sensor_id`=:sensor_id
                where `id`=:id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(":id",$id);
        $sm->bindParam(":location",$location);
        $sm->bindParam(":sensor",$sensor);
        $sm->bindParam(":switch",$switch);
        $sm->bindParam(":beep",$beep);
        $sm->bindParam(":sensor_id",$sensor_id);
        if (!$sm->execute()){
            throw new Exception("更新失败",ErrorCode::UPDATE_FAIL);
        }
        $re = $sm->fetch();
        return $re;
    }

    public function delete($id)
    {
        $sql = "delete from `physical_pole` where `id`=:id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(":id",$id);
        if (!$sm->execute()){
            throw new Exception("删除失败",ErrorCode::UPDATE_FAIL);
        }
    }


}