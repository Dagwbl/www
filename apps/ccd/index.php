<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>引文数据库查询</title>
</head>

<body>
    <h1>引文数据库查询</h1>
    <div class="searchForm">
        <form action="scd.php" method="get">
            数据库：<select name="database">
                <option>SCD</option>
                <option>PKU</option>
                <option>CSCD</option>
                <option>SCI</option>
            </select>
            期刊名：<input type="text" name="jornal">
            ISSN: <input type="text" name="issn">
            <input type="submit" value="Query">
        </form>
    </div>

</body>

</html>