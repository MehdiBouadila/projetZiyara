<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private VisiteRepository $visiteRepository,
        private UrlGeneratorInterface $router
    )
    {}

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        
        $visites = $this->visiteRepository
            ->createQueryBuilder('visite')
            ->where('visite.dateVisite BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($visites as $visite) {
            // this create the events with your data (here visite data) to fill calendar
            $visiteEvent = new Event(
                $visite->getTitle(), // Assuming "title" is a property of your "visite" entity
                $visite->getDateVisite(), // Assuming "dateVisite" is a property of your "visite" entity
                $visite->getDateVisite()->add(new \DateInterval('PT2H')) // Example: Add 2 hours to the visit date
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $visiteEvent->setOptions([
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',
            ]);
            $visiteEvent->addOption(
                'url',
                $this->router->generate('app_visite_show', [ // Assuming "app_visite_show" is your route for displaying a single visit
                    'id' => $visite->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($visiteEvent);
        }
    }
}
