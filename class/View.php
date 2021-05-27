<?php
namespace Woof\View;


class View
{

    protected $file;

    protected $variables = [];


    /**
     * @var Template[]
     */
    protected $templates = [];



    /**
     * @var Template
     */
    protected $template;

    protected $parts = [];


    public function __construct($file = null)
    {
        $this->file = $file;
        $this->template = new Template($this, $file);
    }

    /**
     * @param string|array $variableNameOrVariableList
     * @param mixed $value
     * @return this
     */
    public function set($variableNameOrVariableList, $value = null)
    {
        if(is_array($variableNameOrVariableList)) {
            foreach($variableNameOrVariableList as $key => $value) {
                $this->variables[$key] = $value;
            }
        }
        else {
            $this->variables[$variableNameOrVariableList] = $value;
        }

        return $this;
    }

    /**
     * @param string $variableName
     * @param mixed $default
     * @return mixed
     */
    public function get($variableName, $default = null)
    {
        if(array_key_exists($variableName, $this->variables)) {
            return $this->variables[$variableName];
        }
        else {
            return $default;
        }
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->variables;
    }


    /**
     *
     * @return string
     */
    public function render()
    {
        return $this->loadTemplate($this->file);
    }



    /**
     * @param string $name
     * @param array $data
     * @return Template
     */
    public function loadTemplate($name, $data = [])
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

    /**
     * @return this
     */
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

    /**
     * @return this
     */
    public function endPart($slug)
    {
        $this->parts[$slug] = ob_get_clean();
        return $this;
    }


    /**
     * @return this
     */
    public function getHeader()
    {
        wp_head();
        return $this;
    }

    /**
     * @return this
     */
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


