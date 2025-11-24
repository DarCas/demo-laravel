<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contacts');
    }

    public function send(Request $request)
    {
        // Validazione dati

        // Invio email
    }
}
