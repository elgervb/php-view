<?php
namespace view;

/**
 * View interface
 * 
 * @author Elger van Boxtel
 */
interface IView
{

    /**
     * Renders the view
     *
     * @return String the view's content
     */
    public function render();
}