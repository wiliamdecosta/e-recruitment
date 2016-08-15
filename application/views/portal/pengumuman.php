<div class="row">
    <div class="col-md-12">
        <div class="blog-posts">

            <article class="post post-large">
                <?php foreach($announcer as $row){?>

                <div class="post-date">
                    <span class="day"><?php echo date("d", strtotime($row->announcement_date));?></span>
                    <span class="month"><?php echo date("M", strtotime($row->announcement_date));?></span>
                </div>

                <div class="post-content">

                    <h2><a href="#"><?php echo $row->announcement_title;?></a></h2>

                    <div class="post-meta">
                        <span><i class="fa fa-user"></i> By <a href="#"><?php echo $row->created_by?></a> </span>

                    </div>

                    <?php echo html_entity_decode($row->announcement_letter);?>

                    <div class="post-block post-share">
                        <h3 class="heading-primary"><i class="fa fa-share"></i>Share this post</h3>
                    </div>



            </article>
        <?php }?>

        </div>
    </div>

</div>