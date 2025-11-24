<p>Ciao,<br>
questo messaggio è stato inviato dal tuo sito.</p>

<p>I dettagli della richiesta sono:</p>

<ul>
    <li>Nome: <strong>{{ $nome }}</strong></li>
    <li>Cognome: <strong>{{ $cognome }}</strong></li>
    <li>E-Mail: <a href="mailto:{{ $email }}"><strong>{{ $email }}</strong></a></li>
    <li>Telefono: <strong>{{ $telefono || 'Non indicato' }}</strong></li>
</ul>

<p>con il seguente contenuto:</p>

<p>{!! nl2br($messaggio) !!}</p>
