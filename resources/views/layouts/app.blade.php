<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Morpion</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 40px; }
        .plateau { display: grid; gap: 4px; grid-template-columns: repeat(3, 80px); justify-content: center; margin: 20px auto; }
        .case { height: 80px; font-size: 2.5em; display: flex; align-items: center; justify-content: center; border: 1px solid #999; background: #fff; }
        button.case { cursor: pointer; }
        table { margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px 14px; }
    </style>
<link rel="stylesheet" href="{{ asset('css/neon.css') }}"><script src="{{ asset('js/neon.js') }}" defer></script></head>
<body>
    <h1>Morpion</h1>
    @yield('contenu')
</body>
</html>
