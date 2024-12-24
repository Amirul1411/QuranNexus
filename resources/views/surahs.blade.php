<!DOCTYPE html>
<html>
<head>
    <title>All Surahs</title>
</head>
<body>
    <h1>List of Surahs</h1>
    <ul>
        @foreach ($surahs as $surah)
            <li>
                <strong>{{ $surah->name }}</strong> ({{ $surah->tname }} - {{ $surah->ename }})
                <p>Type: {{ $surah->type }} | Ayahs: {{ $surah->ayas }}</p>
            </li>
            <hr>
        @endforeach
    </ul>
</body>
</html>