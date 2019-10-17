<?php

namespace App\Http\Controllers;

use App\nrgApi;
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
