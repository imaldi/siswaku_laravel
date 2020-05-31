<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RahasiaController extends Controller
{
    public function halamanRahasia()
    {
        return 'Anda sedang melihat <strong>halaman rahasia.</strong>';
    }

    public function showMeSecret()
    {
        return redirect()->route('secret');
    }
}
