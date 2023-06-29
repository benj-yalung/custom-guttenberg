<?php

function register_acf_blocks() {
    register_block_type( __DIR__ . '/block-cta' );
    register_block_type( __DIR__ . '/block-tide' );
}
add_action( 'init', 'register_acf_blocks' );