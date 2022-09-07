<?php
require_once __DIR__.'/Error.php';

class Article
{
    /**
     * database operate objection
     * @var PDO
     */
    private PDO $_db;

    /**
     * @param PDO $_db
     */
    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }

    /**
     * write article
     * @param $title string 文章标题
     * @param $content
     * @param $user_id
     * @return array
     * @throws Exception
     */
    public function create($title,$content,$user_id){
        if (empty($title)){
            throw new Exception("The article title can not set empty",ErrorCode::ARTICLE_TITLE_CANNOT_NULL);
        }
        if (empty($content)){
            throw new Exception("The article content can not set empty",ErrorCode::ARTICLE_CONTENT_CANNOT_NULL);
        }
        $sql = "insert into `article` (`title`,`content`,`user_id`,`create_time`) values (:title,:content,:user_id,:create_time)";
        $time = date('Y-m-d H:i:s',time());
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':title',$title);
        $sm->bindParam(':content',$content);
        $sm->bindParam(':user_id',$user_id);
        $sm->bindParam(':create_time',$time);

        if (!$sm->execute()){
            throw new Exception("publish fail",ErrorCode::ARTICLE_CREATE_FAIL);
        }

        return [
            'title'=>$title,
            'content'=>$content,
            'article_id'=>$this->_db->lastInsertId(),
            'create_time'=>$time,
            'user_id'=>$user_id

        ];
    }

    /**
     * 编辑文辉
     * @param $article_id int 文章id
     * @param $title string 文章标题
     * @param $content string 文章内容
     * @param $user_id int 用户id
     * @return array|mixed
     * @throws Exception
     */
    public function edit(int $article_id, string $title, string $content, int $user_id): mixed
    {
        $article = $this->view($article_id);
        if (!$user_id==$article['user_id']){
            throw new Exception("你无权操作此文章",ErrorCode::PREMISSION_NOT_ALLOW);

        }
        $title = empty($title)?$article['title']:$title;
        $content = empty($content)?$article['content']:$content;
        if ($title==$article['title']&& $content==$article['content']){
            return $article;
        }
        $sql = "update `article` set `title`=:title,`content`=:content where `id`=:id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':title',$title);
        $sm->bindParam(':content',$content);
        $sm->bindParam(':id',$article_id);

        if (!$sm->execute()){
            throw new Exception("编辑文章失败",ErrorCode::ARTICLE_EDIT_ERROR);

        }

        return [
            'title'=>$title,
            'content'=>$content,
            'id'=>$article_id,
            'user_id'=>$user_id
        ];
    }

    /**
     * 删除文章
     * @param $article_id int 文章id
     * @param $user_id int 用户id
     * @return string[]
     * @throws Exception
     */
    public function delete($article_id,$user_id){
        $article = $this->view($article_id);
        if ($user_id!=$article['user_id']){
            throw new Exception("你无权操作此文章",ErrorCode::PREMISSION_NOT_ALLOW);

        }
        $sql = "delete from `article` where `id`=:id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':id',$article_id);

        if (!$sm->execute()){
            throw new Exception("删除失败",ErrorCode::DELETE_FAIL);
        }
        return [
            'status'=>"删除成功"
        ];

    }

    /**
     * 查看文章
     * @param $article_id int 文章id
     * @return mixed
     * @throws Exception
     */
    public function view($article_id)
    {
        if (empty($article_id)){
            throw new Exception('文章ID不能为空',ErrorCode::ARTICLE_ID_CANNOT_NUL);

        }
        $sql = "select * from `article` where `id`=:id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam('id',$article_id);
        if (!$sm->execute()){
            throw new Exception("获取文章失败",ErrorCode::ARTICLE_GET_FAIL);

        }
        $article = $sm->fetch(PDO::FETCH_ASSOC);
        if (empty($article)){
            throw new Exception("文章不存在",ErrorCode::ARTICLE_NOT_EXISTS);
        }
        return $article;
    }

    public function getList($limit){
        $sql = "select * from `article` limit 10";
        $sm = $this->_db->prepare($sql);
        $articleList = $sm->fetchAll(PDO::FETCH_ASSOC);
        if (empty($articleList)){
            throw new Exception("没有文章",ErrorCode::NONE_ARTICLE);
        }
        return $articleList;
    }


}