<?php if($this->options->Scroll == '1'): ?>
<?php if(strpos($this->content,'h2') !== false): ?>
<div class="bs-scrollnav-v" id="article-nav" style="background-color: rgba(255,255,255,.9);border: 1px solid #ebebeb;"><bsnav class="bs-close ax-iconfont ax-icon-arrow-right"></bsnav></div>
<?php endif; ?>
<?php endif; ?>
<?php if($this->options->Readmode == "1"): ?> 

<?php echo readModeContent($this,ShortCode($this->content,$this,$this->user->hasLogin(),'readmode')); ?>

<?php endif; ?>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?> 
 <div class="pure-g" id="layout">

    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
      
      <div class="pure-u-1 pure-u-md-3-4">
          <div class="content_container">
         <div id="bearsimple-scroll">
          <div class="post">
                    
          <div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>>
               <?php if($this->fields->articleplo !== '1'): ?>
              <?php if($this->fields->articleplo == '2' && $this->fields->articleplo !== null): ?>
              <div class="ui top attached label"><h4><?php $this->fields->articleplonr() ?> </h4></div>
              <?php endif; ?>
              <?php if($this->fields->articleplo == '3' && $this->fields->articleplo !== null): ?>
              <div class="ui top left attached label"><h4><?php $this->fields->articleplonr() ?> </h4></div>
              <?php endif; ?>
              <?php if($this->fields->articleplo == '4' && $this->fields->articleplo !== null): ?>
              <div class="ui top right attached label"><h4><?php $this->fields->articleplonr() ?> </h4></div>
              <?php endif; ?>
              <?php endif; ?>
              <h1 class="post-title" style="word-wrap:break-word;overflow:hidden;"><?php $this->title() ?></h1>
<div class="post-meta"><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><span> | </span><span class="category"><?php $this->category(','); ?></span><?php if($this->fields->Hot == '1'): ?> | <span><i class="hotjar icon"></i>??????:<?php _e(getViewsStr($this));?>??C</span><?php endif; ?> | <button class="ui mini gray icon button" id="fontsizes"><i class="font icon"></i></button><?php if($this->options->Readmode == "1"): ?><button class="ui mini gray icon button" id="read"><i class="book icon"></i></button><?php endif; ?><?php if($this->user->group == 'administrator'): ?>|  <button onclick="window.open('<?php $this->options->adminUrl('/write-post.php?cid='.$this->cid); ?>','_self')" class="ui mini gray icon button"><i class="pencil icon"></i></button><?php endif; ?><?php if($this->options->Poster == '1' && $this->fields->Poster == '1'): ?>| <button href="#" onclick="show_bearstudio_poster_ykzn();return false;" class="ui mini gray icon button">???????????????</button><?php endif; ?> </div>



<a style="float:right" href="#comments"><i class="comment alternate outline icon"></i></a>
<div class="post-content"><div id="para">
<?php if ($this->fields->Overdue && $this->fields->Overdue !== 'close' && floor((time() - ($this->modified)) / 86400) > $this->fields->Overdue) : ?>
<div class="ui warning icon message">
  <i class="exclamation circle loading icon"></i>
  <div class="content">
    <div class="header">
???????????????</div>
 <p>
?????????????????????<?php echo date('Y???m???d???' , $this->modified);?>????????????<?php echo floor((time()-($this->modified))/86400);?>???????????????????????????????????????????????????????????????
 </p>
 </div>
</div>
<?php endif; ?>
<p>
  
<?php if($this->hidden||$this->titleshow): ?>
    <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<form action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>" method="post" id="form">
<div class="ui form warning">
  <div class="field">
    <label>???????????????????????????????????????????????????</label>
    <input type="password" class="text" name="protectPassword" id="protectPassword" placeholder="?????????????????????">
    <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>" />
  </div>
  <div class="ui warning message">
    <div class="header">Tips:</div>
    <ul class="list">
      <li>???????????????????????????,??????????????????????????????????????????~</li>
    </ul>
  </div>
  <button class="ui blue submit button" type="submit">??????</button>
</div>
</form>
<?php else: ?>
<?php echo ShortCode($this->content,$this,$this->user->hasLogin()); ?>
<?php endif;?></p></div></div>

    <?php if($this->fields->tags == '1'): ?><br>
<div class="ui tag label"><font color="gray">??????:</font><?php $this->tags('  ', true, '????????????'); ?></div><?php endif; ?>

  <?php if($this->fields->copyright == '1'): ?>
<div class="ui icon message">
  <i class="copyright outline icon"></i>
  <div class="content">
    <div class="header" style="word-break:break-all;">
      ???????????????<?php $this->author() ?> ?????????<?php if($this->fields->copyright_cc !== null && $this->fields->copyright_cc !== 'zero') :?>?????????<?php echo copyright_cc($this->fields->copyright_cc);?>??????????????????<?php endif; ?>??????????????????????????????
    </div>
    <p style="word-break:break-all;">??????????????? <a href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a></p>
  </div>
</div>
<?php endif; ?>

<div class="ui divided selection list">
    <div class="item">
    <div class="ui horizontal label">?????????</div>
    <?php $this->thePrev('%s','?????????'); ?>
 </div>
   <div class="item">
    <div class="ui horizontal label">?????????</div>
    <?php $this->theNext('%s','?????????'); ?>
  </div>
</div>
<?php article_module_output($this); ?>
</div></div></div>
 <div class="ui <?php if($this->options->commentType == "1"): ?>raised<?php endif; ?><?php if($this->options->commentType == "2"): ?>stacked<?php endif; ?><?php if($this->options->commentType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->commentType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->commentradius): ?>style="border-radius:<? $this->options->commentradius(); ?>px"<?php endif; ?>>
    <?php $this->need('comments.php'); ?>
</div>
<?php if($this->options->Poster == '1' && $this->fields->Poster == '1'): ?>
<?php $this->need('modules/MakePost/poster.php'); ?>
<?php endif; ?>
