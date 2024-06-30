<?php
session_start();

class buscar_controlador
{
    public $view;

    public function __construct()
    {
        $this->view = "buscar";
    }

    public function mostrar_vista()
    {
        return $this->view;
    }

}
