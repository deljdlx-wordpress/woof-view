<?php
namespace Woof\View;

use Woof\Theme\Theme;

use function Woof\slugify;

class View
{


    /**
     * @var Theme
     */
    protected $theme;

    protected $file;


    /**
     * @var Template[]
     */
    protected $templates = [];



    /**
     * @var Template
     */
    protected $template;

    protected $parts = [];


    public function __construct($theme, $file = null)
    {
        $this->theme = $theme;
        $this->file = $file;

        $this->template = new Template($this, $file);
    }

    public function render()
    {
        return $this->loadTemplate($this->file);
    }

    /**
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }




    public function loadTemplate($name, $data = array())
    {

        $template = new Template($this, $name, $data);
        $this->templates[$name] = $template;


        return $template;
    }


    public function getPart($slug)
    {
        if(array_key_exists($slug, $this->parts)) {
            return $this->parts[$slug];
        }
        else {
            return false;
        }
    }

    public function setPart($slug, $content)
    {
        if($content === true) {
            $this->parts[$slug] = '';
            ob_start();
            return $this;
        }
        $this->parts[$slug] = $content;
        return $this;
    }

    public function endPart($slug)
    {
        $this->parts[$slug] = ob_get_clean();
        return $this;
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

    public function __toString()
    {
        return (string) $this->render();
    }
}


