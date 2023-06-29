<?php
/**
 * Call To Action Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
  $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class_name = 'testimonial-block';
if ( ! empty( $block['className'] ) ) {
  $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
  $class_name .= ' align' . $block['align'];
}

// Custom styles
$styles = array( 'background: #E8EDF3', 'color: #000000', 'max-width: 1280px' );
$style  = implode( '; ', $styles );

$heading = get_field( 'heading' );
$title = get_field( 'title' );
$sub_title = get_field( 'sub_title' );
$primary = get_field( 'primary_button' );
$secondary = get_field( 'secondary_button' );

/**
 * Get Text color
 */
$text_color = '';
if ( ! empty( $block['textColor'] ) ) {
  $text_color .= ' hass-text-color';
  $text_color .= ' has-' . $block['textColor'] . '-color';
}

/**
 * Get the background color
 */
$background_color = '';
if ( ! empty( $block['backgroundColor'] ) ) {
  $background_color .= ' has-background';
  $background_color .= ' has-' . $block['backgroundColor'] . '-background-color';
}

?>

<div <?php echo $anchor ?> class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_html( $background_color ); ?>">
  <div class="cta-container">
    <div class="heading"><?php echo esc_html( $heading ); ?></div>
    <div class="title <?php echo esc_html( $text_color ) ?>"><?php echo esc_html( $title ); ?></div>
    <div class="description">
      <p class="sub-title <?php echo esc_html( $text_color ) ?>"><?php echo esc_html( $sub_title ); ?></p>
    </div>
    <div class="action-container">
      <a href="#" class="action primary"><?php echo esc_html( $primary ); ?></a>
      <a href="#" class="action secondary"><?php echo esc_html( $secondary ); ?></a>
    </div>
  </div>
</div>
