<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\SentMessage;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contacts');
    }

    public function send(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->post(), [
            'nome' => [
                'required',
                'max:100',
            ],
            'cognome' => [
                'required',
                'max:100',
            ],
            'email' => [
                'required',
                'email:rfc',
            ],
            'telefono' => [
                'nullable',
            ],
            'messaggio' => [
                'required',
                'max:1000',
            ],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()
                ->back()
                ->withErrors($errors);
        }

        try {
            $mail = \Illuminate\Support\Facades\Mail::to(
                new \Illuminate\Mail\Mailables\Address(
                    address: config('mail.to.address'),
                    name: config('mail.to.name'),
                )
            );

            /** @var SentMessage|null $responde */
            $responde = $mail->send(
                new \App\Mail\Contacts([
                    'subject' => "Nuovo messaggio da {$validator->getValue('cognome')}, {$validator->getValue('nome')}",
                    'nome' => $validator->getValue('nome'),
                    'cognome' => $validator->getValue('cognome'),
                    'email' => $validator->getValue('email'),
                    'telefono' => $validator->getValue('telefono'),
                    'messaggio' => $validator->getValue('messaggio'),
                ])
            );

            if (!$responde) {
                return redirect()
                    ->back()
                    ->withErrors([
                        'error' => 'Il form non è stato inviato.',
                    ]);
            }

            return redirect()
                ->back()
                ->withErrors([
                    'success' => 'Il form è stato inviato con successo.',
                ]);
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withErrors([
                    'error' => $th->getMessage(),
                ]);
        }
    }
}
