<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{    
    protected $breadcrumdData;

    public function __construct()
    {
        $this->breadcrumdData = [
            [
                'url' => '/dashboard',
                'nama' => 'Dashboard'
            ]
        ];
    }

    public function index(){
        $data = [
            'breadcrumd_data' => $this->breadcrumdData
        ];
        return view('home.index', $data);
    }
}
