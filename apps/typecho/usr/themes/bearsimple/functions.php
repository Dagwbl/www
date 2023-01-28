<?php
error_reporting(0);
use Typecho\Common;
use Typecho\Exception;
use Typecho\Router;
use Utils\Helper;
use Widget\Options;
if(!class_exists('CSF')){
    require_once Helper::options()->pluginDir('BsCore').'/bsoptions-framework.php';
}

if (!class_exists('bsOptions')){
    require_once \Utils\Helper::options()->pluginDir('BsCore').'/bsOptions.php';
}
require_once('core/func.php');
function themeVersion()
        {
            return '2.1.1.20230108';
        }

function themeVersionOnly()
        {
            return '2.1.1';
        }
        
/**解析表情**/
$emo = false;
function reEmo($comment,$type){
    global $emo;
    if(!$emo){
        $emo = json_decode(file_get_contents(dirname(__FILE__).'/assets/vendors/bs-emoji/bs-emoji.json'), true);
        
    }
    $options = Helper::options();


    foreach ($emo as $v){
        if($v['category'] !== ''){
                if($type == 'comment'){
                $comment = str_replace($v['data'], '<img width="30" height="30" src='.$v['icon'] .''.'>', $comment);
                }
                elseif($type == 'reply'){
                $comment = str_replace($v['data'], '<img width="20" height="20" src='.$v['icon'] .''.'>', $comment);
                }
                else{
                $comment = str_replace($v['data'], '<img width="30" height="30" src='.$v['icon'] .''.'>', $comment);                    
                }
        }
    }
    //当评论没有私密评论时去除私密评论识别标签
    $comment = str_replace('@私密@', '', $comment);
    return $comment;
}

function reEmoPost($post){
    global $emo;
    if(!$emo){
        $emo = json_decode(file_get_contents(dirname(__FILE__).'/assets/vendors/bs-emoji/bs-emoji.json'), true);
        
    }
    $options = Helper::options();



    foreach ($emo as $v){
        if($v['category'] !== ''){
                
                $post = str_replace($v['data'], '<img style="display:inline-block;margin: 0;padding: 0;width:30px;height:30px;vertical-align: middle;" class="emoji" src="'.$v['icon'] .'"'.'>', $post);
        }
    }
    return $post;
}

$options = bsOptions::getInstance()::get_option( 'bearsimple' );


function Bsoptions($key, $default = false){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    return $options[$key];
}


if( class_exists( 'CSF' ) ) {
    $Tyoptions = Helper::options();
    $db = \Typecho\Db::get();
  $prefix = 'bearsimple'; 
  CSF::createOptions( $prefix, array(
    'menu_title' => 'Bearsimple',
    'menu_slug'  => 'my-bearsimple',
  ) );
  CSF::createSection( $prefix, array(
    'title'       => '使用说明',
    'icon'        => 'fas fa-bolt',
    'description' => '欢迎使用BearSimple主题V2版本，本主题为<strong>简约式主题</strong>，适合喜欢简约类的博客站长使用，以下是本主题的使用说明。',
    'fields'      => array(

        array(
            'type'    => 'heading',
            'content' => '使用说明',
        ),

        array(
            'type'    => 'content',
            'content' => '<div class="csf-submessage csf-submessage-success">若您对主题有什么意见或者建议可以通过填写问卷告诉我们~<a href="https://flowus.cn/form/4c6d7f6e-71d0-4c49-90d0-ab6211aaf57b?code=7NR0H7">戳这里填写问卷</a></div><br>1、使用本主题尽量少安装插件，否则可能因存在冲突导致各种各样的问题<br>2、主题用户交流QQ群:561848356<br>3、主题讨论微社区:<a href="https://support.qq.com/products/314782?">戳这里访问</a><br>4、主题知识库:<a href="https://bearnotion.flowus.cn/">戳这里访问</a><br>不懂的问题或本主题存在的问题可加群或在微社区中进行反馈，也可先在知识库中查询.          <center>  <br>
 <div class="csf-submessage csf-submessage-info">当前版本:V'.themeVersion().' / 最新版本:V<font id="version"></font></div>
<div id="versiontips" style="margin-top:10px"></div></center>


<script src="//lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/3.6.0/jquery.min.js" type="application/javascript"></script>
  <script src="//lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/layer/3.5.1/layer.min.js" type="application/javascript"></script>
<script>

$(function() {


$.post("https://upgrade.typecho.co.uk/Bearsimple/version.php",function(data,status){
switch(status)
{
case "success":
json = JSON.parse(data);
nowversion = "'.themeVersion().'";
$("#version").html(json.version);
if(json.version > nowversion){
if (/(iPhone|iPad|iPod|iOS|Android)/i.test(navigator.userAgent)) {
    $("#versiontips").html(\'<div class="csf-submessage csf-submessage-warning">检测到有新版本可以更新，请及时完成更新!<br><a href="#check" class="ui warning label">前往更新<a></div>\');
} else {
    $("#versiontips").html(\'<div class="csf-submessage csf-submessage-warning">检测到有新版本可以更新，请及时完成更新!<br><a href="#tab=在线升级" class="ui warning label">前往更新<a></div>\'); 
};

}
break;
case "error":
$("#version").html("最新版本获取失败");
break;
case "timeout":
$("#version").html("最新版本获取超时");
break;
default: $("#version").html("'.themeVersion().'");
}
    });
});
</script>',
        ),

        array(
            'type'    => 'submessage',
            'style'   => 'info',
            'content' => '在反馈本主题相关的问题时，请务必将以下内容放入您要反馈的内容中',
        ),
array(
                'type'    => 'notice',
            'style'   => 'info',
                'content' => '<ul style="margin:0 auto;"><li>BearSimple主题版本：V'.themeVersion().'[<a href="https://bearnotion.flowus.cn/share/d9678d98-ac2b-4692-9599-4a29524d9ebb" target="_blank">更新日志</a>]</li><li>PHP版本：'.PHP_VERSION.'</li><li>网站服务器：'.$_SERVER['SERVER_SOFTWARE'].'</li><li>数据库：'.$db->getAdapterName().'[Version：'.$db->getVersion().']</li><li>Typecho版本：'.$Tyoptions->version.'</li><li>User Agent信息：'.$_SERVER['HTTP_USER_AGENT'].'</li></ul>',
        ),

    )
) );
  CSF::createSection( $prefix, array(
    'title'  => '基础设置',
    'icon'   => 'fas fa-rocket',
    'fields' => array(
      
      array(
            'id'      => 'header_choose',
            'type'    => 'radio',
            'title'   => '站点LOGO类型',
            'inline'  => true,
            'options' => array(
                'text'    => '文字LOGO',
                'image'   => '图片LOGO',
            ),
            'default' => 'text'
        ),
      array(
        'id'    => 'textlogo_text',
        'type'  => 'text',
        'title' => '站点文字LOGO',
        'default' => $options->title,
        'after' => '请填入站点文字LOGO',
        'dependency' => array( 'header_choose', '==', 'text' ),
      ),
      array(
        'id'    => 'textlogo_dec',
        'type'  => 'textarea',
        'title' => '站点文字介绍',
        'after' => '请填入站点文字介绍',
        'dependency' => array( 'header_choose', '==', 'text' ),
      ),
      array(
            'id'      => 'imagelogo',
            'title'   => '站点图片LOGO',
            'after' => '请上传站点图片LOGO，最佳尺寸为250X70',
            'type'    => 'upload',
            'dependency' => array( 'header_choose', '==', 'image' ),
        ),
      array(
            'id'      => 'favicon',
            'type'    => 'upload',
            'title'   => '站点Favicon图标',
        ),
      array(
            'id'      => 'avatar__choose',
            'type'    => 'radio',
            'title'   => '头像服务选择',
            'inline'  => true,
            'options' => array(
                'cravatar'    => 'Cravatar服务',
                'gravatar'   => 'Gravatar服务',
                'diyavatar'   => '自定义头像',
                'closeavatar'   => '不显示头像',
            ),
            'default' => 'cravatar',
            'after' => 'Cravatar服务：Cravatar适合在国内使用，优先级:Cravatar头像->Gravatar头像->QQ头像<br>Gravatar服务：在国内官方源可能访问不了头像，支持了多个镜像源并支持您填写自定义镜像源<br>自定义头像：您可以通过自定义头像在前台为每个用户显示出随机头像，在自定义头像栏为空时默认为Cravatar<br>不显示头像：若选择不显示头像，则评论区和侧边栏最新评论都将不显示头像',
        ),
        array(
            'id'      => 'Cravatar_default',
            'type'    => 'upload',
            'title'   => 'Cravatar默认头像',
            'after' => '考虑到Cravatar默认头像略丑的问题，这里支持自定义Cravatar默认头像。',
            'dependency' => array( 'avatar__choose', '==', 'cravatar' ),
        ),
        array(
        'id'    => 'DiyAvatar',
        'type'  => 'textarea',
        'title' => '自定义头像',
        'after' => '您可以自定义前台评论区随机头像，格式为a.png,b.png，保证每个头像图片都为直链可直接访问，多个头像图片使用英文逗号分隔，当本栏为空时默认使用Cravatar服务。',
        'dependency' => array( 'avatar__choose', '==', 'diyavatar' ),
      ),
      array(
            'id'          => 'Gravatar',
            'type'        => 'select',
            'title'       => 'Gravatar源选择',
            'after' => '因Gravatar官方在中国大陆地区被Q，导致在中国大陆访问使用Gravatar的站点时头像不显示,这里支持您自主选择合适的源,若为自定义，举例:cdn.v2ex.com/gravatar/<br>本功能适配QQ,当填写的邮箱为QQ邮箱时则显示QQ头像',
            'options'     => array('1' => 'Gravatar官方源','2' => 'LOLI.TOP*Gravatar镜像源', '3' => 'V2EX*Gravatar镜像源','4' => 'LOLI.NET*Gravatar镜像源','5' => '极客族*Gravatar镜像源','6' => '七牛*Gravatar镜像源','6-2' => 'Zeruns*Gravatar镜像源','6-3' => 'IDCMOE*Gravatar镜像源','7' => '自定义Gravatar镜像源'),
            'default' => '5',
            'dependency' => array( 'avatar__choose', '==', 'gravatar' ),
        ),
      array(
        'id'    => 'GravatarUrl',
        'type'  => 'text',
        'title' => '自定义Gravatar源地址',
        'after' => '请填入自定义Gravatar镜像源地址,格式:cdn.v2ex.com/gravatar/<br>Tips:当您所填写的自定义地址访问时能够显示图片时则您所填写的地址是正常的',
        'dependency' => array( 'Gravatar|avatar__choose', '==|==', '7|gravatar' ),
      ),
       array(
            'id'          => 'Assets',
            'type'        => 'select',
            'title'       => '资源CDN加速',
            'placeholder' => '选择合适的CDN加速方式',
            'after' => '本主题支持您选择合适的储存方式来储存js、css等文件进而达到网站加速的效果，云端存储由jsdelivr提供服务[Beta-RC版本请勿使用云端存储，切记]。',
            'options'     => array('1' => '本地储存','2' => '云端储存', '3' => '自定义储存'),
            'default' => '1',
        ),
        array(
        'id'    => 'Assets_Custom',
        'type'  => 'text',
        'title' => '自定义CDN加速源地址',
        'after' => '请填入风格文件储存源地址,例子:https://xxxx.com/，或者https://xxxx.com/xxx/，请务必将整个assets目录都放进去!!!当你填写的是https://xxxx.com/时，风格存储地址应该是https://xxxx.com/assets<br>检测结果:'.GetCheck(),
        'dependency' => array( 'Assets', '==', '3' ),
      ),
      array(
            'id'          => 'Animate',
            'type'        => 'select',
            'title'       => '全局显示动画',
            'placeholder' => '选择一款显示动画',
            'after' => '开启后，首页等位置都将显示此动画',
            'options'     => array(
            'close' => '关闭',
            'bounce' => 'bounce',
            'flash' => 'flash',
            'pulse' => 'pulse',
            'rubberBand' => 'rubberBand',
            'headShake' => 'headShake',
            'swing' => 'swing',
            'tada' => 'tada',
            'wobble' => 'wobble',
            'jello' => 'jello',
            'heartBeat' => 'heartBeat',
            'bounceIn' => 'bounceIn',
            'bounceInDown' => 'bounceInDown',
            'bounceInLeft' => 'bounceInLeft',
            'bounceInRight' => 'bounceInRight',
            'bounceInUp' => 'bounceInUp',
            'bounceOut' => 'bounceOut',
            'bounceOutDown' => 'bounceOutDown',
            'bounceOutLeft' => 'bounceOutLeft',
            'bounceOutRight' => 'bounceOutRight',
            'bounceOutUp' => 'bounceOutUp',
            'fadeIn' => 'fadeIn',
            'fadeInDown' => 'fadeInDown',
            'fadeInDownBig' => 'fadeInDownBig',
            'fadeInLeft' => 'fadeInLeft',
            'fadeInLeftBig' => 'fadeInLeftBig',
            'fadeInRight' => 'fadeInRight',
            'fadeInRightBig' => 'fadeInRightBig',
            'fadeInUp' => 'fadeInUp',
            'fadeInUpBig' => 'fadeInUpBig',
            'fadeOut' => 'fadeOut',
            'fadeOutDown' => 'fadeOutDown',
            'fadeOutDownBig' => 'fadeOutDownBig',
            'fadeOutLeft' => 'fadeOutLeft',
            'fadeOutLeftBig' => 'fadeOutLeftBig',
            'fadeOutRight' => 'fadeOutRight',
            'fadeOutRightBig' => 'fadeOutRightBig',
            'fadeOutUp' => 'fadeOutUp',
            'fadeOutUpBig' => 'fadeOutUpBig',
            'flip' => 'flip',
            'flipInX' => 'flipInX',
            'flipInY' => 'flipInY',
            'flipOutX' => 'flipOutX',
            'flipOutY' => 'flipOutY',
            'rotateIn' => 'rotateIn',
            'rotateInDownLeft' => 'rotateInDownLeft',
            'rotateInDownRight' => 'rotateInDownRight',
            'rotateInUpLeft' => 'rotateInUpLeft',
            'rotateInUpRight' => 'rotateInUpRight',
            'rotateOut' => 'rotateOut',
            'rotateOutDownLeft' => 'rotateOutDownLeft',
            'rotateOutDownRight' => 'rotateOutDownRight',
            'rotateOutUpLeft' => 'rotateOutUpLeft',
            'rotateOutUpRight' => 'rotateOutUpRight',
            'hinge' => 'hinge',
            'jackInTheBox' => 'jackInTheBox',
            'rollIn' => 'rollIn',
            'rollOut' => 'rollOut',
            'zoomIn' => 'zoomIn',
            'zoomInDown' => 'zoomInDown',
            'zoomInLeft' => 'zoomInLeft',
            'zoomInRight' => 'zoomInRight',
            'zoomInUp' => 'zoomInUp',
            'zoomOut' => 'zoomOut',
            'zoomOutDown' => 'zoomOutDown',
            'zoomOutLeft' => 'zoomOutLeft',
            'zoomOutRight' => 'zoomOutRight',
            'zoomOutUp' => 'zoomOutUp',
            'slideInDown' => 'slideInDown',
            'slideInLeft' => 'slideInLeft',
            'slideInRight' => 'slideInRight',
            'slideInUp' => 'slideInUp',
            'slideOutDown' => 'slideOutDown',
            'slideOutLeft' => 'slideOutLeft',
            'slideOutRight' => 'slideOutRight',
            'slideOutUp' => 'slideOutUp',
        ),
            'default' => 'close',
        ),
              array(
        'id'    => 'BackGround',
        'type'    => 'upload',
        'title' => '网站背景',
        'after' => '请上传网站背景图片,若为空则不显示<br><a style="color:red">提醒：图片名请勿带括号等特殊符号，如xxx(1).jpg，可能会出现无法显示的情况</a>',
      ),
            array(
        'id'    => 'Diyfont',
        'type'  => 'text',
        'title' => '自定义字体',
        'after' => '您可以自定义网站所显示的字体，请填入字体直链，若为空则表示使用默认字体',
      ),
        array(
            'id'       => 'Diyfontsize',
            'type'     => 'number',
            'title'    => '自定义字体大小',
            'after' => '<br><br>您可以自定义网站所显示的字体大小,单位为px(像素)，填写数字即可，若为空则表示字体大小默认不变<br><font color=red>温馨提醒:字体大也不一定好看哦～</font>',
            'unit'     => 'px',
        ),
        array(
            'id'      => 'hcsticky',
            'type'    => 'switcher',
            'title'       => '是否对侧边栏使用粘住',
            'default' => false,
        ),
        

        array(
            'id'      => 'global_shadow',
            'type'    => 'switcher',
            'title'       => '全局增加阴影效果',
            'subtitle' => 'Tips:阴影效果在宽屏模式下看不到效果。',
            'default' => false,
        ),
                array(
            'id'      => 'global_transparent',
            'type'    => 'switcher',
            'title'       => '全局增加透明效果',
            'default' => false,
        ),
         array(
            'id'          => 'pagination_style',
            'type'        => 'select',
            'title'       => '分页样式选择',
            'after' => '选择上一页下一页的分页样式，默认为新样式。',
            'options'     => array('1' => '新样式',  '2' => '旧样式'),
            'default' => '1',
        ),
         array(
            'id'          => 'menu_style',
            'type'        => 'select',
            'title'       => '导航菜单样式选择',
            'after' => '选择头部导航菜单的样式，默认为旧样式。',
            'options'     => array('1' => '旧样式',  '2' => '新样式'),
            'default' => '2',
        ),
        array(
                'id'      => 'width_Selection',
                'type'    => 'image_select',
                'title'   => '页面宽度模式',
                'options' => array(
                    '1' => Helper::options()->themeUrl.'/assets/image/narrow.jpg',
                    '2' => Helper::options()->themeUrl.'/assets/image/wild.jpg',
                ),
                'after' => '选择前台是要宽屏模式还是窄屏模式，若为窄屏模式则为固定宽度，若为宽屏模式则跟随屏幕的宽度而变化。',
                'default' => '1'
            ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '首页及分类',
    'icon'   => 'fas fa-folder',
    'fields' => array(
              array(
            'id'      => 'Sticky',
            'type'    => 'switcher',
            'title'       => '是否开启文章置顶',
            'default' => false,
        ),
    array(
            'id'          => 'Sticky_cids',
            'type'        => 'select',
            'title'       => '首页需要置顶的文章',
            'chosen'      => true,
            'multiple'    => true,
            'sortable'    => true,
            'ajax'        => true,
            'options'     => 'posts',
            'placeholder' => '选择需要置顶的文章',
            'dependency' => array( 'Sticky', '==', true ),
        ),
        array(
            'id'          => 'Sticky_cids_pages',
            'type'        => 'select',
            'title'       => '首页需要置顶的页面',
            'chosen'      => true,
            'multiple'    => true,
            'sortable'    => true,
            'ajax'        => true,
            'options'     => 'pages',
            'placeholder' => '选择需要置顶的页面',
            'dependency' => array( 'Sticky', '==', true ),
        ),
        array(

            'id'          => 'Sticky_cids_category',
            'type'        => 'select',
            'title'       => '分类需要置顶的文章',
            'chosen'      => true,
            'multiple'    => true,
            'sortable'    => true,
            'ajax'        => true,
            'options'     => 'posts',
            'placeholder' => '选择需要置顶的文章',
            'dependency' => array( 'Sticky', '==', true ),
        ),
        array(

            'id'      => 'Sticky_Category',
            'type'    => 'switcher',
            'title'       => '开启后分类置顶只在文章所属分类置顶',
            'default' => false,
            'dependency' => array( 'Sticky', '==', true ),
        ),
        array(

            'id'       => 'Sticky_Mod',
            'type'     => 'code_editor',
            'title'    => '文章置顶样式',
            'subtitle' => '可自定义文章置顶样式，支持HTML',
            'default' => '<span style="color:red">[置顶]</span>',
            'dependency' => array( 'Sticky', '==', true ),
        ),
        array(
            'id'          => 'Article_forma',
            'type'        => 'select',
            'title'       => '选择首页、分类等页面输出文章的展现样式',
            'after' => '若选择简洁图文、图底文字或者简洁图文2，则当存在图片时展现图文样式，优先级：文章封面->附件首图->文章首图->自定义随机图片，无图片时默认显示预设图片',
            'options'     => array('1' => '简洁图文',  '2' => '纯文字','3' => '图底文字','4' => '纯文字2','5' => '简洁图文2'),
            'default' => '2',
        ),
        array(
        'id'    => 'Article_forma_pic',
        'type'  => 'textarea',
        'title' => '图文样式自定义随机图片',
        'after' => '请填入图文样式自定义随机图片',
        'dependency' => array( 'Article_forma', 'any', '1,3,5' ),
      ),
      array(
            'id'      => 'show_cate',
            'type'    => 'switcher',
            'title'       => '显示文章所在分类',
            'default' => false,
            'dependency' => array( 'Article_forma', 'any', '1,2' ),
            ),
            array(
            'id'      => 'show_comment',
            'type'    => 'switcher',
            'title'       => '显示评论数',
            'default' => false,
            'dependency' => array( 'Article_forma', 'any', '1,2' ),
            ),
            array(
            'id'      => 'Article_time',
            'type'    => 'switcher',
            'title'       => '显示文章发布时间',
            'default' => false,
            'dependency' => array( 'Article_forma', 'any', '1,2,3,4,5' ),
        ),
        array(
            'id'      => 'Article_expert',
            'type'    => 'switcher',
            'title'       => '显示文章摘要',
            'default' => true,
            'subtitle' => '该项为全局设置，若不显示则全局文章输出都不显示摘要',
            'dependency' => array( 'Article_forma', 'any', '1,2,3,4,5' ),
        ),
        array(
            'id'       => 'articletitlenum',
            'type'     => 'number',
            'title'    => '首页、分类等页面输出文章的标题字数',
            'after' => '<br><br>首页、分类等页面输出文章的标题字数, 填写数字即可',
            'unit'     => '个字',
        ),
        array(
            'id'       => 'articleexcerptnum',
            'type'     => 'number',
            'title'    => '首页、分类等页面输出文章的摘要字数',
            'after' => '<br><br>填写数字即可,该项仅应用于自动截取摘要,当文章内存在手动填写摘要时该项无效',
            'unit'     => '个字',
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '顶部设置',
    'icon'   => 'fas fa-headphones',
    'fields' => array(
      array(
            'id'      => 'DNSYJX',
            'type'    => 'switcher',
            'title'       => 'DNS预解析',
            'default' => false,
        ),
        array(
            'id'     => 'DNSYJX_AR',
            'type'   => 'repeater',
            'title'  => 'DNS预解析地址',
            'after' => '对于某些情况而言开启能够提升访问速度,而禁用的话能节省每月100亿的DNS查询',
'dependency' => array( 'DNSYJX', '==', 'true' ),
            'fields' => array(
                array(
                    'id'    => 'DNSADDRESS',
                    'type'  => 'text',
                    'title' => '预解析地址'
                ),
            ),
        ),
        array(
            'id'       => 'CustomizationCode',
            'type'     => 'code_editor',
            'title'    => '顶部自定义代码',
            'subtitle' => '如百度Meta验证代码，均可以放在这里',
        ),
         array(
        'id'    => 'Menu',
        'type'  => 'textarea',
        'title' => '自定义导航',
        'after' => '可自由添加前台自定义导航，例子:<br>https://www.baidu.com|百度<br>https://www.qq.com|QQ<br>也就是导航链接|导航名，多个直接换行即可',
      ),
      array(
            'id'          => 'PageMenu',
            'type'        => 'select',
            'title'       => '导航栏页面输出选择',
            'after' => '选择集合下拉则将所有自定义页面集合为下拉列表，而横向排列则把所有自定义页面链接直接输出',
            'options'     => array('1' => '集合下拉',  '2' => '横向排列'),
            'default' => '1',
        ),
        array(
            'id'         => 'CategoryMenu',
            'type'       => 'switcher',
            'title'      => '导航栏显示下拉分类',
            'text_on'    => '显示',
            'text_off'   => '不显示',
            'text_width' => '100',
        ),
        array(
            'id'         => 'Login_hidden',
            'type'       => 'switcher',
            'title'      => '导航栏显示登录入口',
            'text_on'    => '显示',
            'text_off'   => '不显示',
            'text_width' => '100',
        ),
        
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '底部设置',
    'icon'   => 'fas fa-cube',
    'fields' => array(
    array(
        'id'    => 'IcpBa',
        'type'  => 'text',
        'title' => 'ICP备案号',
        'after' => '请填写您网站的ICP备案号,若无ICP备案请为空',
      ),
      array(
        'id'    => 'PoliceBa',
        'type'  => 'text',
        'title' => '公安备案号',
        'after' => '请填写您网站的公安备案号,若无公安备案请为空',
      ),
      array(
            'id'       => 'CustomizationFooterCode',
            'type'     => 'code_editor',
            'title'    => '底部自定义代码',
            'after' => '可放置网站统计代码等<br><font color=red>谨慎填写，仅需填写代码即可！</font>需注意语法，若语法错误可能会造成前台报错甚至组件动作失效！',
        ),
    array(
            'id'       => 'CustomizationFooterJsCode',
            'type'     => 'code_editor',
            'title'    => '底部自定义JS代码',
            'after' => '可放置自定义JS代码等<br><font color=red>谨慎填写，仅需填写代码即可！</font>需注意JS语法，若语法错误可能会造成前台报错甚至组件动作失效！',
        ),
        array(
            'id'         => 'load_Time',
            'type'       => 'switcher',
            'title'      => '显示页面加载时间',
            'text_on'    => '是',
            'text_off'   => '否',
            'text_width' => '100',
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '幻灯片设置',
    'icon'   => 'fas fa-building',
    'fields' => array(
      array(
            'id'      => 'Slidersss',
            'type'    => 'switcher',
            'title'       => '是否开启幻灯片功能',
            'default' => false,
        ),
         array(
            'id'      => 'SliderIndexs',
            'type'    => 'switcher',
            'title'       => '首页开启幻灯片',
            'default' => false,
            'subtitle' => '对象：首页',
            'dependency' => array( 'Slidersss', '==', 'true' ),
        ),
         array(
            'id'      => 'SliderOthers',
            'type'    => 'switcher',
            'title'       => '其他位置开启幻灯片',
            'default' => false,
            'subtitle' => '   对象:分类、标签、搜索、作者文章',
            'dependency' => array( 'Slidersss', '==', 'true' ),
        ),
      array(
            'id'     => 'slider__content',
            'type'   => 'group',
            'title'  => '幻灯片',
            'after' => '添加幻灯片需注意幻灯片图片务必为直链。',
'dependency' => array( 'Slidersss', '==', 'true' ),
            'fields' => array(
                array(
                    'id'    => 'slider__note',
                    'type'  => 'text',
                    'title' => '幻灯片备注',
                    'after'=>'可以备注下该幻灯片，仅后台可见'
                ),
                array(
                    'id'    => 'slider__pic',
                    'type'  => 'text',
                    'title' => '幻灯片图片链接',
                    'after'=>'图片链接务必为直链'
                ),
                array(
                    'id'    => 'slider__url',
                    'type'  => 'text',
                    'title' => '幻灯片跳转链接',
                    'after'=>'链接务必带http(s)://'
                ),
                array(
                    'id'    => 'slider__title',
                    'type'  => 'text',
                    'title' => '幻灯片标题',
                    'after' => '标题留空则不显示该幻灯片的字幕'
                ),
            ),
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '公告栏设置',
    'icon'   => 'fas fa-cogs',
    'fields' => array(
      array(
            'id'      => 'Popup',
            'type'    => 'switcher',
            'title'       => '是否开启网站公告栏',
            'subtitle' => '若开启公告栏，则网站右下角会出现公告栏，可填写要向访客展示的公告。',
            'default' => false,
        ),
        array(
        'id'    => 'PopupTitle',
        'type'  => 'text',
        'title' => '公告栏标题',
        'after' => '请填写公告栏标题，它将显示在公告栏顶部，不填写则不显示',
        'dependency' => array( 'Popup', '==', 'true' ),
      ),
        array(
        'id'    => 'PopupText',
        'type'  => 'textarea',
        'title' => '公告内容',
        'after' => '请填写公告内容，多个公告使用|间隔即可，支持HTML代码',
        'dependency' => array( 'Popup', '==', 'true' ),
      ),
      array(

            'id'      => 'PopupTitleClose',
            'type'    => 'switcher',
            'title'       => '是否显示公告顶栏',
            'subtitle' => '可选择是否显示公告顶栏，也就是标题栏。',
            'default' => false,
            'dependency' => array( 'Popup', '==', 'true' ),
        ),
      array(
            'id'      => 'PopupClose',
            'type'    => 'switcher',
            'title'       => '是否允许关闭公告栏',
            'subtitle' => '可选择是否允许关闭公告栏。',
            'default' => false,
            'dependency' => array( 'Popup', '==', 'true' ),
        ),
        array(
            'id'          => 'PopupAutoHide',
            'type'        => 'select',
            'title'       => '自动隐藏',
            'after' => '设置公告栏的自动隐藏',
            'options'     => array('0' => '禁用',  '1' => '全自动','2' => '自定义'),
            'default' => '0',
            'dependency' => array( 'Popup', '==', 'true' ),
        ),
        array(
        'id'    => 'PopupAutoHideSecond',
        'type'  => 'number',
        'title' => '几秒后自动隐藏',
        'subtitle' => '请填写几秒后自动隐藏',
        'dependency' => array( 'Popup|PopupAutoHide', '==|==', 'true|2' ),
      ),
       array(
            'id'          => 'PopupAutoClose',
            'type'        => 'select',
            'title'       => '自动关闭',
            'after' => '设置公告栏的自动关闭',
            'options'     => array('0' => '禁用',  '1' => '全自动','2' => '自定义'),
            'default' => '0',
            'dependency' => array( 'Popup', '==', 'true' ),
        ),
        array(
        'id'    => 'PopupAutoCloseSecond',
        'type'  => 'number',
        'title' => '几秒后自动关闭',
        'after' => '请填写几秒后自动关闭',
        'dependency' => array( 'Popup|PopupAutoClose', '==|==', 'true|2' ),
      ),
      array(
        'id'    => 'PopupWidth',
        'type'  => 'number',
        'title' => '公告栏宽度',
        'subtitle' => '填0则为自动宽度，非0则为自定义宽度',
        'dependency' => array( 'Popup', '==', 'true' ),
      ),
      array(
        'id'    => 'PopupHeight',
        'type'  => 'number',
        'title' => '公告栏高度',
        'subtitle' => '填0则为自动高度，非0则为自定义高度',
        'dependency' => array( 'Popup', '==', 'true' ),
      ),
      array(
        'id'    => 'PopupSpeed',
        'type'  => 'number',
        'title' => '公告栏滚动速度',
        'subtitle' => '填0则为不滚动，非0则为自定义滚动速度',
        'dependency' => array( 'Popup', '==', 'true' ),
      ),
      array(
            'id'          => 'PopupEffect',
            'type'        => 'select',
            'title'       => '公告栏展现效果',
            'after' => '设置公告栏的展现效果',
            'options'     => array('fading' => '淡化',  'zoom-in' => '放大','zoom-out' => '缩小','rotate-left' => '向左旋转','rotate-right' => '向右旋转','move-top' => '上移','move-right' => '右移','move-bottom' => '下移','move-left' => '左移','skew-top' => '倾斜-上','skew-right' => '倾斜-右','skew-bottom' => '倾斜-下','skew-left' => '倾斜-左','random' => '随机','shuffle' => '洗牌'),
            'default' => 'fading',
            'dependency' => array( 'Popup', '==', 'true' ),
        ),
    )
  ) );


  CSF::createSection( $prefix, array(
    'title'  => '友链设置',
    'icon'   => 'fas fa-gavel',
    'fields' => array(
      array(
            'id'      => 'FriendLinkChoose',
            'type'    => 'switcher',
            'title'       => '是否开启右侧友情链接栏',
            'subtitle' => '若选择开启，则站点右侧增加友情链接栏',
            'default' => false,
        ),
         array(
        'id'    => 'FriendLink',
        'type'  => 'textarea',
        'title' => '友链内容',
        'after' => '请填入友链内容,格式：友链名称|友链简介|友链地址，多个直接换行',
        'dependency' => array( 'FriendLinkChoose', '==', 'true' ),
      ),
      array(
            'id'          => 'FriendLink_place',
            'type'        => 'select',
            'title'       => '右侧友情链接显示场景',
            'after' => '针对SEO优化考虑，这里可自主选择右侧友情链接显示场景',
            'options'     => array('1' => '全局显示',  '2' => '仅首页显示'),
            'default' => '1',
            'dependency' => array( 'FriendLinkChoose', '==', 'true' ),
        ),
        array(
            'id'      => 'FriendLinkSubmit',
            'type'    => 'switcher',
            'title'       => '是否允许在独立友链页面自助提交友链',
            'after' => '<br><br>若为是，则独立友链页面将支持访客自助提交友链[仅当自定义模板选择友链[新]时本项有效。]',
            'default' => true,
        ),
        array(
            'id'      => 'FriendLinkLogomust',
            'type'    => 'switcher',
            'title'       => '自助提交友链LOGO图标是否必填',
            'after' => '<br><br>若为否，则独立友链页面提交友链时友链LOGO图标为非必填，并可以自定义设置一个默认LOGO图标[仅当自定义模板选择友链[新]时本项有效。]',
            'default' => true,
            'text_on'    => '是',
            'text_off'   => '否',
        ),
        array(
        'id'    => 'FriendLinkLogoDefault',
        'type'  => 'upload',
        'title' => '友链默认LOGO图标',
        'after' => '若设置友链LOGO图标为非必填，则可在本项填写默认LOGO图标地址或上传默认LOGO图标',
        'dependency' => array( 'FriendLinkLogomust', '==', 'false' ),
      ),
         array(
            'id'      => 'FriendLinkEmailmust',
            'type'    => 'switcher',
            'title'       => '自助提交友链联系邮箱是否必填',
            'after' => '<br><br>若为是，则独立友链页面提交友链时需要提交者填写邮箱[仅当自定义模板选择友链[新]时本项有效。]',
            'default' => false,
            'text_on'    => '是',
            'text_off'   => '否',
        ),
      array(
            'id'      => 'FriendLinkSubmitSendMail',
            'type'    => 'switcher',
            'title'       => '友链提交后是否发送邮件给博主',
            'after' => '<br><br>若为是，则在前台提交友链申请后系统将自动发送一封邮件给博主提醒进行审核[仅当自定义模板选择友链[新]本项有效，并需要您在SMTP设置中开启SMTP服务并配置SMTP信息。]',
            'default' => false,
            'text_on'    => '是',
            'text_off'   => '否',
        ),
        array(
            'id'      => 'FriendLinkAcceptSendMail',
            'type'    => 'switcher',
            'title'       => '友链审核后是否发送邮件给提交者',
            'after' => '<br><br>若为是，则当博主审核友链后将发送审核通过或者审核不通过的邮件给提交者[仅当自定义模板选择友链[新]且提交者邮件地址存在时本项有效，并需要您在SMTP设置中开启SMTP服务并配置SMTP信息。]',
            'default' => false,
            'text_on'    => '是',
            'text_off'   => '否',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>说明</strong><br> 以下友链操作针对独立友链页面。',
        ),
        array(
            'type'    => 'content',
            'content' => '<a id="createlink" class="button button-primary csf--button add">新增友链</a>',
        ),
array(
                'id'    => 'friendtab',
                'type'  => 'tabbed',
                'title' => '',
                'tabs'  => array(

                    array(
                        'title'  => '待审核',
                        'fields' => array(
                            array(
                    'type' =>'content',
                    'content' => '
                   <table class="ui celled table">
  <thead>
    <tr>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链名称</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链网址</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链图标</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链简介</font></font></th>
            <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系邮箱</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">状态</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">操作</font></font></th>
    </tr>
  </thead>
  <tbody id="waitingfl" style="word-break:break-word">
  
  </tbody>
</table>
<div class="waitingpagelist"></div>',
                ),
                            
                        ),
                    ),

                    array(
                        'title'  => '已通过',
                        'fields' => array(
                            array(
                    'type' =>'content',
                    'content' => '

                   <table class="ui celled table">
  <thead>
    <tr>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链名称</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链网址</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链图标</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链简介</font></font></th>
                  <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系邮箱</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">状态</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">操作</font></font></th>
    </tr>
  </thead>
  <tbody id="approvedfl" style="word-break:break-word">
  </tbody>
</table>
<div class="approvedpagelist"></div>',
                ),
                        ),
                    ),
array(
                        'title'  => '已驳回',
                        'fields' => array(
                            array(
                    'type' =>'content',
                    'content' => '

                   <table class="ui celled table">
  <thead>
    <tr>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链名称</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链网址</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链图标</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链简介</font></font></th>
    <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系邮箱</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">状态</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">操作</font></font></th>
    </tr>
  </thead>
  <tbody id="rejectfl" style="word-break:break-word">
  </tbody>
</table>
<div class="rejectpagelist"></div>',
                ),
                    ),

                ),
                
                array(
                    'title'  => '查询',
                        'fields' => array(
                            array(
                    'type' =>'content',
                    'content' => '
<div><input type="text" id="linksearch" placeholder="请输入关键词进行搜索" autocomplete="off" /></div>

                   <table class="ui celled table">
  <thead>
    <tr>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链名称</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链网址</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链图标</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">友链简介</font></font></th>
    <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系邮箱</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">状态</font></font></th>
      <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">操作</font></font></th>
    </tr>
  </thead>
  <tbody id="search" style="word-break:break-word">
  </tbody>
</table>
<div class="searchpagelist">
            </div>
',
                ),
                    ),

                ),
                
                
                ),
            ),
        
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => 'DIY设置',
    'icon'   => 'fas fa-inbox',
    'fields' => array(
      array(
            'id'      => 'Diy',
            'type'    => 'switcher',
            'title'       => 'DIY模式',
            'default' => false,
        ),
       array(
            'id'          => 'textType',
            'type'        => 'select',
            'title'       => '首页及其他输出文章页面简洁文字样式显示效果',
            'after' => '选择首页及其他输出文章页面简洁文字文字样式显示效果',
            'options'     => array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'),
            'default' => '0',
            'dependency' => array( 'Diy', '==', 'true' ),
        ), 
        array(
            'id'          => 'rightType',
            'type'        => 'select',
            'title'       => '侧边栏样式显示效果',
            'after' => '选择侧边栏样式显示效果',
            'options'     => array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'),
            'default' => '0',
            'dependency' => array( 'Diy', '==', 'true' ),
        ), 
        array(
            'id'          => 'postType',
            'type'        => 'select',
            'title'       => '文章页面样式显示效果',
            'after' => '选择文章页面样式显示效果',
            'options'     => array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'),
            'default' => '0',
            'dependency' => array( 'Diy', '==', 'true' ),
        ), 
        array(
            'id'          => 'commentType',
            'type'        => 'select',
            'title'       => '评论区页面样式显示效果',
            'after' => '选择评论区页面样式显示效果',
            'options'     => array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'),
            'default' => '0',
            'dependency' => array( 'Diy', '==', 'true' ),
        ), 
        array(
            'id'       => 'articleradius',
            'type'     => 'number',
            'title'    => '输出文章圆角值',
            'after' => '<br><br>请输入输出文章样式圆角值<br>输入数字即可，输入输出文章样式圆角值后前台首页及分类输出时将显示圆角，更加美观，本项为空时默认不启用',
            'unit'     => 'px',
            'dependency' => array( 'Diy', '==', 'true' ),
        ),
        array(
            'id'       => 'rightradius',
            'type'     => 'number',
            'title'    => '输出侧边栏样式圆角值',
            'after' => '<br><br>请输入输出侧边栏样式圆角值<br>输入数字即可，当样式不为无效果时，输入输出侧边栏样式圆角值后前台侧边栏输出时将显示圆角，更加美观，本项为空时默认不启用',
            'unit'     => 'px',
            'dependency' => array( 'Diy', '==', 'true' ),
        ),
        array(
            'id'       => 'postradius',
            'type'     => 'number',
            'title'    => '输出文章页面圆角值',
            'after' => '<br><br>请输入输出文章页面样式圆角值<br>输入数字即可，当样式不为无效果时，输入输出文章页面样式圆角值后前台文章页面输出时将显示圆角，更加美观，本项为空时默认不启用',
            'unit'     => 'px',
            'dependency' => array( 'Diy', '==', 'true' ),
        ),
        array(
            'id'       => 'commentradius',
            'type'     => 'number',
            'title'    => '输出评论区圆角值',
            'after' => '<br><br>请输入输出评论区样式圆角值<br>输入数字即可，当样式不为无效果时，输入输出评论区样式圆角值后前台文章页面评论区输出时将显示圆角，更加美观，本项为空时默认不启用',
            'unit'     => 'px',
            'dependency' => array( 'Diy', '==', 'true' ),
        ),
        
    )
  ) );
  $lazy_styles = array_map('basename', glob(dirname(__FILE__) . '/assets/images/loaders/*.svg'));
        $lazy_styles = array_combine($lazy_styles, $lazy_styles);
  CSF::createSection( $prefix, array(
    'title'  => '加载设置',
    'icon'   => 'fas fa-plus',
    'fields' => array(
      array(
            'id'      => 'Pjax',
            'type'    => 'switcher',
            'title'       => 'Pjax',
            'subtitle' => '若选择开启,则将同步启用NProgress效果',
            'default' => false,
        ),
        array(
            'id'       => 'CustomizationFooterJsPjaxCode',
            'type'     => 'code_editor',
            'title'    => '自定义Pjax回调代码',
            'after' => '<font color=red>谨慎填写，仅需填写代码即可！</font>需注意JS语法，若语法错误可能会造成前台报错甚至组件动作失效！',
            'dependency' => array( 'Pjax', '==', 'true' ),
        ),
        array(
            'id'      => 'Lazyload',
            'type'    => 'switcher',
            'title'       => '图片懒加载',
            'subtitle' => '开启后图片将以懒加载的形式展现，可设置选择懒加载过程中显示的加载图标',
            'default' => false,
        ),
        array(
            'id'          => 'Lazyload_style',
            'type'        => 'select',
            'title'       => '选择懒加载图标',
            'after' => '懒加载图标时指在图片加载过程中显示的图标，位置在主题目录/assets/images/loaders，可自行设置图标放入其中，即可在本项选择<br>主题默认内置svg加载图标可供选择。',
            'options'     => $lazy_styles,
            'default' => 'bars.svg',
            'dependency' => array( 'Lazyload', '==', '1' ),
        ), 
      array(
            'id'      => 'Compress',
            'type'    => 'switcher',
            'title'       => 'HTML压缩',
            'subtitle' => '开启后同步开启最大限度的GZIP压缩，能够加快网站访问',
            'default' => false,
        ),
        array(
            'id'      => 'Lightbox',
            'type'    => 'switcher',
            'title'       => '图片灯箱',
            'subtitle' => '使用图片灯箱效果听说有BUFF加成~',
            'default' => false,
        ),
        array(
            'id'      => 'CommentTyping',
            'type'    => 'switcher',
            'title'       => '打字效果',
            'subtitle' => '开启后在前台评论区打字就会出现小球浮现效果',
            'default' => false,
        ),
    )
  ) );
  $mail_html = '';
       $mail_api = Common::url('/action/' . BsCore_Plugin::$action, Options::alloc()->index).'?do=testMail';

        $mail_html .= '<a id="testmail" class="button button-primary csf--button">邮件发送测试</a>
        <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
	<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.js"></script>
        <script>
        document.getElementById("testmail").onclick = function(){
        $.post("'.$mail_api.'",function(data,status){
        json = JSON.parse(data);
switch(json.code)
{
case "1":
toastr.success(json.message);
break;
case "0":
toastr.warning(json.message);
break;
}
});
        };
        </script>
        
        ';
  
  CSF::createSection( $prefix, array(
    'title'  => '行为验证',
    'icon'   => 'fas fa-user-secret',
    'fields' => array(
      array(
            'id'          => 'VerifyChoose',
            'type'        => 'select',
            'title'       => '选择行为验证方式',
            'after' => '若选择关闭,则评论等关键区域将不进行安全验证',
            'options'     => array('1' => '开启普通算数加法验证', '11' => '开启普通算数减法验证', '2' => '开启Vaptcha验证','2-1' => '开启顶象验证', '22' => '开启拼图滑块验证','3' => '关闭行为验证'),
            'default' => '1',
        ), 
      array(
            'id'       => 'Verify22_Buttontext',
            'type'     => 'text',
            'title'    => '拼图滑块验证按钮文字',
            'after' => '请输入拼图滑块验证按钮文字，如人机验证',
            'default'     => '人机验证',
            'dependency' => array( 'VerifyChoose', '==', '22' ),
        ),
        array(
            'id'       => 'Verify22_Paneltitle',
            'type'     => 'text',
            'title'    => '拼图滑块验证面板标题',
            'after' => '请输入拼图滑块验证面板标题，如人机验证',
            'default'     => '人机验证',
            'dependency' => array( 'VerifyChoose', '==', '22' ),
        ),
        array(
            'id'       => 'Verify22_Paneldec',
            'type'     => 'text',
            'title'    => '拼图滑块验证面板操作提示文字',
            'after' => '请输入拼图滑块验证面板操作提示文字，如滑动滑块，使图片显示角度为正',
            'default'     => '使图片显示角度为正',
            'dependency' => array( 'VerifyChoose', '==', '22' ),
        ),
        array(
            'id'       => 'Verify22_Panelimg',
            'type'     => 'textarea',
            'title'    => '拼图滑块验证使用的图片',
            'after' => '请输入拼图滑块验证使用的图片直链,使用英文逗号分隔，如xxx.jpg,abc.png',
            'default'     => '/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t1.png,/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t2.png,/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t3.png',
            'dependency' => array( 'VerifyChoose', '==', '22' ),
        ),
        //Vaptcha
        array(
            'id'       => 'vid',
            'type'     => 'text',
            'title'    => 'VID',
            'after' => '验证单元vid',
            'dependency' => array( 'VerifyChoose', '==', '2' ),
        ),
        array(
            'id'       => 'vkey',
            'type'     => 'text',
            'title'    => 'VKEY',
            'after' => '验证单元key',
            'dependency' => array( 'VerifyChoose', '==', '2' ),
        ),
        array(
            'id'      => 'backendVerify_Vaptcha',
            'type'    => 'switcher',
            'title'       => '是否启用服务端二次验证',
            'after' => '<br><br>若启用则在评论者完成验证并提交评论后，系统自动将验证成功的Token与Vaptcha进行服务端二次验证，进一步加强安全性，但因为网络因素影响，可能会导致评论提交等待时间增加。',
            'default' => false,
            'dependency' => array( 'VerifyChoose', '==', '2' ),
        ),
        //顶象
        array(
            'id'       => 'dx_domain',
            'type'     => 'text',
            'title'    => '顶象API域名',
            'after' => '在顶象后台->应用管理页面顶部，apiServer即API域名。',
            'dependency' => array( 'VerifyChoose', '==', '2-1' ),
        ),
        array(
            'id'       => 'dx_appId',
            'type'     => 'text',
            'title'    => '顶象appId',
            'after' => '在顶象后台->应用管理页面可看到接入应用的appId',
            'dependency' => array( 'VerifyChoose', '==', '2-1' ),
        ),
        array(
            'id'       => 'dx_appSecret',
            'type'     => 'text',
            'title'    => '顶象appSecret',
            'after' => '在顶象后台->应用管理页面可看到接入应用的appSecret',
            'dependency' => array( 'VerifyChoose', '==', '2-1' ),
        ),
        array(
            'id'      => 'backendVerify_Dingxiang',
            'type'    => 'switcher',
            'title'       => '是否启用服务端二次验证',
            'after' => '<br><br>若启用则在评论者完成验证并提交评论后，系统自动将验证成功的Token与顶象进行服务端二次验证，进一步加强安全性，但因为网络因素影响，可能会导致评论提交等待时间增加。',
            'default' => false,
            'dependency' => array( 'VerifyChoose', '==', '2-1' ),
        ),
        
        array(
            'id'      => 'CCFirewalls',
            'type'    => 'switcher',
            'title'       => '简易CC防护',
            'subtitle' => '若选择开启,可能会存在误拦截!',
            'default' => false,
        ),
    )
  ) );
  $cache_html = '';
       $cache_api = Common::url('clean-cache', Options::alloc()->index);

        $cache_html .= '<a id="cleancache" class="button button-primary csf--button">清空缓存</a>
        <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
	<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.js"></script>
        <script>
        document.getElementById("cleancache").onclick = function(){
        $.get("'.$cache_api.'",function(data,status){
        json = JSON.parse(data);
switch(json.code)
{
case "1":
toastr.success(json.message);
break;
case "0":
toastr.warning(json.message);
break;
}
});
        };
        </script>
        
        ';
        
        CSF::createSection( $prefix, array(
    'title'  => '存储设置',
    'icon'   => 'fas fa-magic',
    'fields' => array(
        array(
            'id'          => 'bucket_choose',
            'type'        => 'select',
            'title'       => '文件存储方式',
            'after' => '选择您所上传文件的存储方式，默认为本地存储',
            'options'     => array('1' => '本地存储',  '2' => '腾讯云COS'),
            'default' => '1',
        ), 
        array(
            'id'          => 'bucket_secret_id',
            'type'        => 'text',
            'title'       => '腾讯云SecretId',
            'after' => '必填* 请前往<a target="_blank" href="https://console.cloud.tencent.com/capi">腾讯云控制台-个人API密钥</a> 获取您的SecretId',
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ), 
        array(
            'id'          => 'bucket_secret_key',
            'type'        => 'text',
            'title'       => '腾讯云SecretKey',
            'after' => '必填* 请前往<a target="_blank" href="https://console.cloud.tencent.com/capi">腾讯云控制台-个人API密钥</a> 获取您的SecretKey',
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ), 
        array(
            'id'          => 'bucket_region',
            'type'        => 'select',
            'title'       => 'COS所属地域',
            'after' => '必选* 选择您的腾讯云COS所属地域，请务必选择正确',
            'options'     => array(
          'ap-beijing' => _t('北京'),
          'ap-beijing-1' => _t('北京一区'),
          'ap-guangzhou' => _t('广州'),
          'ap-nanjing' => _t('南京'),
          'ap-shanghai' => _t('上海'),
          'ap-chengdu' => _t('成都'),
          'ap-chongqing' => _t('重庆'),
          'ap-shenzhen-fsi' => _t('深圳金融'),
          'ap-shanghai-fsi' => _t('上海金融'),
          'ap-beijing-fsi' => _t('北京金融'),
          'ap-hongkong' => _t('香港'),
          'ap-singapore' => _t('新加坡'),
          'ap-mumbai' => _t('孟买'),
          'ap-jakarta' => _t('雅加达'),
          'ap-seoul' => _t('首尔'),
          'ap-bangkok' => _t('曼谷'),
          'ap-tokyo' => _t('东京'),
          'na-toronto' => _t('多伦多'),
          'na-siliconvalley' => _t('硅谷'),
          'na-ashburn' => _t('弗吉尼亚'),
          'na-toronto' => _t('多伦多'),
          'sa-saopaulo' => _t('圣保罗'),
          'eu-frankfurt' => _t('法兰克福'),
          'eu-moscow' => _t('莫斯科'),
        ),
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ), 
        array(
            'id'          => 'bucket_name',
            'type'        => 'text',
            'title'       => '腾讯云COS存储桶名称',
            'after' => '必填* 格式为 xxxxx-xxxxxx  请前往<a target="_blank" href="https://console.cloud.tencent.com/cos/bucket">腾讯云COS页面</a> 获取',
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ), 
         array(
            'id'          => 'bucket_path',
            'type'        => 'text',
            'title'       => '腾讯云COS存储路径',
            'after' => '必填* 默认为 uploads，若非必要可不修改，路径最前面不加/',
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ), 
        array(
            'id'          => 'bucket_domain',
            'type'        => 'text',
            'title'       => '腾讯云COS访问域名',
            'after' => '留空则为腾讯云默认域名，如：https://xxxxx.cos.ap-beijing.myqcloud.com<br>若填写的为自定义CDN域名，请参考<a target="_blank" href="https://cloud.tencent.com/document/product/436/36637">文档</a><br>若填写的为自定义源站域名，请参考<a target="_blank" href="https://cloud.tencent.com/document/product/436/36638">文档</a><br><font color="red">要注意的一点是若填写的为自定义CDN域名或自定义源站域名，域名需以 https:// 或 https:// 开头</font>',
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ), 
        array(
            'id'      => 'bucket_sign',
            'type'    => 'switcher',
            'title'       => '签名对象链接',
            'subtitle' => '生成带有签名的对象链接，有效期10分钟，可有效防盗链，建议开启<br>须将存储桶对应路径的访问权限设置为<b>私有读写</b>才真正有效，可参考 <a target="_blank" href="https://cloud.tencent.com/document/product/436/13327">文档</a>',
            'default' => false,
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ),
        array(
            'id'      => 'bucket_sync',
            'type'    => 'switcher',
            'title'       => '本地云端同步删除',
            'subtitle' => '在文件管理删除文件时，是否同步删除COS上的对应文件',
            'default' => false,
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ),
        array(
            'id'      => 'bucket_localsave',
            'type'    => 'switcher',
            'title'       => '双重储存',
            'subtitle' => '在本地保存一份文件副本，这样的话会占用本地存储空间',
            'default' => false,
            'dependency' => array( 'bucket_choose', '==', '2' ),
        ),
        array(
            'id'      => 'bucket_localdelete',
            'type'    => 'switcher',
            'title'       => '删除时同步删除本地备份',
            'subtitle' => '在文件管理删除文件时，是否同步删除本地备份的对应文件',
            'default' => false,
            'dependency' => array( 'bucket_choose|bucket_localsave', '==|==', '2|true' ),
        ),
        ),
        ));
  CSF::createSection( $prefix, array(
    'title'  => '缓存设置',
    'icon'   => 'fas fa-car',
    'fields' => array(
      array(
            'id'      => 'Cache',
            'type'    => 'switcher',
            'title'       => '缓存功能',
            'subtitle' => '开启缓存功能后您需要建立一个目录用来存放缓存文件。',
            'default' => false,
        ),
        array(
            'id'          => 'Cache_choose',
            'type'        => 'select',
            'title'       => '缓存方式',
            'after' => '您可以自由选择需要的缓存方式',
            'options'     => array('1' => '文件缓存','memcached' => 'Memcached', 'redis' => 'Redis'),
            'default' => '1',
            'dependency' => array( 'Cache', '==', 'true' ),
        ),
        //File Cache
        array(
            'type'    => 'heading',
            'content' => '文件缓存设置',
            'dependency' => array( 'Cache|Cache_choose', '==|==', 'true|1' ),
        ),
        array(
            'id'       => 'cache_dir',
            'type'     => 'text',
            'title'    => '设置缓存目录',
            'after' => '/开头表示绝对路径,否则表示相对于usr开始的路径。注意,请自行确保目录可写,并且所在分区inode数量足够。<br>例如您填themes/bearsimple/cache/，就代表您要将缓存文件存在bearsimple中的cache目录，则您需要在bearsimple目录中建立cache目录，目录权限755即可。',
            'default'     => 'cache',
            'dependency' => array( 'Cache|Cache_choose', '==|==', 'true|1' ),
        ),
        array(
            'id'       => 'cache_timeout',
            'type'     => 'number',
            'title'    => '设置缓存时间',
            'subtitle' => '设置缓存的有效期，单位是秒。如果需要手动情况缓存，请手动删除缓存目录下的所有文件',
            'default'     => '3600',
            'unit'     => '秒',
            'dependency' => array( 'Cache|Cache_choose', '==|==', 'true|1' ),
        ),
        array(
            'type'    => 'heading',
            'content' => '缓存操作',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
                    'type' =>'content',
                    'content' => $cache_html,
                    'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
                ),
        //Memcached && Redis Cache
        array(
            'type'    => 'heading',
            'content' => 'Memcached缓存设置',
            'dependency' => array( 'Cache|Cache_choose', '==|==', 'true|memcached' ),
        ),
        array(
            'type'    => 'heading',
            'content' => 'Redis缓存设置',
            'dependency' => array( 'Cache|Cache_choose', '==|==', 'true|redis' ),
        ),
        array(
            'id'      => 'login',
            'type'    => 'radio',
            'title'   => '是否对已登录用户失效',
            'subtitle'=>'已经登录用户不会触发缓存策略',
            'inline'  => true,
            'options' => array('关闭', '开启'),
            'default' => 1,
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'      => 'enable_ssl',
            'type'    => 'radio',
            'title'   => '是否支持SSL',
            'inline'  => true,
            'options' => array('关闭', '开启'),
            'default' => '0',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'       => 'expire',
            'type'     => 'text',
            'title'    => '缓存过期时间',
            'after' => '86400 = 60s * 60m *24h，即一天的秒',
            'default'     => '86400',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'       => 'host',
            'type'     => 'text',
            'title'    => '主机地址',
            'after' => '主机地址，一般为127.0.0.1',
            'default'     => '127.0.0.1',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'       => 'port',
            'type'     => 'text',
            'title'    => '端口号',
            'after' => 'memcache(d)默认为11211，redis默认为6379，其他类型随意填写',
            'default'     => '11211',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'type'    => 'heading',
            'content' => '全局缓存',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'      => 'enable_gcache',
            'type'    => 'radio',
            'title'   => '是否开启全局缓存',
            'subtitle'=>'在开启全局缓存的情况下，该页面缓存选项有效',
            'inline'  => true,
            'options' => array('关闭', '开启'),
            'default' => '1',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'      => 'cache_page',
            'type'    => 'checkbox',
            'title'   => '需要缓存的页面',
            'subtitle' => '选择需要缓存的页面',
            'inline'  => true,
            'options' => array(
			'index' => '首页',
			'archive' => '归档',
			'post' => '文章',
			'attachment' => '附件',
			'category' => '分类',
			'tag' => '标签',
			'author' => '作者',
			'search' => '搜索',
			'feed' => 'feed',
			'page' => '页面'
		),
            'default' => array('index', 'post', 'search', 'page', 'author', 'tag'),
            'dependency' => array( 'Cache|Cache_choose|enable_gcache', '==|any|==', 'true|memcached,redis|1' ),
        ),
        array(
            'type'    => 'heading',
            'content' => '部分缓存',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
        array(
            'id'      => 'enable_markcache',
            'type'    => 'radio',
            'title'   => '是否开启markdown缓存',
            'subtitle'=>'在全局缓存命中失效的时候是否开启 markdown 部分缓存,
        选项关闭，则未命中均不缓存。选项开启后，在文章编辑界面通过 NOCACHE 标签来决定是否缓存当前文章，按钮已经集成了，插入标签就表示不缓存',
            'inline'  => true,
            'options' => array('关闭', '开启'),
            'default' => '0',
            'dependency' => array( 'Cache|Cache_choose', '==|any', 'true|memcached,redis' ),
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => 'SEO管理',
    'icon'   => 'fas fa-faucet',
    'fields' => array(
        array(
            'id'          => 'SiteMap',
            'type'        => 'select',
            'title'       => 'Sitemap网站地图',
            'after' => '开启后博客将生成sitemap<br>
         开启了伪静态后是xxx.com/sitemap.xml<br>
         没开启伪静态是xxx.com/index.php/sitemap.xml',
            'options'     => array(
            'close' => '关闭',
            '100' => '显示最新 100 条链接',
            '200' => '显示最新 200 条链接',
            '300' => '显示最新 300 条链接',
            '400' => '显示最新 400 条链接',
            '500' => '显示最新 500 条链接',
            '600' => '显示最新 600 条链接',
            '700' => '显示最新 700 条链接',
            '800' => '显示最新 800 条链接',
            '900' => '显示最新 900 条链接',
            '1000' => '显示最新 1000 条链接',
        ),
            'default' => 'close',
        ),
        array(
            'id'      => 'seo_push',
            'type'    => 'switcher',
            'title'       => '收录推送',
            'subtitle' => '开启后需配置推送信息<br>推送动作触发：<br>1、在发布文章后自动推送 <br>2、在访客访问文章时自动推送<br>目前暂时只支持百度自动推送，后续将增加其他搜索引擎的推送。',
            'default' => false,
            
        ),
        array(
                'id'    => 'seotabs',
                'type'  => 'tabbed',
                'title' => '',
                'dependency' => array( 'seo_push', '==', 'true' ),
                'tabs'  => array(

                    array(
                        'title'  => '百度推送',
                        'fields' => array(
                            array(
            'id'       => 'baidu_token',
            'type'     => 'text',
            'title'    => '百度推送接口调用地址',
            'after' => '位置：站长工具-普通收录-资源提交-API提交-接口调用地址<br>填写格式：http://data.zz.baidu.com/urls?site=https://www.baidu.com&token=xxxxxxxxxxx',
        ),
                            
                        ),
                    ),
                
                ),
            ),
            
        ),
        ));
  $styles = array_map('basename', glob(dirname(__FILE__) . '/modules/codehightlight/static/styles/*.css'));
        $styles = array_combine($styles, $styles);
  CSF::createSection( $prefix, array(
    'title'  => '模块管理',
    'icon'   => 'fas fa-leaf',
    'fields' => array(
      array(
            'type'    => 'heading',
            'content' => '文章优化模块',
        ),
        array(
            'id'          => 'Mermaid',
            'type'        => 'switcher',
            'title'       => 'Mermaid流程图',
            'subtitle' => '开启后前台对流程图进行格式转换',
            'default' => 'false',
        ), 
        array(
            'id'          => 'MathJax',
            'type'        => 'switcher',
            'title'       => 'MathJax数学公式',
            'subtitle' => '开启后前台对数学公式进行格式转换',
            'default' => 'false',
        ), 
        array(
            'id'          => 'Codehightlight',
            'type'        => 'select',
            'title'       => '代码高亮',
            'after' => '开启后前台对代码显示高亮',
            'options'     => array('1' => '是',  '2' => '否'),
            'default' => '2',
        ), 

        array(
            'id'          => 'code_style',
            'type'        => 'select',
            'title'       => '选择高亮主题风格',
            'after' => '高亮主题风格文件在/usr/themes/bearsimple/modules/codehightlight/static/style中，您可以自行设计样式放入该目录,即可在本项选择',
            'options'     => $styles,
            'default' => 'GrayMac.css',
            'dependency' => array( 'Codehightlight', '==', '1' ),
        ), 
        array(
            'id'          => 'showLineNumber',
            'type'        => 'select',
            'title'       => '显示行号',
            'after' => '是否在代码左侧显示行号',
            'options'     => array('1' => '是',  '2' => '否'),
            'default' => '1',
             'dependency' => array( 'Codehightlight', '==', '1' ),
        ), 
        array(
            'id'          => 'Editors',
            'type'        => 'select',
            'title'       => '编辑器优化',
            'after' => '若选择开启,则编辑文件、页面的时候将替换官方编辑器，更换为更加美观的编辑器。',
            'options'     => array('1' => '开启',  '2' => '关闭'),
            'default' => '2',
        ), 
        array(
            'id'      => 'EditorsAutosave',
            'type'    => 'checkbox',
            'title'   => '编辑器自动保存方式选择',
            'after' => '自动保存支持两种方式，两种方式可同时开启不受影响，全都不选代表不开启自动保存<br>第一种即为浏览器保存，文章在还没点击提交的情况下均保存在浏览器中，点击其他文章，先前文章的内容仍会直接覆盖到当前文章。第二种是保存为草稿，编辑器在每隔十五秒会将文章保存为草稿。',
            'inline'  => true,
            'options' => array(
                '1' => '浏览器自动保存',
                '11' => '自动保存为草稿',
            ),
            'dependency' => array( 'Editors', '==', '1' ),
        ),
      array(
            'type'    => 'heading',
            'content' => '我的书架模块',
        ),
        array(
            'type'    => 'subheading',
            'content' => '您可以设置您自己的书架，哪些看完的，哪些准备要看的<br>
当然，您要想前台能看到的话必须新建一个独立页面，并将自定义模板选择我的书架',
        ),
        array(
            'id'       => 'douban_note',
            'type'     => 'text',
            'title'    => '书架温馨提示',
            'after' => '填写书架温馨提示，将显示在书架上方',
        ),
        array(
            'id'       => 'douban_tag',
            'type'     => 'text',
            'title'    => '书架标签',
            'after' => '填写书架标签，即归纳，例如 看完的书,准备要看的书，多个标签用英文逗号分隔，目前最多允许三个标签，单个标签字数不宜过多，建议三四个字即可',
        ),
        array(
            'id'          => 'douban_rating',
            'type'        => 'select',
            'title'       => '是否开启评星',
            'after' => '若开启评星，前台书架独立页面每本书的作者下都会显示星星样式，若要对书籍评星，则将原本的例如:书籍ID,书籍ID  修改为例如:书籍ID*4,书籍ID*5，也就是在每本书ID的后面加上*和评星的星星颗数，最高五颗星。',
            'options'     => array('1' => '否',  '2' => '是'),
            'default' => '1',
        ), 
        array(
            'id'       => 'douban_book1',
            'type'     => 'textarea',
            'title'    => '第一个标签对应的豆瓣图书ID',
            'after' => '在此填写豆瓣图书中的图书ID，多本书使用英文逗号分隔，他将显示在前台我的书架页面中的第一个书架标签内<br>评星使用*分隔，例如：图书ID*5，最高五颗星',
        ),
        array(
            'id'       => 'douban_book2',
            'type'     => 'textarea',
            'title'    => '第二个标签对应的豆瓣图书ID',
            'after' => '在此填写豆瓣图书中的图书ID，多本书使用英文逗号分隔，他将显示在前台我的书架页面中的第二个书架标签内<br>评星使用*分隔，例如：图书ID*5，最高五颗星',
        ),
        array(
            'id'       => 'douban_book3',
            'type'     => 'textarea',
            'title'    => '第三个标签对应的豆瓣图书ID',
            'after' => '在此填写豆瓣图书中的图书ID，多本书使用英文逗号分隔，他将显示在前台我的书架页面中的第三个书架标签内<br>评星使用*分隔，例如：图书ID*5，最高五颗星',
        ),
        
        array(
            'type'    => 'heading',
            'content' => '我的追剧模块',
        ),
        array(
            'type'    => 'subheading',
            'content' => '您可以设置您自己的追剧，哪些看完的，哪些准备要看的<br>
当然，您要想前台能看到的话必须新建一个独立页面，并将自定义模板选择我的追剧',
        ),
        array(
            'id'       => 'douban_movie_note',
            'type'     => 'text',
            'title'    => '追剧温馨提示',
            'after' => '填写追剧温馨提示，将显示在追剧上方',
        ),
        array(
            'id'       => 'douban_movie_tag',
            'type'     => 'text',
            'title'    => '追剧标签',
            'after' => '填写追剧标签，即归纳，例如 看完的电影,准备要看的电影，多个标签用英文逗号分隔，目前最多允许三个标签，单个标签字数不宜过多，建议三四个字即可',
        ),
        array(
            'id'          => 'douban_movie_rating',
            'type'        => 'select',
            'title'       => '是否开启评星',
            'after' => '若开启评星，前台追剧独立页面每部剧的简介下都会显示星星样式，若要对电影电视剧评星，则将原本的例如:电影ID,电影ID  修改为例如:电影ID*4,电影ID*5，也就是在每部剧ID的后面加上*和评星的星星颗数，最高五颗星。',
            'options'     => array('1' => '否',  '2' => '是'),
            'default' => '1',
        ), 
        array(
            'id'       => 'douban_movie1',
            'type'     => 'textarea',
            'title'    => '第一个标签对应的豆瓣电影ID',
            'after' => '在此填写豆瓣电影中的电影ID，多部电影使用英文逗号分隔，他将显示在前台我的追剧页面中的第一个追剧标签内<br>评星使用*分隔，例如：电影ID*5，最高五颗星',
        ),
        array(
            'id'       => 'douban_movie2',
            'type'     => 'textarea',
            'title'    => '第二个标签对应的豆瓣电影ID',
            'after' => '在此填写豆瓣电影中的电影ID，多部电影使用英文逗号分隔，他将显示在前台我的追剧页面中的第二个追剧标签内<br>评星使用*分隔，例如：电影ID*5，最高五颗',
        ),
        array(
            'id'       => 'douban_movie3',
            'type'     => 'textarea',
            'title'    => '第三个标签对应的豆瓣电影ID',
            'after' => '在此填写豆瓣电影中的电影ID，多部电影使用英文逗号分隔，他将显示在前台我的追剧页面中的第三个追剧标签内<br>评星使用*分隔，例如：电影ID*5，最高五颗',
        ),
        
        
        array(
            'type'    => 'heading',
            'content' => '我的音乐歌单模块',
        ),
        array(
            'type'    => 'subheading',
            'content' => '您可以设置您自己的音乐歌单<br>
当然，您要想前台能看到的话必须新建一个独立页面，并将自定义模板选择我的音乐歌单',
        ),
                array(
            'id'       => 'douban_music_note',
            'type'     => 'text',
            'title'    => '音乐歌单温馨提示',
            'after' => '填写音乐歌单温馨提示，将显示在音乐库上方',
        ),
        array(
            'id'       => 'douban_music_tag',
            'type'     => 'text',
            'title'    => '音乐歌单标签',
            'after' => '填写音乐歌单标签，即归纳，例如 好听的音乐,不好听的音乐，多个标签用英文逗号分隔，目前最多允许三个标签，单个标签字数不宜过多，建议三四个字即可',
        ),
        array(
            'id'          => 'douban_music_rating',
            'type'        => 'select',
            'title'       => '是否开启评星',
            'after' => '若开启评星，前台歌单独立页面每首歌曲的简介下都会显示星星样式，若要对歌曲评星，则将原本的例如:歌曲ID,歌曲ID  修改为例如:歌曲ID*4,歌曲ID*5，也就是在每首歌曲ID的后面加上*和评星的星星颗数，最高五颗星。',
            'options'     => array('1' => '否',  '2' => '是'),
            'default' => '1',
        ), 
        array(
            'id'       => 'douban_music1',
            'type'     => 'textarea',
            'title'    => '第一个标签对应的豆瓣音乐ID',
            'after' => '在此填写豆瓣音乐中的音乐ID，多首音乐使用英文逗号分隔，他将显示在前台我的音乐歌单页面中的第一个音乐歌单标签内<br>评星使用*分隔，例如：音乐ID*5，最高五颗星',
        ),
        array(
            'id'       => 'douban_music2',
            'type'     => 'textarea',
            'title'    => '第二个标签对应的豆瓣音乐ID',
            'after' => '在此填写豆瓣音乐中的音乐ID，多首音乐使用英文逗号分隔，他将显示在前台我的音乐歌单页面中的第二个音乐歌单标签内<br>评星使用*分隔，例如：音乐ID*5，最高五颗星',
        ),
        array(
            'id'       => 'douban_music3',
            'type'     => 'textarea',
            'title'    => '第三个标签对应的豆瓣音乐ID',
            'after' => '在此填写豆瓣音乐中的音乐ID，多首音乐使用英文逗号分隔，他将显示在前台我的音乐歌单页面中的第三个音乐歌单标签内<br>评星使用*分隔，例如：音乐ID*5，最高五颗星',
        ),
        
        array(
            'type'    => 'heading',
            'content' => '我的追番模块',
        ),
        array(
            'type'    => 'subheading',
            'content' => '您需在下方填写您的Bilibili账户UID并且在空间设置中开启“公开我的追番”功能<br>
当然，您要想前台能看到的话必须新建一个独立页面，并将自定义模板选择我的追番',
        ),
        array(
            'id'       => 'bilibili_note',
            'type'     => 'text',
            'title'    => '追番温馨提示',
            'after' => '填写追番温馨提示，将显示在追番上方',
        ),
        array(
            'id'       => 'bilibili_accountid',
            'type'     => 'text',
            'title'    => 'B站账户UID',
            'after' => '填写B站账户UID，并且在空间设置中开启“公开我的追番”功能，系统将自动获取您所有的追番记录',
        ),
        array(
            'type'    => 'heading',
            'content' => '我的Github仓库模块',
        ),
        array(
            'type'    => 'subheading',
            'content' => '您需在下方填写您的Github账号<br>
仓库显示该Github账号下的所有项目，当然，您要想前台能看到的话必须新建一个独立页面，并将自定义模板选择我的Github仓库',
        ),
        array(
            'id'       => 'github_note',
            'type'     => 'text',
            'title'    => 'Github仓库温馨提示',
            'after' => '填写Github仓库温馨提示，将显示在仓库上方',
        ),
        array(
            'id'       => 'github_accountid',
            'type'     => 'text',
            'title'    => 'Github账号',
            'after' => '填写Github账号，系统将自动获取您账户下所有的自创项目',
        ),
        array(
            'type'    => 'heading',
            'content' => '关于我模块',
        ),
        array(
            'type'    => 'subheading',
            'content' => '您需在下方填写个人相关信息，当然，您要想前台能看到的话必须新建一个独立页面，并将自定义模板选择关于我',
        ),
        array(
            'id'       => 'aboutme_background',
            'type'    => 'upload',

            'title'    => '顶部背景',
            'after' => '上传顶部背景图片，该图片将虚化后作为顶部背景显示',
        ),
        array(
            'id'       => 'aboutme_avatar',
            'type'    => 'upload',

            'title'    => '顶部头像',
            'after' => '上传您的头像，将显示在顶部居中位置',
        ),
        array(
            'id'       => 'aboutme_name',
            'type'     => 'text',
            'title'    => '名字',
            'after' => '填写您在自我介绍中的名字',
        ),
        array(
            'id'       => 'aboutme_say',
            'type'     => 'textarea',
            'title'    => '自我介绍',
            'after' => '填写您的自我介绍，不求感人肺腑，只求看得过去～',
        ),
        array(
            'id'       => 'aboutme_job',
            'type'     => 'text',
            'title'    => '职业或者给自己颁发个头衔',
            'after' => '填写您的职业或者头衔名',
        ),
        array(
            'id'       => 'aboutme_lc',
            'type'     => 'textarea',
            'title'    => '历程',
            'after' => '填写您自己的历程，格式<br>[timeline year="年份"]<br>[title]历程标题[/title]<br>[desc]历程内容[/desc]<br>[/timeline]<br>多个历程换行即可',
        ),
        array(
            'id'       => 'aboutme_qq',
            'type'     => 'text',
            'title'    => '您的QQ',
            'after' => '填写您的QQ账号，不填不显示',
        ),
        array(
            'id'       => 'aboutme_weibo',
            'type'     => 'text',
            'title'    => '您的微博',
            'after' => '填写您的微博账号，不填不显示',
        ),
        array(
            'id'       => 'aboutme_weixin',
            'type'     => 'text',
            'title'    => '您的微信',
            'after' => '填写您的微信号，不填不显示',
        ),
        array(
            'id'       => 'aboutme_mail',
            'type'     => 'text',
            'title'    => '您的邮箱',
            'after' => '填写您的邮箱地址，不填不显示',
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '打赏设置',
    'icon'   => 'fas fa-history',
    'fields' => array(
      array(
            'id'      => 'RewardOpen',
            'type'    => 'switcher',
            'title'       => '打赏功能',
            'subtitle' => '若选择开启，则文章底部都将出现打赏按钮。',
            'default' => false,
        ),
        array(
            'id'      => 'RewardOpenPaypal',
            'type'    => 'switcher',
            'title'       => 'Paypal打赏',
            'subtitle' => '若选择开启，则打赏按钮将增加Paypal',
            'default' => false,
            'dependency' => array( 'RewardOpen', '==', 'true' ),
        ),
        array(
            'id'       => 'RewardOpenPaypalText',
            'type'     => 'text',
            'title'    => '您的Paypal打赏链接',
            'after' => '请输入您的Paypal打赏链接',
            'dependency' => array( 'RewardOpen|RewardOpenPaypal', '==|==', 'true|true' ),
        ),
        array(
            'id'      => 'RewardOpenAlipay',
            'type'    => 'switcher',
            'title'       => '支付宝打赏',
            'subtitle' => '若选择开启，则打赏按钮将增加支付宝',
            'default' => false,
            'dependency' => array( 'RewardOpen', '==', 'true' ),
        ),
        array(
            'id'       => 'RewardOpenAlipayText',
            'type'    => 'upload',

            'title'    => '您的支付宝打赏图片二维码',
            'after' => '请上传您的支付宝打赏图片二维码',
            'dependency' => array( 'RewardOpen|RewardOpenAlipay', '==|==', 'true|true' ),
        ),
        array(
            'id'      => 'RewardOpenWechat',
            'type'    => 'switcher',
            'title'       => '微信打赏',
            'subtitle' => '若选择开启，则打赏按钮将增加微信',
            'default' => false,
            'dependency' => array( 'RewardOpen', '==', 'true' ),
        ),
        array(
            'id'       => 'RewardOpenWechatText',
            'type'    => 'upload',
            'title'    => '您的微信打赏图片二维码',
            'after' => '请上传您的微信打赏图片二维码',
            'dependency' => array( 'RewardOpen|RewardOpenWechat', '==|==', 'true|true' ),
        ),
        ),
  ) );
    
  CSF::createSection( $prefix, array(
    'title'  => '评论设置',
    'icon'   => 'fas fa-comment',
    'fields' => array(
      
        array(
            'id'      => 'Emoji',
            'type'    => 'switcher',
            'title'       => '评论表情',
            'default' => false,
            'subtitle'=>'若开启评论表情，则前台文章评论区将显示表情按钮'
        ),


        array(
            'id'      => 'Comment_like',
            'type'    => 'switcher',
            'title'       => '评论是否开启点赞',
            'default' => false,
            'subtitle'=>'开启点赞后评论区每条评论都将显示点赞按钮，<font color=red>本项应用范围包含时光机的动态</font>'
        ),
        array(
            'id'      => 'Comment_useragent',
            'type'    => 'switcher',
            'title'       => '评论是否显示UserAgent',
            'default' => false,
            'subtitle'=>'开启后将显示评论者使用的浏览器和操作系统图标，<font color=red>本项应用范围包含时光机的动态</font>'
        ),
        array(
            'id'      => 'CommentClose',
            'type'    => 'switcher',
            'title'       => '文章评论全局开关',
            'default' => true,
            'subtitle'=>'若为禁用，则网站全局评论功能都将关闭'
        ),
        array(
            'id'      => 'Comment_ipget',
            'type'    => 'switcher',
            'title'       => '评论是否显示IP属地',
            'default' => false,
            'subtitle'=>'若开启，则评论区每个评论者都将显示IP属地。'
        ),
        array(
            'id'      => 'Comment_showmail',
            'type'    => 'switcher',
            'title'       => '当邮箱非必填时是否隐藏邮箱输入框',
            'default' => false,
            'subtitle'=>'若开启，则评论区隐藏邮箱输入框，需要注意的是当邮箱设置非必填时系统会自动为没填写邮箱的评论者自动生成一个邮箱，以便回复可见可正常使用。'
        ),
        array(
            'id'      => 'Comment_private',
            'type'    => 'switcher',
            'title'       => '是否启用私密评论',
            'default' => false,
            'subtitle'=>'若开启，则评论区允许提交私密评论，仅登录用户和评论双方可见。'
        ),
        //评论电邮通知
        array(
            'type'    => 'heading',
            'content' => '评论电邮通知设置',
        ),
        array(
            'type'    => 'subheading',
            'content' => '主题已内置评论电邮通知功能，您可以通过开启该功能实现评论后邮件推送<font color=red>[在此之前您需要在SMTP设置中开启SMTP服务并填写SMTP信息]</font>',
        ),
        array(
            'id'      => 'CommentNotify__Open',
            'type'    => 'switcher',
            'title'       => '评论电邮通知',
            'default' => false,
            'subtitle'=>'若选择开启，则评论区的评论回复动作都可以通过邮件形式推送。',
        ),
        array(
            'id'       => 'CommentNotify__AcceptMailAddress',
            'type'     => 'text',
            'title'    => '接收邮件的地址',
            'after' => '接收邮件的地址,如为空则使用文章作者个人设置中的邮件地址',
            'dependency' => array( 'CommentNotify__Open', '==', 'true' ),
        ),
        array(
            'id'       => 'CommentNotify__TemplateContact',
            'type'     => 'text',
            'title'    => '模板中“联系我”的邮件地址',
            'after' => '联系我用的邮件地址,如为空则使用文章作者个人设置中的邮件地址',
            'dependency' => array( 'CommentNotify__Open', '==', 'true' ),
        ),
        array(
            'id'      => 'CommentNotify__NotifySetting',
            'type'    => 'checkbox',
            'title'   => '提醒设置',
            'inline'  => true,
            'options' => array('approved' => '提醒已通过评论','waiting' => '提醒待审核评论','spam' => '提醒垃圾评论'),
            'subtitle'=>'该选项仅针对博主，访客只发送已通过的评论。',
            'default' => '1',
            'dependency' => array( 'CommentNotify__Open', '==', 'true' ),
        ),
        array(
            'id'      => 'CommentNotify__OtherSetting',
            'type'    => 'checkbox',
            'title'   => '其他设置',
            'options' => array('1' => '有评论及回复时，发邮件通知博主','2' => '评论被回复时，发邮件通知评论者','3' => '自己回复自己的评论时，发邮件通知。(同时针对博主和访客)','4' => '记录发送日志'),
            'subtitle'=>'根据自身实际情况进行勾选，若勾选记录发送日志，日志文件在<code style="word-break:break-all">/usr/plugins/BsCore/log/</code>，当发送邮件较多时文件体积也会随之增大。',
            'default' => '1',
            'dependency' => array( 'CommentNotify__Open', '==', 'true' ),
        ),
        array(
            'id'       => 'CommentNotify__Author',
            'type'     => 'text',
            'title'    => '博主接收邮件标题',
            'after' => '{title}为可调用变量，您可以自定义博主接收邮件时的邮件标题',
            'default'=> '[{title}] 一文有新的评论',
            'dependency' => array( 'CommentNotify__Open', '==', 'true' ),
        ),
        array(
            'id'       => 'CommentNotify__Reader',
            'type'     => 'text',
            'title'    => '访客接收邮件标题',
            'after' => '{title}为可调用变量，您可以自定义访客接收邮件时的邮件标题',
            'default'=> '您在 [{title}] 的评论有了回复',
            'dependency' => array( 'CommentNotify__Open', '==', 'true' ),
        ),
        array(
            'type'    => 'heading',
            'content' => '评论过滤设置',
        ),
        array(
            'type'    => 'subheading',
            'content' => '默认强制性过滤全空格评论、包含XSS危险内容评论，其余需过滤内容您可以通过开启评论过滤高级设置进行设置。',
        ),
        array(
            'id'      => 'BearSpam_Pro',
            'type'    => 'switcher',
            'title'       => '评论过滤高级设置',
            'default' => false,
            'subtitle'=>'您可以通过开启高级设置对评论区的评论提交做更深层次的过滤。'
        ),
        array(
            'id'       => 'BearSpam_IP',
            'type'     => 'textarea',
            'title'    => '过滤IP',
            'after' => '多条IP请用换行符隔开<br />支持用*号匹配IP段，如：192.168.*.*',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_EMAIL',
            'type'     => 'textarea',
            'title'    => '过滤邮箱',
            'after' => '多个邮箱请用换行符隔开<br />可以是邮箱的全部，或者邮箱部分关键词',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_URL',
            'type'     => 'textarea',
            'title'    => '过滤网址',
            'after' => '多个网址请用换行符隔开<br />可以是网址的全部，或者网址部分关键词。如果网址为空，该项不会起作用',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_ArticleTitle',
            'type'     => 'select',
            'title'    => '过滤含有文章标题的评论',
            'options'  => array('1' => '是',  '2' => '否'),
            'after' => '根据研究表明机器人发表的内容可能含有评论文章的标题',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAME',
            'type'     => 'textarea',
            'title'    => '过滤昵称',
            'after' => '如果评论发布者的昵称含有该关键词，将执行该操作，多个请直接换行',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAMEMIN',
            'type'     => 'number',
            'title'    => '昵称允许的最短长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的昵称小于该最短长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAMEMAX',
            'type'     => 'number',
            'title'    => '昵称允许的最长长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的昵称大于该最长长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_NAMEURL',
            'type'     => 'select',
            'title'    => '过滤昵称为网址的评论',
            'options'  => array('1' => '是',  '2' => '否'),
            'after' => '根据研究表明机器人发表的评论，昵称很有可能为网址',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_Chinese',
            'type'     => 'select',
            'title'    => '过滤不包含中文的评论',
            'options'  => array('1' => '是',  '2' => '否'),
            'after' => '当评论内容中没有中文时进行拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_MIN',
            'type'     => 'number',
            'title'    => '评论内容允许的最短长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的评论内容小于该最短长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_MAX',
            'type'     => 'number',
            'title'    => '评论内容允许的最长长度',
            'unit'     => '个字',
            'subtitle' => '如果评论发布者的评论内容大于该最长长度将拦截',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
        array(
            'id'       => 'BearSpam_Words',
            'type'     => 'textarea',
            'title'    => '过滤敏感词',
            'after' => '多个词汇请用换行符隔开',
            'dependency' => array( 'BearSpam_Pro', '==', 'true' ),
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => 'SMTP设置',
    'icon'   => 'far fa-envelope',
    'fields' => array(
        array(
            'id'      => 'Smtp_open',
            'type'    => 'switcher',
            'title'       => '是否启用SMTP服务',
            'after' => '<br><br>若启用则全局开启SMTP服务，该服务用于评论电邮通知、友链提交审核通知等。',
            'default' => false,
        ),
         array(
            'id'      => 'CommentNotify__testmail',
            'type'    => 'content',
            'title'       => '邮件发送测试',
            'content'=>$mail_html,
            'dependency' => array( 'Smtp_open', '==', 'true' ),
            
        ),
        array(
            'id'      => 'CommentNotify__Sendway',
            'type'    => 'radio',
            'title'   => '发信方式',
            'subtitle'=>'请选择发信方式，若SMTP方式发信失败则使用SendMail()',
            'inline'  => true,
            'options' => array('smtp'=> 'SMTP', 'sendmail'=> 'SendMail()',),
            'default' => 'smtp',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
         array(
            'id'       => 'CommentNotify__Address',
            'type'     => 'text',
            'title'    => '发信服务器地址',
            'after' => '请输入发信服务器地址，如smtp.qq.com',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        array(
            'id'       => 'CommentNotify__Port',
            'type'     => 'text',
            'title'    => '发信服务器端口',
            'after' => '请输入发信服务器端口，也就是SMTP服务端口，一般为465或587',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        array(
            'id'       => 'CommentNotify__Username',
            'type'     => 'text',
            'title'    => '发信邮箱账号',
            'after' => '请输入发信邮箱账号，也就是SMTP账号，一般就是邮箱地址，如xxx@xxx.com',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        array(
            'id'       => 'CommentNotify__Password',
            'type'     => 'text',
            'title'    => '发信邮箱密码',
            'after' => '请输入发信邮箱密码，也就是SMTP密码，一般就是邮箱密码，若QQ邮箱则为授权码',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        array(
            'id'      => 'CommentNotify__Verify',
            'type'    => 'checkbox',
            'title'   => '发信验证',
            'inline'  => true,
            'options' => array('true' => '服务器需要验证'),
            'subtitle'=>'一般情况下都是勾选的。',
            'default' => 'true',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        array(
            'id'      => 'CommentNotify__VerifyWay',
            'type'    => 'radio',
            'title'   => '验证方式',
            'subtitle'=>'请选择发信验证方式',
            'inline'  => true,
            'options' => array('ssl'=> 'SSL加密验证', 'tls'=> 'TLS加密验证', 'none'=> '无验证'),
            'default' => 'ssl',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        
        array(
            'id'       => 'CommentNotify__SenderName',
            'type'     => 'text',
            'title'    => '发信人名称',
            'after' => '发信人名称，留空则使用博客标题',
            'dependency' => array( 'Smtp_open', '==', 'true' ),
        ),
        )
  ) );
  Typecho_Widget::widget('Widget_Stat')->to($stat);
  CSF::createSection( $prefix, array(
    'title'  => '文章设置',
    'icon'   => 'fas fa-puzzle-piece',
    'fields' => array(
      array(
            'id'      => 'Share',
            'type'    => 'switcher',
            'title'       => '第三方分享',
            'default' => false,
            'subtitle'=>'若选择开启,则文章页面都将显示第三方分享按钮，可自定义选择显示哪个。'
        ),
        array(
            'id'      => 'Shares',
            'type'    => 'checkbox',
            'title'   => '选择要显示的第三方分享途径',
            'inline'  => true,
            'options' => array('qq' => 'QQ',  'qzone' => 'QQ空间','weibo' => '微博','facebook' => 'Facebook','twitter' => 'Twitter','google' => 'Google','linkedin' => 'Linkedin','wechat'=> '微信'),
            'dependency' => array( 'Share', '==', 'true' ),
        ),
        array(
            'id'      => 'Scroll',
            'type'    => 'switcher',
            'title'       => '文章目录树',
            'default' => false,
            'subtitle'=>'<a style="color:red">实验性功能,若前台访问出现报错请关闭!</a>若选择开启,则文章页面自动识别h2-h6标签，当存在时自动生成目录树。'
        ),
        array(
            'id'      => 'Like',
            'type'    => 'switcher',
            'title'       => '文章点赞',
            'default' => false,
            'subtitle'=>'选择开启则文章下方显示点赞按钮'
        ),
        array(
            'id'      => 'Readmode',
            'type'    => 'switcher',
            'title'       => '文章阅读模式',
            'default' => false,
            'subtitle'=>'选择开启则文章显示阅读模式入口，给予读者一个纯净的阅读体验'
        ),
        array(
            'id'      => 'pageContent',
            'type'    => 'switcher',
            'title'       => '文章分页模式',
            'default' => false,
            'subtitle'=>'选择开启则文章内容适当处插入----------后进行内容分页，需要注意的是开启文章分页模式会影响SEO，请谨慎开启!'
        ),
        array(
            'id'      => 'infinite_scroll',
            'type'    => 'switcher',
            'title'       => '文章无限加载模式',
            'default' => false,
            'subtitle'=>'开启后文章列表输出页面的分页将替换为无限加载按钮，点击按钮将继续加载后面的文章。'
        ),

        array(
            'id'       => 'infinite_pageSize',
            'type'     => 'spinner',
            'title'    => '文章每一次的加载篇数',
            'subtitle' => '您目前的文章总数为<font color="red">'.$stat->publishedPostsNum.'</font>篇，加载篇数不可超过或等于文章总数。',
            'max'      => $stat->publishedPostsNum - 1,
            'min'      => 1,
            'step'     => 1,
            'default'  => Helper::options()->pageSize,
            'dependency' => array( 'infinite_scroll', '==', 'true' ),
        ),
        array(
            'id'      => 'history_Today',
            'type'    => 'switcher',
            'title'       => '那年今日',
            'default' => false,
            'subtitle'=>'开启后文章页面会出现那年今日组件，显示历史上的今天或在发布时间后面的年份同月同日所发的文章，当无文章时自动隐藏[仅文章页面，独立页面不显示]。'
        ),
        array(
            'id'       => 'history_Today_Limit',
            'type'     => 'spinner',
            'title'    => '那年今日文章篇数',
            'subtitle' => '可限制那年今日所显示的文章篇数，默认为5篇。',
            'max'      => '999999',
            'min'      => 1,
            'step'     => 1,
            'default'  => 5,
            'dependency' => array( 'history_Today', '==', 'true' ),
        ),
        array(
            'id'      => 'article_blank',
            'type'    => 'switcher',
            'title'       => '文章新窗口打开',
            'default' => false,
            'subtitle'=>'开启后首页、分类等输出文章列表页面打开文章均为新窗口打开。'
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '图片设置',
    'icon'   => 'fas fa-image',
    'fields' => array(
      array(
            'type'    => 'heading',
            'content' => '图片水印',
        ),
        array(
            'type'    => 'subheading',
            'content' => '本主题内置图片水印功能，您可以通过以下设置对前台文章输出的图片进行水印处理。',
        ),
        array(
            'id'      => 'Watermark',
            'type'    => 'switcher',
            'title'       => '文章图片水印',
            'default' => false,
            'subtitle'=>'开启后可对本功能进行详细设置，前台输出图片时自动打上水印'
        ),
        array(
            'id'       => 'WatermarkType',
            'type'     => 'select',
            'title'    => '水印类型',
            'options'  => array('1' => '文字',  '2' => '图片'),
            'default'=> '1',
            'dependency' => array( 'Watermark', '==', 'true' ),
            'after' => '选择要打上什么样式的水印，若选择图片方式的话在非当前域名下可能存在跨域方面的问题，需自行根据服务器情况设置',
        ),
        array(
            'id'       => 'waterMarkName',
            'type'     => 'text',
            'title'    => '水印文字/图片地址',
            'subtitle' => '若水印类型选择的是文本，则填写文字，若选择的是图片，则请填写图片直链',
            'dependency' => array( 'Watermark', '==', 'true' ),
            ),
            array(
            'id'       => 'waterMarkKd',
            'type'     => 'number',
            'title'    => '水印宽度',
            'default'=> '130',
            'unit'     => 'px',
            'subtitle' => '填写水印宽度，填写数字即可，默认则为130',
            'dependency' => array( 'Watermark', '==', 'true' ),
        ),
        array(
            'id'       => 'waterMarkTextSize',
            'type'     => 'number',
            'title'    => '水印文字大小',
            'default'=> '12',
            'unit'     => 'px',
            'subtitle' => '[仅当水印类型为文字的时候本项有效]<br>填写水印文字大小，单位是px，填写数字即可，默认则为12',
            'dependency' => array( 'Watermark', '==', 'true' ),
        ),
        array(
            'id'       => 'waterMarkTextColor',
            'type'     => 'text',
            'title'    => '水印文字颜色',
            'default'=> 'white',
            'subtitle' => '[仅当水印类型为文字的时候本项有效]<br>填写水印文字颜色，可以是HEX或者RGBA 颜色代码，举个最简单的例子，比如填white，则为白色，black则为黑色',
            'dependency' => array( 'Watermark', '==', 'true' ),
        ),
        array(
            'id'       => 'waterMarkTextBackground',
            'type'     => 'text',
            'title'    => '水印文字背景颜色',
            'default'=> 'black',
            'subtitle' => '[仅当水印类型为文字的时候本项有效]<br>填写水印文字背景颜色，可以是HEX或者RGBA 颜色代码，举个最简单的例子，比如填white，则为白色，black则为黑色',
            'dependency' => array( 'Watermark', '==', 'true' ),
        ),
        array(
            'id'       => 'waterMarkLocation',
            'type'     => 'select',
            'title'    => '水印位置',
            'options'  => array('nw' => '左上角',  'n' => '正上方',  'ne' => '右上角','w' => '正左边','e' => '正右边','sw' => '左下角','s' => '正下方','se' => '右下角','c' => '正中间'),
            'default'=> 'c',
            'dependency' => array( 'Watermark', '==', 'true' ),
            'after' => '选择水印位置',
        ),
        array(
            'id'       => 'waterMarkOpacity',
            'type'     => 'slider',
            'title'    => '水印透明度',
            'subtitle' => '水印透明度，在0-1之间选择一个数字，默认0.7',
            'min'      => 0.1,
            'max'      => 1,
            'step'     => 0.1,
            'default'  => 0.7,
            'dependency' => array( 'Watermark', '==', 'true' ),
        ),
        array(
            'id'       => 'waterMarkMargin',
            'type'     => 'number',
            'title'    => '水印到图片边缘的距离',
            'default'=> '10',
            'subtitle' => '填写水印到图片边缘的距离，填写数字即可，默认10',
            'dependency' => array( 'Watermark', '==', 'true' ),
        ),
        array(
            'id'       => 'waterMarkOutput',
            'type'     => 'select',
            'title'    => '打上水印后的图片格式',
            'options'  => array('null'=>'使用原图格式','jpeg'=>'jpeg','png'=>'png','webp'=>'webp'),
            'default'=> 'null',
            'dependency' => array( 'Watermark', '==', 'true' ),
            'after' => '选择打上水印后的图片格式，默认情况下原图啥格式，输出就啥格式',
        ),
        
        
        array(
            'type'    => 'heading',
            'content' => '图片压缩',
        ),
        array(
            'type'    => 'subheading',
            'content' => '本主题内置图片压缩功能，您可以通过该功能来对上传的图片进行压缩处理。<br>该服务由TinyPNG提供~',
        ),
        array(
            'id'      => 'Tinypng_open',
            'type'    => 'switcher',
            'title'       => '是否启用图片压缩',
            'default' => false,
            'subtitle'=>'TinyPNG APIKEY申请地址:<a href="https://tinypng.com/developers">戳这里</a>'
        ),
        array(
            'id'       => 'Tinypng_apikey',
            'type'     => 'text',
            'title'    => 'TinyPNG APIKEY',
            'subtitle' => '请在这里填写TinyPNG ApiKey',
            'dependency' => array( 'Tinypng_open', '==', 'true' ),
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '海报设置',
    'icon'   => 'fas fa-magnet',
    'fields' => array(
      array(
            'id'      => 'Poster',
            'type'    => 'switcher',
            'title'       => '文章微海报',
            'default' => false,
            'after'=>'<br><br>开启后前台文章页面会显示微海报生成按钮，在每篇文章的编辑页面都会有单独的海报生成开关选择，当本项开启而文章编辑页面选择不开启时则不开启，当文章编辑页面海报生成选择开启而本项不开启时则不开启，需要两项同时开启才算开启状态！'
        ),
        array(
            'id'       => 'Poster__LogoUrl',
            'type'    => 'upload',

            'title'    => '海报底部LOGO',
            'subtitle' => '上传海报底部LOGO，显示在海报底部',
            'dependency' => array( 'Poster', '==', 'true' ),
        ),
        array(
            'id'       => 'Poster__SiteDec',
            'type'    => 'text',
            'title'    => '海报底部LOGO下文字描述',
            'subtitle' => '填写海报底部LOGO下文字描述',
            'dependency' => array( 'Poster', '==', 'true' ),
        ),
        array(
            'id'       => 'Poster__AttUrl',
            'type'    => 'upload',

            'title'    => '海报默认缩略图',
            'subtitle' => '上传海报默认缩略图，显示在海报顶部，在文章没有图片的情况下使用缩略图',
            'dependency' => array( 'Poster', '==', 'true' ),
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '区块设置',
    'icon'   => 'fas fa-sort',
    'fields' => array(
      array(
            'id'      => 'Cate',
            'type'    => 'switcher',
            'title'       => '右侧分类区块',
            'default' => true,
            'subtitle'=>'若选择开启,则网站右侧将出现分类区块,显示当前所有分类。'
        ),
        array(
            'id'      => 'LastArticle',
            'type'    => 'switcher',
            'title'       => '右侧最近文章区块',
            'default' => true,
            'subtitle'=>'若选择开启,则网站右侧将出现最近文章区块,显示最近发布的文章,可控制显示的文章数目。'
        ),
        array(
            'id'       => 'LastArticleNumber',
            'type'     => 'number',
            'title'    => '右侧最近文章显示数目',
            'default'=> '5',
            'unit'     => '篇',
            'subtitle' => '请输入右侧最近文章显示数目,填数字即可',
            'dependency' => array( 'LastArticle', '==', 'true' ),
        ),
        array(
            'id'      => 'ClockModule',
            'type'    => 'switcher',
            'title'       => '人生倒计时区块',
            'default' => false,
            'subtitle'=>'若选择开启,则网站右侧将出现人生倒计时区块，动态显示本年-本月-本日-本小时-本分钟的倒计时。'
        ),
        array(
            'id'      => 'AdControl',
            'type'    => 'switcher',
            'title'       => '广告区块',
            'default' => false,
            'subtitle'=>'若选择开启,则网站将出现广告位置。'
        ),
        array(
            'id'      => 'AdControl1',
            'type'    => 'switcher',
            'title'       => '右侧顶部广告',
            'default' => false,
            'subtitle'=>'若选择开启,则网站右侧顶部将出现广告位置。',
            'dependency' => array( 'AdControl', '==', 'true' ),
        ),
        array(
            'id'       => 'AdControl1Src',
            'type'     => 'text',
            'title'    => '右侧顶部广告图片链接及指向链接',
            'subtitle' => '请输入右侧顶部广告图片链接及指向链接，格式：图片链接|指向链接，使用|分隔，有且仅能存在一个',
            'dependency' => array( 'AdControl|AdControl1', '==|==', 'true|true' ),
        ),
        array(
            'id'      => 'AdControl2',
            'type'    => 'switcher',
            'title'       => '右侧底部广告',
            'default' => false,
            'subtitle'=>'若选择开启,则网站右侧底部将出现广告位置。',
            'dependency' => array( 'AdControl', '==', 'true' ),
        ),
        array(
            'id'       => 'AdControl2Src',
            'type'     => 'text',
            'title'    => '右侧底部广告图片链接及指向链接',
            'subtitle' => '请输入右侧底部广告图片链接及指向链接，格式：图片链接|指向链接，使用|分隔，有且仅能存在一个',
            'dependency' => array( 'AdControl|AdControl2', '==|==', 'true|true' ),
        ),
        array(
            'id'      => 'AdControl3',
            'type'    => 'switcher',
            'title'       => '首页顶部广告',
            'default' => false,
            'subtitle'=>'若选择开启,则网站首页顶部将出现广告位置。',
            'dependency' => array( 'AdControl', '==', 'true' ),
        ),
        array(
            'id'       => 'AdControl3Src',
            'type'     => 'text',
            'title'    => '首页顶部广告图片链接及指向链接',
            'subtitle' => '请输入首页顶部图片链接及指向链接，格式：图片链接|指向链接，使用|分隔，有且仅能存在一个',
            'dependency' => array( 'AdControl|AdControl3', '==|==', 'true|true' ),
        ),
        array(
            'id'      => 'AdControl4',
            'type'    => 'switcher',
            'title'       => '分类/搜索/标签/作者文章顶部广告',
            'default' => false,
            'subtitle'=>'若选择开启,则分类/搜索/标签/作者文章顶部将出现广告位置。',
            'dependency' => array( 'AdControl', '==', 'true' ),
        ),
        array(
            'id'       => 'AdControl4Src',
            'type'     => 'text',
            'title'    => '分类/搜索/标签/作者文章顶部广告图片链接及指向链接',
            'subtitle' => '请输入分类/搜索/标签/作者文章顶部广告图片链接及指向链接，格式：图片链接|指向链接，使用|分隔，有且仅能存在一个',
            'dependency' => array( 'AdControl|AdControl4', '==|==', 'true|true' ),
        ),
        
        array(
            'id'      => 'Search',
            'type'    => 'checkbox',
            'title'   => '搜索区块',
            'inline'  => true,
            'options' => array('sidebar' => '侧边栏',  'phone' => '手机端导航栏上面','header' => 'PC端顶部右侧'),
            'subtitle'=>'选择搜索区块要显示的位置，若都不选择则都不显示。'
        ),
        array(
            'id'      => 'lastcomment',
            'type'    => 'switcher',
            'title'       => '右侧最新回复区块',
            'default' => true,
            'subtitle'=>'开启后网站侧边栏将增加最新回复区块，显示最新的五条评论。'
        ),
        array(
            'id'      => 'tagcloud',
            'type'    => 'switcher',
            'title'       => '右侧标签云区块',
            'default' => true,
            'subtitle'=>'开启后网站侧边栏将增加标签云区块，显示添加的文章标签。'
        ),
        array(
            'id'       => 'tagcloudnum',
            'type'     => 'number',
            'title'    => '标签云显示的标签个数',
            'default'=> '20',
            'unit'     => '个',
            'subtitle' => '限制标签云所显示的标签个数，默认显示20个',
            'dependency' => array( 'tagcloud', '==', 'true' ),
        ),
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '博主信息',
    'icon'   => 'fas fa-wrench',
    'fields' => array(
        array(
            'id'      => 'Authorz',
            'type'    => 'switcher',
            'title'       => '右侧博主区块',
            'default' => false,
            'subtitle'=>'若选择开启,则网站右侧将出现博主一栏。'
        ),
        array(
            'id'       => 'AuthorzStyle',
            'type'     => 'select',
            'title'    => '博主区块样式',
            'options'  => array('1'=>'样式一','2'=>'样式二','3'=>'样式三'),
            'default'=> '1',
            'dependency' => array( 'Authorz', '==', 'true' ),
            'after' => '选择博主区块样式，每一种样式所需配置的信息略有不同',
        ),
      array(
            'id'       => 'AuthorAvatar',
            'type'    => 'upload',
            'title'    => '博主头像图片',
            'after' => '请上传博主头像图片',
'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'AuthorBackground',
            'type'    => 'upload',
            'title'    => '博主头像背景图片',
            'after' => '请上传博主头像图片或填写博主头像背景图片直链',
'dependency' => array( 'Authorz|AuthorzStyle', '==|==', 'true|2' ),
        ),
        array(
            'id'       => 'AuthorAvatarClickText',
            'type'     => 'text',
            'title'    => '博主头像图片动作文字',
            'subtitle' => '当鼠标移至头像处时会存在hover覆盖效果,目前预设了按钮，您可以自定义按钮文字及链接',
            'dependency' => array( 'Authorz|AuthorzStyle|AuthorAvatar', '==|==|!=', 'true|1|""' ),
        ),
        array(
            'id'       => 'AuthorAvatarClickLink',
            'type'     => 'text',
            'title'    => '博主头像图片动作链接',
            'subtitle' => '当鼠标移至头像处时会存在hover覆盖效果,目前预设了按钮，您可以自定义按钮文字及链接',
            'dependency' => array( 'Authorz|AuthorzStyle|AuthorAvatar', '==|==|!=', 'true|1|""' ),
        ),
        array(
            'id'       => 'AuthorName',
            'type'     => 'text',
            'title'    => '博主昵称',
            'subtitle' => '请填写博主昵称,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'AuthorQm',
            'type'     => 'text',
            'title'    => '博主个性简介',
            'subtitle' => '请填写博主个性简介,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'      => 'AuthorOneSay',
            'type'    => 'switcher',
            'title'       => '个性简介处显示一言',
            'default' => false,
            'subtitle'=>'若选择开启,则博主栏个性简介将显示一言，不显示所填写的个性简介。<br>开启一言后可能会拖慢加载速度，请谨慎开启',
             'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'QQ_QRCODE',
            'type'    => 'upload',
            'title'    => 'QQ二维码图片',
            'after' => '请上传QQ二维码图片，建议尺寸为300px×300px，若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),

        ),
        array(
            'id'       => 'Wechat_QRCODE',
            'type'    => 'upload',
    
            'title'    => '微信二维码图片',
            'after' => '请上传微信二维码图片，建议尺寸为300px×300px，若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),

        ),
        array(
            'id'       => 'Github_URL',
            'type'     => 'text',
            'title'    => 'Github链接',
            'subtitle' => '请填写Github链接,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'Facebook_URL',
            'type'     => 'text',
            'title'    => 'Facebook链接',
            'subtitle' => '请填写Facebook链接,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'Twitter_URL',
            'type'     => 'text',
            'title'    => 'Twitter链接',
            'subtitle' => '请填写Twitter链接,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'Telegram_URL',
            'type'     => 'text',
            'title'    => 'Telegram链接',
            'subtitle' => '请填写Telegram链接,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'       => 'Weibo_URL',
            'type'     => 'text',
            'title'    => '微博链接',
            'subtitle' => '请填写微博链接,若为空则不显示',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),
        array(
            'id'      => 'FourTotalHidden',
            'type'    => 'switcher',
            'title'       => '四项统计',
            'default' => false,
            'subtitle'=>'若选择开启，则博主信息栏将显示四项统计：文章、评论、分类、页面。',
            'dependency' => array( 'Authorz', '==', 'true' ),
        ),

    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '其他设置',
    'icon'   => 'fas fa-window-restore',
    'fields' => array(

        array(
            'id'       => 'ServiceWorker',
            'type'    => 'text',
            'title'    => 'ServiceWorker规则文件名',
            'after' => 'ServiceWorker可为您的博客提供前端静态资源缓存，从而加快访问速度(前提是站点已开启HTTPS)<br><font color=red>您需要在这里填上规则文件名，规则文件在主题目录/vendors/BearSimpleCacheRules.js，将该文件复制一份到您的站点根目录，并在这里填上文件名，如为默认的BearSimpleCacheRules.js，则填BearSimpleCacheRules.js即可。</font><br>不填则表示不开启。',
        ),
        array(
            'id'      => 'Darkmode',
            'type'    => 'switcher',
            'title'       => '黑暗模式',
            'default' => false,
            'subtitle'=>'开启黑暗模式后前台右下角会出现太阳/月亮来切换光暗模式。'
        ),
      array(
            'id'      => 'CopyProtect',
            'type'    => 'switcher',
            'title'       => '防复制',
            'default' => false,
            'subtitle'=>'若开启防复制，则禁用右键、复制、拖动等。'
        ),
        array(
            'id'          => 'Translate',
            'type'        => 'select',
            'title'       => '语言切换',
            'after' => '若开启,则前台顶部LOGO位置自动增加语言切换按钮，可选择开启简繁体切换或者全球几十种语言切换',
            'options'     => array('1' => '开启简繁体切换','11'=>'开启全球语言切换','2' => '否'),
            'default' => '2',
        ),
        array(
            'id'          => 'TranslateLanguage',
            'type'        => 'select',
            'title'       => '选择优先显示语言',
            'after' => '访客访问时优先使用的语言',
            'options'     => array('1' => '简体中文',  '2' => '繁体中文'),
            'default' => '1',
            'dependency' => array( 'Translate', '==', '1' ),
        ),
        array(
            'id'      => 'WorldLanguage',
            'type'    => 'checkbox',
            'title'   => '选择要显示的语言',
            'inline'  => true,
            'default' => '1',
            'options' => array('zh' => '简体中文',  'zh-TW' => '繁体中文',  'sq' => '阿尔巴尼亚语',  'ar' => '阿拉伯语',  'am' => '阿姆哈拉语',  'az' => '阿塞拜疆语',  'ga' => '爱尔兰语',  'et' => '爱沙尼亚语',  'or' => '奥利亚语',  'eu' => '巴斯克语',  'be' => '白俄罗斯语',  'bg' => '保加利亚语',  'is' => '冰岛语',  'pl' => '波兰语',  'bs' => '波斯尼亚语',  'fa' => '波斯语',  'af' => '布尔语(南非荷兰语)',  'tt' => '鞑靼语',  'da' => '丹麦语',  'de' => '德语',  'ru' => '俄语',  'fr' => '法语',  'tl' => '菲律宾语',  'fi' => '芬兰语',  'fy' => '弗里西语',  'km' => '高棉语',  'ka' => '格鲁吉亚语',  'gu' => '古吉拉特语',  'kk' => '哈萨克语',  'ht' => '海地克里奥尔语',  'ko' => '韩语',  'ha' => '豪萨语',  'nl' => '荷兰语',  'ky' => '吉尔吉斯语',  'gl' => '加利西亚语',  'ka' => '加泰罗尼亚语',  'cs' => '捷克语',  'kn' => '卡纳达语',  'co' => '科西嘉语',  'fi' => '克罗地亚语',  'ku' => '库尔德语',  'la' => '拉丁语',  'lv' => '拉脱维亚语',  'lo' => '老挝语',  'lt' => '立陶宛语',  'lo' => '卢森堡语',  'rw' => '卢旺达语',  'ro' => '罗马尼亚语',  'mg' => '马尔加什语',  'mt' => '马耳他语',  'mr' => '马拉地语',  'ml' => '马拉雅拉姆语',  'ms' => '马来语',  'mk' => '马其顿语',  'mi' => '毛利语',  'mn' => '蒙古语',  'bn' => '孟加拉语',  'my' => '缅甸语',  'hmn' => '苗语','xh' => '南非科萨语',  'zu' => '南非祖鲁语',  'ne' => '尼泊尔语',  'no' => '挪威语',  'pa' => '旁遮普语',  'pt' => '葡萄牙语',  'ps' => '普什图语',  'ny' => '齐切瓦语',  'ja' => '日语',  'sv' => '瑞典语',  'sm' => '萨摩亚语',  'sr' => '塞尔维亚语',  'st' => '塞索托语',  'si' => '僧伽罗语',  'eo' => '世界语',  'sk' => '斯洛伐克语',  'sl' => '斯洛文尼亚语',  'sw' => '斯瓦希里语',  'gd' => '苏格兰盖尔语',  'ceb' => '宿务语',  'so' => '索马里语',  'tg' => '塔吉克语',  'te' => '泰卢固语',  'ta' => '泰米尔语',  'th' => '泰语',  'tr' => '土耳其语',  'tk' => '土库曼语',  'cy' => '威尔士语',  'ug' => '维吾尔语',  'ur' => '乌尔都语',  'uk' => '乌克兰语',  'uz' => '乌兹别克语',  'es' => '西班牙语',  'iw' => '希伯来语',  'el' => '希腊语',  'haw' => '夏威夷语',  'sd' => '信德语',  'hu' => '匈牙利语',  'sn' => '修纳语',  'hy' => '亚美尼亚语',  'ig' => '伊博语',  'it' => '意大利语',  'yi' => '意第绪语',  'hi' => '印地语',  'su' => '印尼巽他语',  'id' => '印尼语',  'jw' => '印尼爪哇语',  'en' => '英语',  'yo' => '约鲁巴语',  'vi' => '越南语'),
            'subtitle'=>'支持选择前台显示支持翻译的语言<br><font color=red>要注意的一点是有很多语言对中文的翻译是不友好的，有的甚至翻译不出来，从而导致翻译后页面出现错位等问题，所以请谨慎选择</font>',
             'dependency' => array( 'Translate', '==', '11' ),
        ),
        array(
            'id'          => 'Top',
            'type'        => 'switcher',
            'title'       => '返回顶部',
            'subtitle' => '若开启，则右侧下方将增加一个返回顶部图标，可自定义',
            'default' => false,
        ),
        array(
            'id'       => 'TopSrc',
            'type'    => 'icon',
    
            'title'    => '返回顶部图标',
            'after' => '请上传返回顶部图标,若为空则显示默认图标',

            'dependency' => array( 'Top', '==', 'true' ),
        ),
        array(
            'id'          => 'Mournmode',
            'type'        => 'switcher',
            'title'       => '哀悼模式',
            'subtitle'=>'若开启哀悼模式，则网站全部显示灰色。',
            'default' => false,
        ),
        
        array(
            'id'          => 'IframeProtect',
            'type'        => 'select',
            'title'       => 'Iframe嵌入',
            'after' => '可通过本功能设置防止站点被其他站点通过iframe方式嵌入',
            'options'     => array('1' => '允许任何网页',  '2' => '只允许同域名网页','3'=>'不允许任何网页'),
            'default' => '1',
        ),
        array(
            'id'          => 'Link_blank',
            'type'        => 'select',
            'title'       => '外链打开方式',
            'after' => '选择外链的打开方式，在当前窗口打开还是新窗口打开',
            'options'     => array('1' => '在当前窗口打开',  '2' => '在新窗口打开'),
            'default' => '1',
        ),
        array(
            'id'          => 'Read_Process',
            'type'        => 'switcher',
            'title'       => '阅读进度条',
            'subtitle' => '选择开启则前台页面滚动时顶部显示阅读进度条',
            'default' => 'false',
        ),
        
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '实验室',
    'icon'   => 'fas fa-braille',
    'fields' => array(
        array(
            'type'    => 'heading',
            'content' => '外链转内链',
        ),
        array(
            'type'    => 'subheading',
            'content' => '外链转内链功能可以将站点中的外部链接转化为内链进行访问。',
        ),
      array(
            'id'       => 'WebLink',
            'type'     => 'textarea',
            'title'    => '自定义外链转内链',
            'after' => '<font style="color:red">可能存在玄学问题！！</font><br>外链转内链功能将把您填写在框框内的链接转化为网站的内链，需要填写的格式为：key|网站链接，key不可重复。一个链接一个key，多个请直接换行<br>举个栗子，当您填写的是baidu|https://www.baidu.com/的时候，您可以通过<br>
    未开启伪静态：您的网址/index.php/go/baidu<br>已开启伪静态：您的网址/go/baidu 来访问。',
    'default'=>'baidu|https://www.baidu.com/',
        ),
        
    )
  ) );
  CSF::createSection( $prefix, array(
    'title'  => '短代码',
    'icon'   => 'fas fa-text-width',
    'fields' => array(
      array(
            'type'    => 'heading',
            'content' => '短代码',
        ),
        array(
            'type'    => 'subheading',
            'content' => '本主题支持的短代码均会显示在这里，方便大家使用',
        ),
         array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>1、登录或回复后可见</strong><br> [bshide}隐藏内容[/bshide]',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>2、仅登录后可见</strong><br> [bslogin}隐藏内容[/bslogin]',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>3、Todolist</strong><br>  已完成：[todo-t]已完成的内容[/todo-t]<br>
    未完成：[todo-f]未完成的内容[/todo-f]',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>4、代码高亮</strong><br> ```语言名称<br>
    代码内容<br>
    ```',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>5、字体颜色</strong><br> {bs-font color="Hex颜色代码"}内容{/bs-font}<br>
   Hex颜色代码例如#FFFFFF',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>6、iframe</strong><br> {bs-iframe}iframe地址{/bs-iframe}<br>
   iframe地址举个简单的例子，如B站的分享视频代码，<br>
   &#60;iframe src="xxxxxxxx" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>
   只要xxxxxxxx这一部分就行，也就是src里边这一串链接，这个就是iframe地址',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>7、音频</strong><br> [bsaudio]音频地址[/bsaudio]<br>
   音频地址必须直链',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>8、手风琴</strong><br>  线性手风琴<br>
   {bs-accord style=line title=线性手风琴标题}线性手风琴内容{/bs-accord}<br>
   普通手风琴<br>
   {bs-accord style=common title=普通手风琴标题}普通手风琴内容{/bs-accord}',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>9、Github仓库</strong><br> [bsgit user="仓库创建者，如whitebearcode"]仓库名，如typecho-bearsimple[/bsgit]',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>10、引用文章</strong><br> [bspost cid="文章CID"]<br>
    您可以在文章中引用另外一篇文章',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>11、标记文字</strong><br> [bsmark]要标记的文字[/bsmark]<br>
    您可以在文章中对一些重点内容进行标记，前台会显示划线效果',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>12、文字带拼音</strong><br> [bsruby]要带拼音的文字[/bsruby]<br>
    您可以在文章中对一些文字附带拼音，前台会在要带拼音的文字上方显示拼音以及声调',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>13、按钮</strong><br> [bsbtn type="按钮类型" color="颜色" url="点击按钮跳转的网址" icon="图标名"]按钮名[/bsbtn]<br>
    您可以在文章中添加按钮，按钮可设置跳转链接<br>
    按钮参数：<br>
    type:common、basic、animated<br>
    color:standard、primary、secondary、red、orange、yellow、olive、green、teal、violet、purple、pink、brown、grey<br>
    url:点击按钮跳转的网址，需带http(s)://，如https://www.baidu.com/<br>
    icon:图标名，参考<a href="https://bs-icon.typecho.ru/" target="_blank">戳这里访问Bearsimple主题适配图标站</a><br>
    <font color=red>注:当为动画图标时按钮名需设置两个，一个是鼠标未点击按钮时显示的文字，一个是鼠标点击按钮时显示的文字，两个按钮名使用|隔开</font>',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>14、提示框</strong><br> [bsmessage type="提示框类型" color="提示框颜色" title="提示框标题" icon="提示框图标"]提示框内容[/bsmessage]<br>
    您可以在文章中添加提示框<br>
    提示框参数：<br>
    type:common、basic、commonclose、basicclose<br>
    color:standard、primary、secondary、red、orange、yellow、olive、green、teal、violet、purple、pink、brown、grey<br>
    title:提示框标题<br>
    icon:图标名，参考<a href="https://bs-icon.typecho.ru/" target="_blank">戳这里访问Bearsimple主题适配图标站</a><br>
    <font color=red>注:阴影效果受到提示框颜色影响，有些颜色显示不出来阴影效果</font>',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>15、评星</strong><br> [bseva type="star或者heart"]评星颗数[/bseva]<br>
    您可以在文章中对一些事物进行评星',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>16、相册</strong><br> [bsgallery title="相册名"]<br>
[bsimg title="图片标题1" subtitle="图片子标题1"]图片地址1[/bsimg]<br>
[bsimg title="图片标题2" subtitle="图片子标题2"]图片地址2[/bsimg]<br>
[bsimg title="图片标题3" subtitle="图片子标题3"]图片地址3[/bsimg]<br>
[/bsgallery]<br>
    您可以在文章中通过该短代码将多张图片集成一个相册，建议图片数量不少于四张',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>17、每日60s早报</strong><br> [bspaper]<br>
    您可以在文章中通过该短代码调取每日60s早报文字版所有内容当做文章内容来显示',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>18、Mermaid</strong><br> [bsmermaid]Mermaid流程图内容[/bsmermaid]<br>
    您可以在文章中通过该短代码转换mermaid流程图',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>19、时间计划</strong><br> [bstimes title="时间计划名"]<br>
[bstime time="计划时间1"]计划内容1[/bstime]<br>
[bstime time="计划时间2"]计划内容2[/bstime]<br>
[bstime time="计划时间3"]计划内容3[/bstime]<br>
[/bstimes]<br>
    您可以在文章中通过该短代码制作一个时间计划，对每日的时间进行规划',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>20、倒计时进度条</strong><br> [bsdate end="结束时间，如2022-12-12 23:12:55，年-月-日 时:分:秒，请精确到秒"]倒计时进度条标题[/bsdate]<br>
    您可以在文章中通过该短代码制作一个倒计时进度条，可以给自己设定一个时间计划，到达结束时间后看看自己做到了没~',
        ),
        array(
            'type'    => 'notice',
            'style'   => 'info',
            'content' => '<strong>21、bframe</strong><br> [bsfra image="占位封面图直链" url="页面地址"]<br>占位封面图直链为进入文章后还没进行交互操作时显示的占位封面图，要求必须直链，若不填会显示默认图片<br>
   页面地址举个简单的例子，如B站的分享视频代码，<br>
   &#60;iframe src="xxxxxxxx" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"> </iframe>
   只要xxxxxxxx这一部分就行，也就是src里边这一串链接，这个就是页面地址',
        ),
    )
  ) );
CSF::createSection( $prefix, array(
    'title'       => '数据备份',
    'icon'        => 'fas fa-shield-alt',
    'description' => '本主题支持您通过以下功能对您所填写的配置信息进行备份导出，也可以对备份的数据进行导入。',
    'fields'      => array(

        array(
            'type' => 'backup',
        ),

    )
) );

?>

<?php

                $htmls = '
        <div class="ui three steps">
  <div class="step" id="check">
    <i class="tree icon"></i>
    <div class="content">
      <div class="title">检测</div>
    </div>
  </div>
  <div class="disabled step" id="upgrade">
    <i class="angle double right icon"></i>
    <div class="content">
      <div class="title">升级</div>
    </div>
  </div>
  <div class="disabled step" id="finished">
    <i class="info icon"></i>
    <div class="content">
      <div class="title">完成</div>
    </div>
  </div>
</div>
<div id="checkcon">
<div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="cloud icon"></i>
    您可以通过点击以下按钮进行检测是否符合在线升级的条件
  </div>
  <div class="inline">
    <div class="ui button" id="checkbtn">检测版本</div>
  </div>

</div>
  <div id="versiontipss"></div>
</div>
<div id="upgradecon" style="display:none">
<div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="cloud icon"></i>
    检测到最新版本为 V<font id="newversion"></font>，您可以通过点击以下按钮进行在线升级
  </div>
  <div class="inline">
    <div class="ui button" id="upgradebtn" style="margin-top:10px;">立即更新</div>
  </div>
 <center><div id="pre-message" style="margin-top:20px;"></div></center>
 <center><div id="progress-message" style="margin-top:20px;"></div></center>
<progress id="progress" value="0" max="100" style="display:none;margin-top:10px;width:100%;max-width:100%;height:20px"></progress> 

</div>
</div>

<div id="finishcon" style="display:none">
<div class="ui placeholder segment">
  <div class="ui icon header">
    <i class="green check icon"></i>
    您已成功升级到最新版本，系统将在三秒后自动刷新~~~
  </div>

</div>
</div>

<script>
//检测
$("#checkbtn").on("click",function(){
$("#checkbtn").addClass("loading").attr("disabled","disabled");
    $.post("https://upgrade.typecho.co.uk/Bearsimple/version.php",function(data,status){
switch(status)
{
case "success":
json = JSON.parse(data);
nowversion = "'.themeVersion().'";
if(json.version > nowversion){
$("#versiontipss").html(\'<div class="csf-submessage csf-submessage-warning">检测到有新版本可以更新，3秒钟后自动跳转下一步!</div>\');
$("#newversion").html(json.version);
setTimeout(function(){
$("#check").addClass("completed");
$("#upgrade").removeClass("disabled");
$("#checkcon").hide();
$("#upgradecon").fadeIn();
},3000);

}
if(json.version == nowversion){
$("#versiontipss").html(\'<div class="csf-submessage csf-submessage-success">当前版本为最新版本，无需更新~<a href="https://bearnotion.flowus.cn/share/d9678d98-ac2b-4692-9599-4a29524d9ebb" target="_blank">查看版本更新日志</a></div>\');
$("#checkbtn").removeClass("loading").removeAttr("disabled","disabled");
}
break;
case "error":
toastr.warning("最新版本获取失败，请稍后重试");
$("#checkbtn").removeClass("loading").removeAttr("disabled","disabled");
break;
case "timeout":
toastr.warning("最新版本获取超时，请稍后重试");
$("#checkbtn").removeClass("loading").removeAttr("disabled","disabled");
break;
}
    });
});

//升级
$("#upgradebtn").on("click",function(){
$("#upgradebtn").addClass("loading").attr("disabled","disabled");

$.ajax({
                        type: "GET",
                        url: "/index.php/bs-upgrade",
                        data: {
                            "action": "prepare-download",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                           $("#pre-message").html("升级包大小："+json.filesize+"，预计需要三十秒，请耐心等待~");
                           $("#progress-message").html("升级进度：0%");
                           $("#progress").fadeIn();
                        let x = document.getElementById("progress");   
                        x.setAttribute("value", "1");
                        intervaldown();
                        //设置定时器定时每两秒获取一次升级进度
                        let progressx = setInterval(function(){ 
                        intervalprogress();
                        }, 1000);
                        $("#progress").one("click",function(){
                            clearInterval(progressx);
                            finishUpgrade();
                        })
                        
                        },
                        error: function() {
alert("升级准备检测失败，请稍后重试");
$("#upgradebtn").removeClass("loading").removeAttr("disabled","disabled");
                        }
                    });
                    
});
function intervaldown(){
$.ajax({
                        type: "GET",
                        url: "/index.php/bs-upgrade",
                        data: {
                            "action": "download",
                        },
                        dateType: "json",
                    });
}
function intervalprogress(){
$.ajax({
                        type: "GET",
                        url: "/index.php/bs-upgrade",
                        data: {
                            "action": "getsize",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                           $("#progress-message").html("升级进度："+json.filesize+"%");
let x = document.getElementById("progress");   
                        x.setAttribute("value", json.filesize);
                if(json.filesize == "100"){
                
                $("#progress-message").html("正在进行数据效验，请稍后...");
                setTimeout(function(){
                   $("#progress").click();
},3000);
                }
                        },
                        error: function() {
alert("获取升级进度失败");
                        }
                    });
}
function finishUpgrade(){
$.ajax({
                        type: "GET",
                        url: "/index.php/bs-upgrade",
                        data: {
                            "action": "finish",
                        },
                        dateType: "json",
                        success: function(json) {
$("#upgrade").addClass("completed");
$("#finished").removeClass("disabled");
$("#upgradecon").hide();
$("#finishcon").fadeIn();
setTimeout(function(){
window.parent.location.reload();
},3000);
                        },
                        error: function() {
alert("升级失败");
                        }
                    });
}
</script>
        ';
        
        CSF::createSection( $prefix, array(
    'title'       => '在线升级',
    'icon'        => 'fa fa-grav',
    
    'fields'      => array(
array(
                    'type' =>'content',
                    'content' => $htmls,
                ),
        

    )
) );
}
function themeConfig($form)
{

   ?>
       <?php $all = Typecho_Plugin::export();
       \Widget\Security::alloc()->to($security);?>
<?php if (!array_key_exists('BsCore', $all['activated'])) : ?>
   <div class="update-check message error"><p>检测到您未安装BsCore插件，主题尚处于封印状态，您需要安装启用BsCore核心插件后方能解除封印QAQ！<br>若您还未下载核心插件，可戳这里进行下载并将核心插件放入/usr/plugins，当下方出现解除封印按钮时点击按钮后即可解除封印~~~
   <?php if(is_dir(Helper::options()->pluginDir('BsCore'))):?><br><button onclick="window.location.href='<?php $security->index('/action/plugins-edit?activate=BsCore'); ?>'"  class="btn">
解除封印</button></p>
</div>
<?php endif;?>
   <?php else:?>

        <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
	<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.js"></script>
        
<?php

    $params = [
        'args'=> [
            'framework_title' => 'Bearsimple V'.themeVersionOnly(),
            'footer_text' => '自豪的使用BearSimple主题!',
        ]
    ];
    CSF::setup('bearsimple', $params);
    
    ?>
       <?php endif; ?>
       <?php
       CSF::setTypechoOptionForm($form);
       ?>
              <?php if (array_key_exists('BsCore', $all['activated'])) : ?>
          <style>

        .popup{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .message{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .message a{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .success{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .success a{
            all:unset;
            font-size:0; overflow:hidden;
        }
        .message.popup.success{
            all:unset;
            font-size:0; overflow:hidden;
        }
        </style>
           <script>
           window.deactivateURL = '<?php $security->index('/action/plugins-edit?deactivate=BsCore'); ?>';
           window.activateURL = '<?php $security->index('/action/plugins-edit?activate=BsCore'); ?>';
        </script>
<?php endif; ?>

       <?php if (!array_key_exists('BsCore', $all['activated'])) : ?>
       
    <script src="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/2.0.0/jquery.min.js"></script>
    

   <script>
       $('#wpwrap').hide();
   </script>
   <?php endif; ?>
    <?php
} ?>