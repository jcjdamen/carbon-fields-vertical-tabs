<?php

/**
 * Define Carbon fields
 */

namespace App;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Get a list of published pages and wrap them in an array
 *
 * @return array
 */
function getPublishedPages(): array
{
    $pages = get_pages(['post_status' => 'publish', 'orderby' => 'DESC',]);
    $array = [];
    foreach ($pages as $page) {
        $array[NULL] = "";
        $array[$page->ID] = $page->post_title;
    }
    return $array;
}

/**
 * Function for easly return no / yes answers (radio buttons)
 * @return array
 */
function yesNoValues(): array
{
    return [
        'no' => esc_attr(__('No', 'unity-theme')),
        'yes' => esc_attr(__('Yes', 'unity-theme'))
    ];
}

/**
 * Register fields
 *
 * @return void
 */
add_action('carbon_fields_register_fields', function () {

    /**
     * Categories
     * @link https://docs.carbonfields.net/learn/containers/term-meta.html
     */
    Container::make('term_meta', __('Category Properties', 'unity-theme'))
        ->where('term_taxonomy', '=', 'category')
        ->add_fields([
            Field::make('select', 'crb_cat_page_id', __('Select a page', 'unity-theme'))
                ->help_text(__('Select a page to replace the the category url in the breadcrumbs for the page url.', 'unity-theme'))
                ->set_options(getPublishedPages())
        ]);

    /**
     * Theme settings
     * @link https://docs.carbonfields.net/learn/containers/theme-options.html
     */
    Container::make('theme_options', __('Unity Theme', 'unity-theme'))
        ->set_page_file('theme-options')
        ->set_page_menu_position(2)
        ->set_icon('dashicons-layout')
        ->set_page_menu_title(__('Theme Settings', 'unity-theme'))
        ->set_classes('cf-container__vertical-tabs')
        ->add_tab(__('Default settings', 'unity-theme'), [
            Field::make('separator', 'crb_logo_separator', __('Logo', 'unity-theme')),
            Field::make('image', 'crb_logo', __('Default logo', 'unity-theme'))
                ->help_text(__('Select an image file for your logo.', 'unity-theme')),
            Field::make('separator', 'crb_hello_bar_separator', __('Hello Bar', 'unity-theme')),
            Field::make('radio', 'crb_hello_bar', esc_attr__('Enable Hello Bar', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases you want to show the hello bar on your website . You can set this option to yes', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('text', 'crb_hello_bar_title', __('Title', 'unity-theme'))
                ->set_conditional_logic([
                    'relation' => 'AND', // Optional, defaults to "AND"
                    [
                        'field' => 'crb_hello_bar',
                        'value' => 'yes', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                        'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                    ]
                ]),
            Field::make('text', 'crb_hello_bar_btn_text', __('Button text', 'unity-theme'))
                ->set_conditional_logic([
                    'relation' => 'AND', // Optional, defaults to "AND"
                    [
                        'field' => 'crb_hello_bar',
                        'value' => 'yes', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                        'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                    ]
                ]),
            Field::make('text', 'crb_hello_bar_btn_url', __('Button url', 'unity-theme'))
                ->set_conditional_logic([
                    'relation' => 'AND', // Optional, defaults to "AND"
                    [
                        'field' => 'crb_hello_bar',
                        'value' => 'yes', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                        'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                    ]
                ]),
            Field::make('separator', 'crb_scripts_separator', __('Scripts', 'unity-theme')),
            Field::make('header_scripts', 'crb_header_scripts', __('Header Scripts', 'unity-theme')),
            Field::make('footer_scripts', 'crb_footer_scripts', __('Footer Scripts', 'unity-theme')),
        ])
        ->add_tab(__('Sidebars', 'unity-theme'), [
            Field::make('separator', 'crb_sidebar_settings', __('Sidebar settings', 'unity-theme')),
            Field::make('radio', 'crb_post_sidebar', esc_attr__('Enable on posts', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases you want to enable the glossary post type. You can set this option to yes', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'crb_page_sidebar', esc_attr__('Enable on pages', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases you want to enable the glossary post type. You can set this option to yes', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'crb_blog_archive_sidebar', esc_attr__('Enable on blog', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases you want to enable the glossary post type. You can set this option to yes', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),

        ])
        ->add_tab(__('Posts', 'unity-theme'), [
            Field::make('separator', 'crb_posts_settings', __('Post settings', 'unity-theme')),
        ])
        ->add_tab(__('Pages', 'unity-theme'), [
            Field::make('separator', 'crb_page_settings', __('Page settings', 'unity-theme')),
        ])
        ->add_tab(__('Modules', 'unity-theme'), [
            Field::make('separator', 'crb_cpt_settings', __('Custom Post Type settings'), 'unity-theme'),
            Field::make('radio', 'crb_glossary', esc_attr__('Enable glossary', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases you want to enable the glossary post type. You can set this option to yes', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'crb_knowledge_base', esc_attr__('Enable knowledge base', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases you want to enable the knowledge base post type. You can set this option to yes', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
        ]);

    /**
     * Page Options
     * @link https://docs.carbonfields.net/learn/containers/post-meta.html
     */
    Container::make('post_meta', __('Page settings', 'unity-theme'))
        ->where('post_type', '=', 'page')
        ->set_classes('cf-container__vertical-tabs')
        ->add_tab(__('Layout', 'unity-theme'), [
            Field::make('radio', 'page_hide_logo', esc_attr__('Hide logo', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the logo at the top of your page. You can set this option to yes.', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_menu', esc_attr__('Hide menu', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the primary navigation at the top of your page. You can set this option to yes.', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_header', esc_attr__('Hide header', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the header at the top of your page. You can set this option to yes.', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_footer', esc_attr__('Hide footer', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the footer at the top of your page. You can set this option to yes.', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
            Field::make('radio', 'page_hide_title', esc_attr__('Hide title', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show a title at the top of your page. You can set this option to yes.', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
        ])
        ->add_tab(__('Content', 'unity-theme'), [
            Field::make('select', 'header_alignment', __('Header alignment', 'unity-theme'))
                ->set_conditional_logic([
                    'relation' => 'AND', [
                        'field' => 'header_size',
                        'value' => true,
                        'compare' => '='
                    ]
                ])
                ->set_help_text(__('In some cases, you may want to adjust the alignment of the title, breadcrumbs and subtitle.', 'unity-theme'))
                ->set_options([
                    'text-center mx-auto' => __('Center', 'unity-theme'),
                    'text-center text-md-left' => __('Left', 'unity-theme'),
                    'text-center text-md-right ' => __('Right', 'unity-theme'),
                ]),
        ]);

    /**
     * Post Options
     * @link https://docs.carbonfields.net/learn/containers/post-meta.html
     */
    Container::make('post_meta', __('Post settings', 'unity-theme'))
        ->where('post_type', '=', 'post')
        ->set_classes('cf-container__vertical-tabs')
        ->add_tab(__('Sticky CTA', 'unity-theme'), [
            Field::make('radio', 'post_sticky_cta', esc_attr__('Hide logo', 'unity-theme'))
                ->set_classes('cf-switch')
                ->set_help_text(__('In some cases, you may not want to show the logo at the top of your page. You can set this option to yes.', 'unity-theme'))
                ->set_options(yesNoValues())
                ->set_default_value('no'),
        ]);
});

/**
 * Register Carbon Fields initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    Carbon_Fields::boot();
});
