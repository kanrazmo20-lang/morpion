@extends('layouts.app')

@section('contenu')
    <form method="POST" action="{{ route('parties.store') }}">
        @csrf
        <button type="submit">Nouvelle partie</button>
    </form>

    @forelse ($parties as $partie)
        @if ($loop->first)
        <table>
            <tr><th>N°</th><th>Créée le</th><th>Statut</th><th>Coups</th><th></th></tr>
        @endif
            <tr>
                <td>{{ $partie->id }}</td>
                <td>{{ $partie->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $partie->statut() }}</td>
                <td>{{ $partie->coups_count }}</td>
                <td><a href="{{ route('parties.show', $partie) }}">Reprendre</a></td>
            </tr>
        @if ($loop->last)
        </table>
        @endif
    @empty
        <p>Aucune partie enregistrée.</p>
    @endforelse
@endsection