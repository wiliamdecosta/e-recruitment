<div class="row">
    <div class="col-md-12">
        <div class="blog-posts">

            <article class="post post-large">


                <div class="post-date">
                    <span class="day">15</span>
                    <span class="month">Juni</span>
                </div>

                <div class="post-content">

                    <h2><a href="#">Pengumuman Hasil Tes Bahasa Inggris Calon PNS PDAM Bandung </a></h2>
                    <p>Berikut hasil pengumuman calon PNS PDAM Bandung..</p>

                    <div class="post-meta">
                        <span><i class="fa fa-user"></i> By <a href="#">Admin</a> </span>
                        <a href="#" class="btn btn-xs btn-primary pull-right readmore"
                            id="<?php echo site_url('portal/pengumuman'); ?>">Read more...</a>
                    </div>

                </div>
            </article>

            <article class="post post-large">

                <div class="post-date">
                    <span class="day">22</span>
                    <span class="month">Juni</span>
                </div>

                <div class="post-content">

                    <h2><a href="#">Pengumuman Peserta Lulus Rekrutmen CPNS PDAM 2016</a></h2>
                    <p>Berikut hasil pengumuman calon PNS PDAM Bandung..</p>

                    <div class="post-meta">
                        <span><i class="fa fa-user"></i> By <a href="#">Admin</a> </span>
                        <a href="#" class="btn btn-xs btn-primary pull-right readmore"
                           id="<?php echo site_url('portal/pengumuman'); ?>">Read more...</a>
                    </div>

                </div>
            </article>


        </div>
    </div>

    <script type="text/javascript">
        $('.readmore').click(function () {
            var url = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: url,
                data: {},
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