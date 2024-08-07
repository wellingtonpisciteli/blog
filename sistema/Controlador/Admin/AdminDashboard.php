<?php

namespace sistema\Controlador\Admin;

class AdminDashboard extends AdminControlador{
    
    public function dashboard():void{
        
        echo($this->template->renderizar('dashboard.html', []));
    }
}