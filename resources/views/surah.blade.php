<!DOCTYPE html>
<html>
<head>
    <title>Surah Details</title>
</head>
<body>
    <h1>Surah: {{ $surah->name }}</h1>
    <p>Transliteration: {{ $surah->tname }}</p>
    <p>English Name: {{ $surah->ename }}</p>
    <p>Type: {{ $surah->type }}</p>
    <p>Number of Ayahs: {{ $surah->ayas }}</p>
</body>
</html>