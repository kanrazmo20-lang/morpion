<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partie extends Model
{
    protected $fillable = ['plateau', 'joueur_courant'];

    private const ALIGNEMENTS = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6],
    ];

    public function coups(): HasMany
    {
        return $this->hasMany(Coup::class);
    }

    public function cases(): array
    {
        return str_split($this->plateau);
    }

    public function gagnant(): ?string
    {
        $c = $this->cases();
        foreach (self::ALIGNEMENTS as [$a, $b, $d]) {
            if ($c[$a] !== '-' && $c[$a] === $c[$b] && $c[$a] === $c[$d]) {
                return $c[$a];
            }
        }
        return null;
    }

    public function estNulle(): bool
    {
        return $this->gagnant() === null && !in_array('-', $this->cases());
    }

    public function estTerminee(): bool
    {
        return $this->gagnant() !== null || $this->estNulle();
    }

    public function statut(): string
    {
        if ($g = $this->gagnant()) {
            return "Gagnée par $g";
        }
        return $this->estNulle() ? 'Match nul' : 'En cours';
    }

    public function placer(int $position): void
    {
        $symbole = $this->joueur_courant;

        $plateau = $this->plateau;
        $plateau[$position] = $symbole;
        $this->plateau = $plateau;
        $this->joueur_courant = $symbole === 'X' ? 'O' : 'X';
        $this->save();

        $this->coups()->create(['position' => $position, 'symbole' => $symbole]);
    }

    public function annulerDernierCoup(): void
    {
        $coup = $this->coups()->latest('id')->first();
        if (!$coup) {
            return;
        }

        $plateau = $this->plateau;
        $plateau[$coup->position] = '-';
        $this->plateau = $plateau;
        $this->joueur_courant = $coup->symbole;
        $this->save();

        $coup->delete();
    }

    public function supprimerCoup(int $coupId): void
    {
        $this->coups()->whereKey($coupId)->delete();

        $plateau = str_repeat('-', 9);
        $symbole = 'X';
        foreach ($this->coups()->orderBy('id')->get() as $coup) {
            $plateau[$coup->position] = $symbole;
            $coup->update(['symbole' => $symbole]);
            $symbole = $symbole === 'X' ? 'O' : 'X';
        }
        $this->plateau = $plateau;
        $this->joueur_courant = $symbole;
        $this->save();
    }}
