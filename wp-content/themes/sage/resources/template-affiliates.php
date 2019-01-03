<?php
/* Template Name: Affiliates */
get_header();
query_posts(array(
    'post_type' => 'affiliates'
));
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="container-fluid">
<?php while(have_posts()) : the_post(); ?>
<div class="panel panel-default w-25"  style="margin: 0 auto;">
    <div class="panel-heading"><?php the_post_thumbnail(); ?></div>
    <div class="panel-body"><?php the_content(); ?></div>
    <div class="panel-footer clearfix">
        <a href="<?php the_excerpt(); ?>" class="btn btn-primary btn-lg btn-block"><i class="glyphicon glyphicon-hand-up"></i> Sign Up Now!</a>
    </div>
</div>
<?php
endwhile;
get_footer();
?>
</div>