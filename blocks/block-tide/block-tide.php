<?php
/**
 * Tide Forecast Block Template.
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

$class_name = 'tide-block';
if ( ! empty( $block['className'] ) ) {
  $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
  $class_name .= ' align' . $block['align'];
}

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

/**
 * Get the tide predictions using Marea APi and Melbourne Williamstown, Australia station,
 * data receeived using get all stations using Marea API
 * {
 *    "id": "GESLA3:28905ce016",
 *    "name": "Melbourne Williamstown",
 *    "country": "Australia",
 *    "latitude": -37.8657,
 *    "longitude": 144.9165
 * }
 */

$current_date = date('j F');
$current_year = date('Y');

$args = [
  'headers' => [
    'Content-Type' => 'application/json',
    'x-marea-api-token' => '8a8d3741-b83e-469b-a53d-97221f6bcf31'
  ],
  'body' => [
    'station_id' => 'GESLA3:28905ce016'
  ]
];

$api_url = 'https://api.marea.ooo/v2/tides';

$response = wp_remote_get( $api_url, $args );

$response_body = wp_remote_retrieve_body( $response );

$result = json_decode( $response_body );

$low_tide = [];
$high_tide = [];

if(isset($result->extremes)) {
  foreach ( $result->extremes as $extreme ) {
    if ( $extreme->state === 'LOW TIDE' && $low_tide === [] ) {
      $low_tide['height'] = number_format( (float) $extreme->height, 2, '.', '' ) . $result->unit;
      $date_time = date_create( $extreme->datetime );
      $low_tide['time'] = date_format( $date_time, 'g:ia' );
      $low_tide['title'] = 'Low Tide';
    }

    if ( $extreme->state === 'HIGH TIDE' && $high_tide === [] ) {
      $high_tide['height'] = number_format( (float) $extreme->height, 2, '.', '' ) . $result->unit;
      $date_time = date_create( $extreme->datetime );
      $high_tide['time'] = date_format( $date_time, 'g:ia' );
      $high_tide['title'] = 'High Tide';
    }
  }
}

?>

<div <?php echo $anchor ?> class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_attr( $background_color ) ?>">
  <div class="box_wrapper <?php echo esc_attr( $text_color ) ?>">
    <div class="title"><?php echo esc_html( $current_date ); ?></div>
    <div class="sub_title"><?php echo esc_html( $current_year ); ?></div>
  </div>
  <div class="box_wrapper <?php echo esc_attr( $text_color ) ?>">
    <div class="title"><?php echo esc_html( $high_tide['height'] ?? '0.00m' ) ?> | <?php echo esc_html( $high_tide['time'] ?? '12:00am' ); ?></div>
    <div class="sub_title"><?php echo esc_html( $high_tide['title'] ?? 'High Tide' ); ?></div>
  </div>
  <div class="box_wrapper <?php echo esc_attr( $text_color ) ?>">
    <div class="title"><?php echo esc_html( $low_tide['height'] ?? '0.00m' ) ?> | <?php echo esc_html( $low_tide['time'] ?? '12:00pm' ); ?></div>
    <div class="sub_title"><?php echo esc_html( $low_tide['title'] ?? 'Low Tide' ); ?></div>
  </div>
</div>