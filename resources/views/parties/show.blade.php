@extends('layouts.app')

@section('contenu')
    <p><a href="{{ route('parties.index') }}">Toutes les parties</a></p>

    @if ($partie->gagnant())
        <h2>{{ $partie->gagnant() }} a gagné !</h2>
    @elseif ($partie->estNulle())
        <h2>Match nul</h2>
    @else
        <p>Au tour de : {{ $partie->joueur_courant }}</p>
    @endif

    @error('position')
        <p style="color: red;">{{ $message }}</p>
    @enderror

    @if ($partie->estTerminee())
        <div class="plateau">
            @foreach ($cases as $case)
                <div class="case">{{ $case === '-' ? '' : $case }}</div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('parties.store') }}">
            @csrf
            <button type="submit">Nouvelle partie</button>
        </form>
    @else
        <form method="POST" action="{{ route('parties.jouer', $partie) }}">
            @csrf
            <div class="plateau">
                @foreach ($cases as $i => $case)
                    @if ($case === '-')
                        <button type="submit" name="position" value="{{ $i }}" class="case"></button>
                    @else
                        <div class="case">{{ $case }}</div>
                    @endif
                @endforeach
            </div>
        </form>
    @endif

    @if ($coups->isNotEmpty())
        <form method="POST" action="{{ route('parties.annuler', $partie) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Annuler le dernier coup</button>
        </form>
    @endif

    <h3>Historique</h3>
    @forelse ($coups as $coup)
        <div>{{ $loop->iteration }}. {{ $coup->symbole }} en case {{ $coup->position }}</div>
    @empty
        <p>Aucun coup joué.</p>
    @endforelse
@endsection