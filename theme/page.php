<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampStart = $time;
?>

<?php get_header(); ?>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampEndHeader = $time;
?>

<div class="wrapper">
    <?php the_title('<h1>', '</h1>'); ?>
    <?php the_post(); ?>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampBeginContent = $time;
?>
    <?php the_content(); ?>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampEndContent = $time;
?>




    <p><?php echo the_favorites_button(); ?></p>
    <?php edit_post_link( __( 'Edit', 'TB2017' ), '<span class="edit-link">', '</span>' ) ?>
</div>


<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$timestampBeginFooter = $time;
?>
<?php get_footer(); ?>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $timestampStart), 4);
$total_header_time = round(($timestampEndHeader - $timestampStart), 4);
$total_begin_content_time = round(($timestampBeginContent - $timestampEndHeader), 4);
$total_end_content_time = round(($timestampEndContent - $timestampBeginContent), 4);
$total_begin_footer_time = round(($timestampBeginFooter - $timestampEndContent), 4);
$total_end_footer_time = round(($finish - $timestampBeginFooter), 4);
// echo '<p>Begin Load: ' . $timestampStart . '</p>';
// echo '<p>End Header: ' . $timestampEndHeader . '</p>';
// echo '<p>End Load: ' . $finish . '</p>';

echo '<div class="wrapper">';
echo '<p>Seconds to load header: '.$total_header_time.'</p>';
echo '<p>Seconds before loading the_content: '.$total_begin_content_time.'</p>';
echo '<p>Seconds to load the_content: '.$total_end_content_time.'</p>';
echo '<p>Seconds before loading footer: '.$total_begin_footer_time.'</p>';
echo '<p>Seconds to load footer: '.$total_end_footer_time.'</p>';
echo '<hr />';
echo '<p>Page generated in '.$total_time.' seconds.</p>';
echo '</div>';
?>