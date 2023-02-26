<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;

class ClientController extends RegisterController
{
    public function __construct()
    {
        
        
        $role_slug = "client";
       
        $can_receive_notifications = true;
    
        parent::__construct($role_slug,$can_receive_notifications);
    }
}
