<?php
$servername = "localhost";
$username = "root";
$password = "1005";
$dbname = "myDBPDO";

function insert($data){
    // 插入数据
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // 设置 PDO 错误模式，用于抛出异常
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO MyGuests (firstname, lastname, email)
    VALUES ('John', 'Doe', 'john@example.com')";
        // 使用 exec() ，没有结果返回
        $conn->exec($sql);
        echo "新记录插入成功";
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

//插入多条数据
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 开始事务
        $conn->beginTransaction();
        // SQL 语句
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) 
    VALUES ('John', 'Doe', 'john@example.com')");
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) 
    VALUES ('Mary', 'Moe', 'mary@example.com')");
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) 
    VALUES ('Julie', 'Dooley', 'julie@example.com')");

        // 提交事务
        $conn->commit();
        echo "新记录插入成功";
    }
    catch(PDOException $e)
    {
        // 如果执行失败回滚
        $conn->rollback();
        echo $sql . "<br>" . $e->getMessage();
    }

//使用预处理插入多条记录
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // 设置 PDO 错误模式为异常
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 预处理 SQL 并绑定参数
        $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) 
    VALUES (:firstname, :lastname, :email)");
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);

        // 插入行
        $firstname = "John";
        $lastname = "Doe";
        $email = "john@example.com";
        $stmt->execute();

        // 插入其他行
        $firstname = "Mary";
        $lastname = "Moe";
        $email = "mary@example.com";
        $stmt->execute();

        // 插入其他行
        $firstname = "Julie";
        $lastname = "Dooley";
        $email = "julie@example.com";
        $stmt->execute();

        echo "新记录插入成功";
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

}

//PDO预处理读取数据
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
    $stmt->execute();

    // 设置结果集为关联数组
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
$conn = null;
?>