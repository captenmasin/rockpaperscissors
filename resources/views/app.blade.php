<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <script defer src="https://api.pirsch.io/pa.js" id="pianjs" data-code="h7peBOfIackd04AC5JDrkpQxGHUpMUX2"></script>

    {{ Vite::useHotFile(public_path('vite.hot')) }}

    @vite('resources/js/app.ts')
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
