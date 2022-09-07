<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HTML网页布局</title>
    <style>
        body {
            font: 14px Arial,sans-serif;
            margin: 0px;
            height: 100%;
        }
        header {
            padding: 10px 20px;
            background: #acb3b9;
        }
        header h1 {
            font-size: 24px;
        }
        .container {
            width: 100%;
            height: 100%;
            background: #f2f2f2;
        }
        nav, section {
            float: left;
            padding: 20px;
            /*min-height: 170px;*/
            box-sizing: border-box;
        }
        section {
            width: 80%;
            /*height: 1000px;*/
        }
        nav {
            width: 20%;

            background: #d4d7dc;
        }
        nav ul {
            list-style: none;
            line-height: 24px;
            padding: 0px;
        }
        nav ul li a {
            color: #333;
        }
        .clearfix:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }
        footer {
            background: #acb3b9;
            text-align: center;
            padding: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>C语言中文网</h1>
    </header>
    <div class="wrapper clearfix">
        <nav>
            <ul>
                <li><a href="http://c.biancheng.net/">首页</a></li>
                <li><a href="http://c.biancheng.net/html/">HTML教程</a></li>
                <li><a href="http://c.biancheng.net/css3/">CSS教程</a></li>
                <li><a href="http://c.biancheng.net/js/">JS教程</a></li>
                <li><a href="http://c.biancheng.net/java/">Java教程</a></li>
                <li><a href="http://c.biancheng.net/python/">Python教程</a></li>
            </ul>
        </nav>
        <section>
            <h2>网站简介</h2>
            <p>C语言中文网创办于 2012 年初，是一个在线学习<b>编程</b>的网站。C语言中文网已经发布了众多优质编程教程，包括C语言、C++、Java、Python 等，它们都通俗易懂，深入浅出。</p>
            <p>C语言中文网将会持续更新，并且不忘初心，坚持创作优质教程。</p>
        </section>
    </div>
    <footer>
        <p>www.biancheng.net</p>
    </footer>
</div>
</body>
</html>