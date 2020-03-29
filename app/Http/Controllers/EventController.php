<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

use MaddHatter\LaravelFullcalendar\Facades\Calendar;


class EventController extends Controller
{
    public function createEvent()
    {
        return view('createevent');
    }

    public function store(Request $request)
    {
        $event= new Event();
        $event->title            = $request->get('title');
        $event->start_date       = $request->get('startdate');
        $event->end_date         = $request->get('enddate');
        $event->background_color = $request->get('background_color');
        $event->text_color       = $request->get('text_color');
        $event->save();
        return redirect('event')->with('success', 'Event has been added');
    }

    public function calender()
    {
        $events = [];
        $data = Event::get();
        
        if($data->count())
        {
            foreach ($data as $key => $value) 
            {
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.'+1 day'),
                    $value->id,
                    // Add color
                    [
                        'color' =>  '#4BBF6B',
                        'textColor' => $value->text_color,
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('calender', compact('calendar'));
    }
}
