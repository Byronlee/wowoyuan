<?php if (!defined('THINK_PATH')) exit();?>              
<div class="navbox">
  <ul class="nav">
    <div class="class_all">园内&#8226微区</div>    
     <?php $m=1; ?>
       <?php foreach($menut as $key =>$value){ ?>
                       
       <li id="class_first"><?php echo ($key); ?></li>
                <?php $n=1; ?>
                <?php foreach($value as $values){ ?>
                                
        <li>   
            <?php if($m==4&&$n==1){ ?>
          <a href="__URL__/rank_teacher/_first/<?php echo ($m); ?>/_se/<?php echo ($n); ?>/class_fs/<?php echo (md($m+$n)); ?>" class="class_second"><?php echo ($values); ?></a>
          <?php }else if($m==4&&$n==2){ ?>
          <a href="__URL__/rank_fans/_first/<?php echo ($m); ?>/_se/<?php echo ($n); ?>/class_fs/<?php echo (md($m+$n)); ?>" class="class_second"><?php echo ($values); ?></a>
          <?php }else{ ?>
          <a href="__URL__/forum_class/_first/<?php echo ($m); ?>/_se/<?php echo ($n); ?>/class_fs/<?php echo (md($m+$n)); ?>" class="class_second"><?php echo ($values); ?></a>
          <?php } ?>
          </li>
                   <?php $n++;} ?>
              <?php $m++;} ?>

  </ul>
</div>