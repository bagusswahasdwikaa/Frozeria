<?php

namespace App\Http\Controllers;

class BantuanController extends Controller
{
    /**
     * GET /bantuan
     * Halaman panduan penggunaan sistem
     */
    public function index()
    {
        return view('bantuan.index');
    }
}
