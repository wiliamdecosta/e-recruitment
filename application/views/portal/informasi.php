<div class="row">
    <div class="col-md-12">
        <div class="blog-posts">
            <?php foreach($announcer as $row){?>
            <article class="post post-large">
                <div class="post-date">
                    <span class="day"><?php echo date("d", strtotime($row->announcement_date));?></span>
                    <span class="month"><?php echo date("M", strtotime($row->announcement_date));?></span>
                </div>

                <div class="post-content">
                    <h2><a href="#" id="<?php echo $row->announcement_id?>" class="title_announcer"><?php echo $row->announcement_title;?> </a></h2>
                    <!--<p><?php /*echo html_entity_decode(substr($row->announcement_letter,0,60));*/?></p>-->

                    <div class="post-meta">
                        <span><i class="fa fa-user"></i> By <a href="#"><?php echo $row->created_by?></a> </span>
                        <!--<br>&nbsp;&nbsp;<br>
                        <a href="#" class="btn btn-xs btn-primary"
                           id="<?php /*echo $row->announcement_id*/?>">Read more...</a>-->
                    </div>

                </div>
            </article>
        <?php }?>
        </div>
    </div>

    <script type="text/javascript">
        $('.title_announcer').click(function () {
            var url = "<?php echo site_url('portal/getAnnouncer');?>";
            var id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: url,
                data: {id:id},
                success: function (data) {
                    $("#mid_content").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#mid_content").html(errorThrown);
                },
                timeout: 10000 // sets timeout to 10 seconds
            });
            return false;


        })
    </script>