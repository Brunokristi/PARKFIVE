<!DOCTYPE html>
<html>
<head>
    <title>Google Calendar Events</title>
</head>
<body>
    <h1>Upcoming Events fot Apt 1</h1>
    @if(count($eventsApt1) > 0)
        <ul>
            @foreach($eventsApt1 as $event)
                <?php $start = $event->start->dateTime ?? $event->start->date; ?>
                <li>
                    <strong>{{ $event->summary }}</strong><br>
                    Starts: {{ $start }}<br>
                    Ends: {{ $event->end->dateTime ?? $event->end->date }}<br>
                </li>
            @endforeach
        </ul>
    @else
        <p>No upcoming events found.</p>
    @endif

    <h1>Upcoming Events fot Apt 2</h1>
    @if(count($eventsApt2) > 0)
        <ul>
            @foreach($eventsApt2 as $event)
                <?php $start = $event->start->dateTime ?? $event->start->date; ?>
                <li>
                    <strong>{{ $event->summary }}</strong><br>
                    Starts: {{ $start }}<br>
                    Ends: {{ $event->end->dateTime ?? $event->end->date }}<br>
                </li>
            @endforeach
        </ul>
    @else
        <p>No upcoming events found.</p>
    @endif
</body>
</html>
