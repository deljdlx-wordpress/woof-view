<?php
namespace Woof\View;

class Template
{

    protected $view;
    protected $file;

    protected $variables = [];

    protected $placeholders = [];

    public function __construct($view, $file = null, $variables = [])
    {
        $this->view = $view;

        if($file) {
            $this->file = $this->locate($file);
        }

        $this->variables = $variables;
    }




    public function include($slug, $data = [])
    {

        // source file : public\wp\wp-includes\general-template.php
        // do_action( "get_template_part_{$slug}", $slug, $name, $data );
        // do_action( 'get_template_part', $slug, $name, $templates, $data);

        $template = new Template($this->view, $slug, $data);
        return $template;

    }

    public function locate($file)
    {

        $templates = array($file);

        $templates[] = "{$file}.php";
        $templates[] = "{$file}.tpl.php";

        $located = '';
        foreach ( (array) $templates as $template_name ) {
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

        if(!$located) {
            throw new Exception('Can not locate template "' . $file . '"');
        }

        return $located;
    }



    public function render()
    {

        ob_start();
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if ( is_array( $wp_query->query_vars ) ) {
            extract( $wp_query->query_vars, EXTR_SKIP );
        }

        extract($this->variables);

        $theme = $this->view->getTheme();
        $template = $this;
        $view = $this->view;

        include($this->file);
        return ob_get_clean();
    }


    public function __toString()
    {
        return $this->render();
    }

}
