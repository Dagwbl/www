 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
                     <?php if(Bsoptions('AdControl') == true) :?>
<?php if(Bsoptions('AdControl4') == true && !empty(Bsoptions('>AdControl4Src'))) :?>
<?php billboard(Bsoptions('AdControl4Src'),'other'); ?>
  <?php endif; ?><?php endif; ?>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
                    <center>
                    <h3 class="ui header">
  <i class="edit outline
 icon"></i>
  <div class="content">
    <?php $this->archiveTitle(array(
            'category'  =>  _t('分类「%s」下的文章'),
            'search'    =>  _t('包含关键字「%s」的文章'),
            'tag'       =>  _t('标签「%s」下的文章'),
            'author'    =>  _t('「%s」发布的文章')
        ), '', ''); ?>
       <?php if($this->is('category')): ?>
<div class="sub header"><?php echo $this->getDescription(); ?></div><?php endif; ?>
  </div>
</h2></center><br>

  
<?php if(Bsoptions('Slidersss') == true && Bsoptions('SliderOthers') == true) :?>
  <div class="bearslider" style="display:none">
      <?php foreach (Bsoptions('slider__content') as $sliderpic) { ?>
  <div hrefs="<?php echo $sliderpic['slider__url'];?>"><img class="lazyload" src="<?php echo $sliderpic['slider__pic'];?>" title="<?php echo $sliderpic['slider__title'];?>"></div>
  <?php } ?>
</div>

<?php endif; ?>

 <?php if ($this->have()): ?>
<?php if(Bsoptions('Article_forma') == "4"): ?>		
   <?php while($this->next()): ?>

<div class="ui vertical segment">
 <h2 class="post-title"><?php $this->sticky() ?><a href="<?php $this->permalink() ?>" class="header" style="margin-top:5px" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a> 	<?php if(Bsoptions('Article_time') == true): ?><div class="ui gray horizontal label"><?php $this->date(); ?></div><?php endif; ?></h2>


<?php if(Bsoptions('Article_expert') == true): ?>
<p>
 
<?php if($this->fields->excerpt !== null): ?>
			<?php echo cutexpert($this->excerpt,articledecnum());?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>

</p>
<?php endif; ?>
      
  
</div>
 	<?php endwhile; ?>
 	<?php endif; ?>
 	
<?php if(Bsoptions('Article_forma') == "1"): ?>	
<?php while($this->next()): ?>
  <div class="bs-simplestyle-container">
  <div class="bs-simplestyle-column">
   
    <div class="bs-simplestyle-post-module" <?php if(Bsoptions('articleradius')): ?>style="border-radius:<?php echo Bsoptions('articleradius'); ?>px"<?php endif; ?>>
      <div class="bs-simplestyle-thumbnail" <?php if(Bsoptions('articleradius')): ?>style="border-radius:<?php echo Bsoptions('articleradius'); ?>px <?php echo Bsoptions('articleradius'); ?>px 20px 20px"<?php endif; ?>>
          <?php if(thumb2($this) !== "null"): ?>
          <img src="<?php echo thumb2($this); ?>"><?php else: ?><img src="<?php AssetsDir();?>assets/images/cover.png"><?php endif; ?></div>
      <div class="bs-simplestyle-post-content" <?php if(Bsoptions('articleradius')): ?>style="border-radius:0 <?php echo Bsoptions('articleradius'); ?>px <?php echo Bsoptions('articleradius'); ?>px <?php echo Bsoptions('articleradius'); ?>px"<?php endif; ?>>
        <?php if(Bsoptions('show_cate') == true && !empty($this->category)): ?><div class="bs-simplestyle-category" <?php if(Bsoptions('articleradius')): ?>style="border-radius:0 <?php echo Bsoptions('articleradius'); ?>px <?php echo Bsoptions('articleradius'); ?>px <?php echo Bsoptions('articleradius'); ?>px 0"<?php endif; ?>><?php $this->category('<bsvi style=\'display:none\'>',false); ?></bsvi></div><?php endif; ?>
        <h1 class="bs-simplestyle-title"><?php $this->sticky() ?><a href="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a></h1>
        <?php if(Bsoptions('Article_expert') == true): ?><p class="bs-simplestyle-description"><?php if($this->fields->excerpt == null): ?><?php echo cutexpert($this->excerpt,articledecnum());?><?php else: ?><?php $this->fields->excerpt(); ?><?php endif; ?></p><?php endif; ?>
        <?php if(Bsoptions('Article_time') == true || Bsoptions('show_comment') == true): ?>
        <div class="bs-simplestyle-post-meta"><?php if(Bsoptions('Article_time') == true): ?><span class="bs-simplestyle-timestamp"><i class="time icon"></i> <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time></span><?php endif; ?><?php if(Bsoptions('show_comment') == true): ?><span class="bs-simplestyle-comments"><i class="comment icon"></i> <?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></span><?php endif; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endwhile; ?>

 	<?php endif; ?>
 	
 	<?php if(Bsoptions('Article_forma') == "5"): ?>	
 	   <?php while($this->next()): ?>
  <div class="blog-card" <?php if(Bsoptions('articleradius')): ?>style="border-radius:<?php echo Bsoptions('articleradius'); ?>px"<?php endif; ?>>
    <div class="meta">
      <div class="photo" style="background-image: url(<?php if(thumb($this) !== "null"): ?><?php echo thumb($this); ?><?php else:?><?php AssetsDir();?>assets/images/newstyle_default.jpg<?php endif; ?>)"></div>
    </div>
    <div class="description">
      <h1><?php $this->sticky(); ?><a href="<?php $this->permalink(); ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a></h1>
      <?php if(Bsoptions('Article_time') == true): ?>
      <h2><?php $this->date(); ?></h2>
      <?php endif; ?>
      <?php if(Bsoptions('Article_expert') == true): ?>
      <?php if($this->fields->excerpt == null): ?>
      <p><?php echo cutexpert($this->excerpt,articledecnum());?></p>
      	<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<p><?php $this->fields->excerpt(); ?></p>
			<?php endif; ?><?php else:?><p></p><?php endif; ?>
      <p class="read-more">
        <a href="<?php $this->permalink() ?>" class="ui button" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>>阅读全文<i class="angle double right icon"></i></a>
      </p>
    </div>
  </div>
   <?php endwhile; ?>
   <?php endif; ?>
   
<?php if(Bsoptions('Article_forma') == "2" || Bsoptions('Article_forma') == null): ?>
	<?php while($this->next()): ?>


<div class="ui <?php if(Bsoptions('textType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('textType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('textType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('textType') == "4"): ?>piled<?php endif; ?> segment diymode" <?php if(Bsoptions('articleradius')): ?>style="border-radius:<?php echo Bsoptions('articleradius'); ?>px"<?php endif; ?>>
<div class="post">
			<h1 class="post-title"><?php $this->sticky() ?><a itemprop="url" href="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a></h1>
	
				<?php if(Bsoptions('Article_time') == true || Bsoptions('show_comment') == true || Bsoptions('show_cate') == true): ?>
<div class="post-meta">
			<?php if(Bsoptions('Article_time') == true): ?><i class="time outline icon"></i><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><?php endif; ?><?php if(Bsoptions('show_cate') == true):?> | <i class="folder outline icon"></i><?php $this->category(','); ?><?php endif; ?><?php if(Bsoptions('show_comment') == true):?> | <i class="comment outline icon"></i><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('0', '1', '%d'); ?></a><?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if(Bsoptions('Article_expert') == true): ?>
			<div class="post-content">
				    <?php if($this->fields->excerpt == null): ?>
	
			<?php echo cutexpert($this->excerpt,articledecnum());?>
			
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>
			</div><?php endif; ?><br><p class="readmore" style="float:right;"><a href="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><i class="angle double right icon"></i>阅读全文</a></p></div>
</div>
			
	<?php endwhile; ?>
<?php endif; ?>
<?php if(Bsoptions('Article_forma') == "3"): ?>
  <?php while($this->next()): ?>
                    <div class="wrappers" hrefs="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>>
		  <div class="cols">
					<div class="col">
						<div class="container">
						    <?php if(thumb2($this) !== "null"): ?>
							<div class="front" style="background-image: url(<?php echo thumb2($this); ?>)">
							    <?php else: ?>
							    <div class="front" style="background-image: url(<?php AssetsDir();?>assets/images/cover.png)">
							        <?php endif; ?>
							
								<div class="inner">
								   
									<p><?php $this->sticky() ?><a style="color:white"><?php echo cutexpert($this->title,articletitlenum()) ?></a></p>
	 <?php if(Bsoptions('Article_expert') == true): ?>
		              <span><?php if($this->fields->excerpt == null): ?>
			<?php echo cutexpert($this->excerpt,articledecnum());?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?> </span>	
			<?php endif; ?>
			<?php if(Bsoptions('Article_time') == true): ?><div class="post-meta" style="padding-top:30px">
  <div class="ui mini inverted statistic">
    <div class="value">
      <?php $this->date(); ?>
    </div>
    <div class="label">
     发表时间
    </div>
  </div>
			</div>
			<?php endif; ?>
								</div>
								
							</div>
					
						</div>
					</div>
				</div>
		 </div>
		<?php endwhile; ?>
<?php endif; ?>
<?php else :?>
<article class="post">
        <center><svg t="1617683554811" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2629" width="200" height="200"><path d="M817.152 346.112c0-12.8-10.752-23.552-23.552-23.552h-28.672v281.6l-181.76 182.272H361.472v15.36c0 12.8 10.752 23.552 23.552 23.552l254.976-2.56 180.224-184.32-3.072-292.352z" fill="#E3EAED" p-id="2630"></path><path d="M332.8 705.536H258.56c-18.432 0-32.768-14.336-32.768-32.768V223.232c0-18.432 14.336-32.768 32.768-32.768H604.16c4.608 0 9.216 4.096 9.216 9.216 0 4.608-4.096 9.216-9.216 9.216H258.56c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336H332.8M686.08 299.52v-51.2c0-4.608 4.096-9.216 9.216-9.216 4.608 0 9.216 4.096 9.216 9.216v51.2" fill="#D3DBDE" p-id="2631"></path><path d="M608.768 797.184H350.208c-18.432 0-32.768-14.336-32.768-32.768V315.392c0-18.432 14.336-32.768 32.768-32.768h413.184c18.432 0 32.768 14.336 32.768 32.768v294.912l-187.392 186.88z m-258.56-496.64c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336h251.392l176.128-176.128v-286.72c0-7.68-6.656-14.336-14.336-14.336H350.208z" fill="#D3DBDE" p-id="2632"></path><path d="M601.088 778.752l177.152-176.128V322.56H394.752c-12.8 0-23.552 11.264-23.552 24.576v431.616h229.888z" fill="#F2F5F7" p-id="2633"></path><path d="M613.888 788.992h-18.432v-110.08c0-44.032 36.352-80.384 80.384-80.384h103.936v17.92H675.84c-34.304 0-62.464 27.648-62.464 62.464l0.512 110.08z m45.056-350.72H453.12c-6.656 0-12.288-5.632-12.288-12.288 0-6.656 5.632-12.288 12.288-12.288h205.824c6.656 0 12.288 5.632 12.288 12.288 0 7.168-5.632 12.288-12.288 12.288z m0-11.776v6.144-6.144z m1.536 71.168H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m0 71.68H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m-10.752-451.072c-5.12 0-9.216 4.096-9.216 9.216v61.44c0 5.12 4.096 9.216 9.216 9.216 4.608 0 9.216-4.096 9.216-9.216v-61.44c0-4.608-4.096-9.216-9.216-9.216z m114.688 17.408c-4.096-3.072-9.728-2.048-12.8 2.048l-35.84 49.664c-3.072 4.096-2.048 9.728 2.048 12.8 2.048 1.024 3.584 2.048 5.632 2.048 3.072 0 5.632-1.024 7.168-3.584l35.84-49.664c2.56-4.608 2.048-10.24-2.048-13.312z m58.88 71.168c-2.048-5.12-7.168-6.656-12.288-4.096l-55.296 25.6c-5.12 2.048-6.656 7.168-4.096 12.288 2.048 3.584 5.12 5.632 8.704 5.632 1.024 0 2.56 0 3.584-0.512l55.296-25.6c4.096-3.584 6.144-8.704 4.096-13.312z" fill="#D3DBDE" p-id="2634"></path></svg></center>
                <center><h2>暂无文章</h2></center>
            </article>
<?php endif; ?>
<?php if(Bsoptions('infinite_scroll') == false || empty(Bsoptions('infinite_scroll'))): ?>
<?php
      ob_start(); 
      $this->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      if(Bsoptions('pagination_style') == '2'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<nav class="page-navigator">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<span class="page-number">...</span>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1"><i class="arrow left icon"></i>上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1"><i class="arrow right icon"></i>下一页</a>', $content);
      $content = preg_replace("/<\/ol>/sm", '</nav>', $content);
      }
      if(empty(Bsoptions('pagination_style')) || Bsoptions('pagination_style') == '1'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui circular labels" style="margin-top:30px"><div style="text-align:center">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<a class="ui large label">...</a>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui black large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      $content = preg_replace("/<\/ol>/sm", '</div></div>', $content);
      }
      echo $content;
     ?>
    
     <?php endif; ?>

  </div>
     <?php if ($this->have()): ?>
<?php if(Bsoptions('infinite_scroll') == true): ?>
<div class="pagination" style="display:none;">
                   
                    <?php $this->pageLink('下一页','next'); ?>
               </div>
<div class="page-load-status" style="display:none;">
<div class="ui active centered inline loader infinite-scroll-request" style="margin-top:20px"></div>

 <h2 class="ui icon header infinite-scroll-last">
  <em data-emoji=":astonished:" class="medium"></em>
  <div class="content" style="margin-top:5px">
    啊哦，已经到底啦～
  </div>
</h2>

<h2 class="ui icon header infinite-scroll-error">
  <em data-emoji=":anguished:" class="medium"></em>
  <div class="content" style="margin-top:5px">
    啊哦，加载错误啦～
  </div>
</h2>

</div>

<?php if(categorynum(categoryid($this->getArchiveSlug())) > Bsoptions('infinite_pageSize')): ?>
<center><button class="ui right labeled icon button" id="bsnext" style="margin-top:20px;">
  <i class="right arrow icon"></i>
  加载更多
</button></center>
<?php else: ?><center><br>
<h2 class="ui icon header">
  <em data-emoji=":astonished:" class="medium"></em>
  <div class="content" style="margin-top:5px">
    啊哦，已经到底啦～
  </div>
</h2></center>
  <?php endif; ?>

  <?php endif; ?><?php else:?>

  <?php endif; ?></div>