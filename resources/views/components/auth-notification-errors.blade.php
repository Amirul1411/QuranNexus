@if ($errors->any())
    @foreach ($errors->all() as $error)
        sendErrorNotification($error)
    @endforeach
@endif
