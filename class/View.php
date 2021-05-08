<?php
namespace Woof\View;

use function Woof\slugify;

class View
{


    /**
     * @var Theme
     */
    protected $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }




    public function partial($slug, $name = null, $data = [])
    {
        if($name === null) {
            $name = slugify($slug);
        }

        // source file : public\wp\wp-includes\general-template.php
        do_action( "get_template_part_{$slug}", $slug, $name, $data );

        $templates = array();
        $name      = (string) $name;
        if ( '' !== $name ) {
            $templates[] = "{$slug}-{$name}.php";
        }

        $templates[] = "{$slug}.php";
        do_action( 'get_template_part', $slug, $name, $templates, $data);

        $template = $this->locateTemplate( $templates, true, false, $data);


        if($template) {
            $this->loadTemplate($template);
            return $template;
        }
        else {
            return false;
        }
    }

    public function locateTemplate($template_names, $load = false, $require_once = true, $data = array())
    {
        $located = '';
        foreach ( (array) $template_names as $template_name ) {
            if ( ! $template_name ) {
                continue;
            }
            if ( file_exists( STYLESHEETPATH . '/' . $template_name ) ) {
                $located = STYLESHEETPATH . '/' . $template_name;
                break;
            } elseif ( file_exists( TEMPLATEPATH . '/' . $template_name ) ) {
                $located = TEMPLATEPATH . '/' . $template_name;
                break;
            } elseif ( file_exists( ABSPATH . WPINC . '/theme-compat/' . $template_name ) ) {
                $located = ABSPATH . WPINC . '/theme-compat/' . $template_name;
                break;
            }
        }
        return $located;
    }

    public function loadTemplate($_template_file, $require_once = true, $data = array(), $extract = true)
    {
        // source file : public\wp\wp-includes\general-template.php
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if(!array_key_exists('theme', $data)) {
            $data['theme'] = $this->theme;
        }

        if ( is_array( $wp_query->query_vars ) ) {
            extract( $wp_query->query_vars, EXTR_SKIP );
        }

        if ( isset( $s ) ) {
            $s = esc_attr( $s );
        }

        if($extract) {
            extract($data);
        }

        if ( $require_once ) {
            require_once $_template_file;
        } else {
            require $_template_file;
        }
    }





    public function getHeader()
    {
        wp_head();
        return $this;
    }

    public function getFooter()
    {
        wp_footer();
        return $this;
    }

    public function getPosts()
    {
        $posts = [];
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                $posts[] = get_post();

            }
        }
        return $posts;
    }
}


