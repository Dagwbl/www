基础url：http://api.local.com/1.0/



# 用户模块

用户注册

> http://api.local.com/1.0/users/register

> post



用户登录

> http://api.local.com/1.0/users/login

> post



user表

| ID          | 用户ID   |
| ----------- | -------- |
| name        | 用户名   |
| password    | 密码     |
| create_time | 注册时间 |



# 文章模块

article表

| ID          | 文章ID     |
| ----------- | ---------- |
| title       | 文章的标题 |
| content     | 文章内容   |
| user_id     | 作者       |
| create_time | 发表时间   |

文章发表

> post
>
> http://api.local.com/1.0/articles/

文章查看

> get 
>
> http://api.local.com/1.0/articles/:id

文章修改

> put
>
> http://api.local.com/1.0/articles/:id

文章删除

> delete
>
> http://api.local.com/1.0/articles/:id

文章列表

> get
>
> http://api.local.com/1.0/articles/list
