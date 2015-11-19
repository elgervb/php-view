<?php
namespace view;

/**
 * View with a template
 *
 * @author Elger van Boxtel
 */
class TemplateView implements IView
{

    private $vars = array();

    /**
     *
     * @var string The full path to a template file
     */
    private $template;

    /**
     * Constructor
     *
     * @param string $aTemplate
     *            The file path to the template
     * @param array $aVars
     *            = null Initial variables
     *            
     * @throws \view\ViewException when the template path does not exist
     */
    public function __construct($aTemplate, array $aVars = null)
    {
        $this->template = $aTemplate;
        
        if ($aVars != null) {
            foreach ($aVars as $key => $value) {
                $this->vars[$key] = $value;
            }
        }
    }

    /**
     * Overridden magic method __call, do nothing when calling a non-existing method
     *
     * @param
     *            string aMethodName The method name
     * @param $aArguments array            
     */
    public function __call($aMethodName, array $aArguments)
    {
        if ($this->{$aMethodName} instanceof \Closure) {
            return call_user_func_array($this->{$aMethodName}, $aArguments);
        }
        return null;
    }

    /**
     * Magic method to get a variable from a view
     *
     * @param $aKey string            
     *
     * @return mixed the value, or itself when not set
     */
    public function __get($aKey)
    {
        if (isset($this->vars[$aKey])) {
            return $this->vars[$aKey];
        }
        
        return $this;
    }

    /**
     * Magic method to set a variable to a view
     *
     * @param $aKey string            
     * @param $aValue mixed            
     */
    public function __set($aKey, $aValue)
    {
        $this->vars[$aKey] = $aValue;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \view\IView::render()
     * 
     * @throws \view\ViewException when the template could not be found
     */
    public function render()
    {
        if (! is_file($this->template)) {
            throw new ViewException("Template " . $this->template . " does not exist.");
        }
        
        ob_start('mb_output_handler');
        include $this->template;
        return ob_get_clean();
    }

    /**
     * Renders the template
     *
     * @return string the rendered output
     */
    public function __toString()
    {
        return $this->render();
    }
}
