<?php

namespace App\Http\Controllers;

use App\Models\Partie;
use App\Models\Coup;
use Illuminate\Http\Request;

class PartieController extends Controller
{
    public function index()
    {
        $parties = Partie::withCount('coups')->orderByDesc('id')->get();
        return view('parties.index', ['parties' => $parties]);
    }

    public function store()
    {
        $partie = Partie::create();
        return redirect()->route('parties.show', $partie);
    }

    public function show(Partie $partie)
    {
        return view('parties.show', [
            'partie' => $partie,
            'cases' => $partie->cases(),
            'coups' => $partie->coups()->orderBy('id')->get(),
        ]);
    }

    public function jouer(Request $request, Partie $partie)
    {
        $request->validate([
            'position' => ['required', 'integer', 'between:0,8'],
        ]);

        if ($partie->estTerminee()) {
            return back()->withErrors(['position' => 'La partie est terminée.']);
        }

        $position = (int) $request->input('position');

        if ($partie->cases()[$position] !== '-') {
            return back()->withErrors(['position' => 'Cette case est déjà occupée.']);
        }

        $partie->placer($position);

        return redirect()->route('parties.show', $partie);
    }

    public function annuler(Partie $partie)
    {
        $partie->annulerDernierCoup();
        return redirect()->route('parties.show', $partie);
    }

    public function avancer(Partie $partie)
    {
        $cle = "redo.{$partie->id}";
        $pile = session($cle, []);
        $coup = array_pop($pile);

        if ($coup) {
            $partie->placer($coup['position']);
            $partie->coups()->create($coup); // retire cette ligne si placer() crée déjà le Coup
        }
        session([$cle => $pile]);
        return redirect()->route('parties.show', $partie);
    }

    public function destroy(Partie $partie)
    {
        $partie->delete();
        session()->forget("redo.{$partie->id}");
        return redirect()->route('parties.index');
    }

    public function supprimerCoup(Partie $partie, Coup $coup)
    {
        abort_unless($coup->partie_id === $partie->id, 404);
        $partie->supprimerCoup($coup->id);
        session()->forget("redo.{$partie->id}");
        return redirect()->route('parties.show', $partie);
    }}
