<?php

namespace App\Http\Controllers;

use App\dellinApi;
use App\nrgApi;
use App\pecomApi;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class HomeController extends Controller
{


    public function index()
    {




        return view('welcome');
    }






}
