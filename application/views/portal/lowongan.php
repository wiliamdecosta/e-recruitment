<div class="row">
    <div class="col-md-12">
        <div class="blog-posts single-post">

            <article class="post post-large blog-single-post">
                <div class="post-image">
                    <div class="owl-carousel owl-theme" data-plugin-options='{"items":1}'>
                        <div>
                            <div class="img-thumbnail">
                                <img class="img-responsive" src="img/pdam_tirta.jpg" alt="">
                            </div>
                        </div>

                    </div>
                </div>

        </div>
    </div>
</div>

<div class="row">
    <h4> Silahkan login untuk apply lamaran.</h4>
    <div class="col-md6">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Nomor Lowongan
                </th>
                <th>
                    Kode Lowongan
                </th>
                <th>
                    Deskripsi
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($job as $row){

                ?>

            <tr>
                <td>
                   <?php echo $i;?>
                </td>
                <td>
                    <?php echo $row->posting_no;?>
                </td>
                <td>
                    <?php echo $row->job_code;?>
                </td>
                <td>
                    <?php echo $row->job_name;?>
                </td>
            </tr>
            <?php $i++;
            }
            ?>
            </tbody>
        </table>
    </div>

</div>