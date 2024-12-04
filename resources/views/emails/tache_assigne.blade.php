<!DOCTYPE html>
<html>
<head>
    <title>Tâche Assignée</title>
</head>
<body>
    <h1>Bonjour {{ $user->name }}</h1>
    <p>Une nouvelle tâche vous a été assignée :</p>
    <p><strong>Titre :</strong> {{ $task->titre }}</p>
    <p><strong>Description :</strong> {{ $task->description }}</p>
    <p><strong>Date Limite :</strong> {{ \Carbon\Carbon::parse($task->date_limite)->format('d/m/Y') }}</p>
    <p>Merci de consulter vos tâches dans l'application.</p>
</body>
</html>
