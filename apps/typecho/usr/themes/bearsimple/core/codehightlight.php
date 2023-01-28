<?php
//代码高亮->
if ($options->Codehightlight == true){
    Typecho_Plugin::factory('Widget_Archive')->header = array('Prism_Plugin', 'headlink');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Prism_Plugin', 'footlink');
class Prism_Plugin{
     /**
     *为header添加css文件
     *@return void
     */
    public static function headlink($cssUrl) {
        
        $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    
        $dir = $options->themeUrl.'/';
   
    
        $style = bsOptions::getInstance()::get_option( 'bearsimple' )->code_style;
        if(empty($style)){
            $style = 'coy.css';
        }
        else{
       $style = bsOptions::getInstance()::get_option( 'bearsimple' )->code_style;
        }
        $cssUrl = $dir.'modules/codehightlight/static/styles/' . $style.'?v='.themeVersion();
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
    }

    /**
     * 底部脚本
     *
     * @access public
     * @param unknown $footlink
     * @return unknown
     */
    public static function footlink($links) {
      $options = bsOptions::getInstance()::get_option( 'bearsimple' );
        $dir = $options->themeUrl.'/';
  
    
         $jsUrl = $dir.'modules/codehightlight/static/prism.js';
        $jsUrl_clipboard = $dir.'modules/codehightlight/static/clipboard.min.js';
        $showLineNumber = bsOptions::getInstance()::get_option( 'bearsimple' )->showLineNumber;
        if ($showLineNumber == '1') {
            echo <<<HTML
<script type="text/javascript">
	(function(){
		var pres = document.querySelectorAll('pre');
		var lineNumberClassName = 'line-numbers';
		pres.forEach(function (item, index) {
			item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
		});
	})();
</script>
<script type="text/javascript">
$(document).on('pjax:complete', function() {
if (typeof Prism !== 'undefined') {
var pres = document.getElementsByTagName('pre');
                for (var i = 0; i < pres.length; i++){
                    if (pres[i].getElementsByTagName('code').length > 0)
                        pres[i].className  = 'line-numbers';}
Prism.highlightAll(true,null);}
});
</script>


HTML;
        }
        echo <<<HTML
<script type="text/javascript" src="{$jsUrl_clipboard}"></script>
<script type="text/javascript" src="{$jsUrl}"></script>

HTML;
    }
}
}
