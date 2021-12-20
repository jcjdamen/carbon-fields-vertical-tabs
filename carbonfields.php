<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    Container::make('post_meta', __('Page settings', 'sage'))
        ->where('post_type', '=', 'page')
        ->set_classes('cf-container__vertical-tabs')
        ->add_tab(__('Layout', 'sage'), [
            Field::make('radio', 'page_hide_logo', esc_attr__('Hide logo', 'sage'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the logo at the top of your page. You can set this option to yes.', 'sage'))
                ->set_options([
                    'no' => esc_attr(__('No', 'sage')),
                    'yes' => esc_attr(__('Yes', 'sage'))
                ])
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_menu', esc_attr__('Hide menu', 'sage'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the primary navigation at the top of your page. You can set this option to yes.', 'sage'))
                ->set_options([
                    'no' => esc_attr(__('No', 'sage')),
                    'yes' => esc_attr(__('Yes', 'sage'))
                ])
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_header', esc_attr__('Hide header', 'sage'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the header at the top of your page. You can set this option to yes.', 'sage'))
                ->set_options([
                    'no' => esc_attr(__('No', 'sage')),
                    'yes' => esc_attr(__('Yes', 'sage'))
                ])
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_footer', esc_attr__('Hide footer', 'sage'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the footer at the top of your page. You can set this option to yes.', 'sage'))
                ->set_options([
                    'no' => esc_attr(__('No', 'sage')),
                    'yes' => esc_attr(__('Yes', 'sage'))
                ])
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_title', esc_attr__('Hide title', 'sage'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show a title at the top of your page. You can set this option to yes.', 'sage'))
                ->set_options([
                    'no' => esc_attr(__('No', 'sage')),
                    'yes' => esc_attr(__('Yes', 'sage'))
                ])
                ->set_default_value('no'),
        ])
        ->add_tab(__('Content', 'sage'), [
            Field::make('select', 'header_alignment', __('Header alignment', 'sage'))
                ->set_conditional_logic([
                    'relation' => 'AND', [
                        'field' => 'header_size',
                        'value' => true,
                        'compare' => '='
                    ]
                ])
                ->set_help_text(__('In some cases, you may want to adjust the alignment of the title, breadcrumbs and subtitle.', 'sage'))
                ->set_options([
                    'text-center mx-auto' => __('Center', 'sage'),
                    'text-center text-md-left' => __('Left', 'sage'),
                    'text-center text-md-right ' => __('Right', 'sage'),
                ]),

        ]);
});

add_action('after_setup_theme', function () {
    //require_once('vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
});


