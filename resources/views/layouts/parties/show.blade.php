@extends('layouts.app')

@section('contenu')
    <div class="plateau">
        @foreach ($cases as $case)
            <div class="case">{{ $case === '-' ? '' : $case }}</div>
        @endforeach
    </div>
@endsection
