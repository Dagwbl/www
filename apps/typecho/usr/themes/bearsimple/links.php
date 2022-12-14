<?php
    /**
    * 友链
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
                    <?php if($this->options->Diy == "1"): ?><div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>><?php endif; ?>
                <h2><i class="jsfiddle icon"></i> <?php $this->title() ?></h2><br>    

<ul id="friendlinks">
<?php echo $this->content ?>

</ul>
<?php if($this->options->Diy == "1"): ?></div><?php endif; ?>
<script>
(function(){
    let a =document.getElementById("friendlinks");
    if(a){
        let ns = a.querySelectorAll("li");
        let nsl = ns.length;
        let str ='<div class="ui four doubling cards" style="word-break:break-all;">';
        let bgid = 0;
        for(let i = 0;i<=nsl-4;i+=4){
           bgid = Math.floor(Math.random() * 6);
            str += (`<div class="card" hrefs="${ns[i+1].innerText}"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>><div class="content"><div class="center aligned header">${ns[i].innerText}</div><div class="center aligned description"><p>${ns[i+3].innerText}</p></div></div><div class="extra content"><div class="center aligned author"><img class="ui avatar image" src="${ns[i+2].innerText}">${ns[i].innerText}</div></div></div>`);
        }
        str+='</div><style></style>';
        let n1 = document.createElement("div");
        n1.innerHTML = str;
        a.parentNode.insertBefore(n1,a);
        a.style="display: none;";
    }else{
        console.log('error');
    }
}())
 </script> 

</div>

</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>