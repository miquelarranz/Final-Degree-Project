<?php namespace repositories;

use OpenEvent;
use Illuminate\Support\Facades\DB;

class EventRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        if ( ! array_key_exists('clean', $related) and ! is_null($related))
        {
            $queryHeader = "SELECT DISTINCT e.* FROM events e";
            $query = " WHERE ";
            $first = true;
            //, things t, things pt, places p, openDataCities o
            $startDateAdded = false;
            $limit = 50;

            if (array_key_exists('limit', $related))
            {
                $limit = $related['limit'];
            }
            if (array_key_exists('name', $related))
            {
                $queryHeader = $queryHeader . ", things t";
                $name = $related['name'];
                if ($first)
                {
                    $query = $query . "e.id = t.id AND t.name LIKE '%$name%' ";
                    $first = false;
                } else $query = $query . "AND e.id = t.id AND t.name LIKE '%$name%' ";
            }
            if (array_key_exists('type', $related))
            {
                $type = $related['type'];
                if ($first)
                {
                    $query = $query . "e.type LIKE '%$type%' ";
                    $first = false;
                } else $query = $query . "AND e.type LIKE '%$type%' ";
            }
            if (array_key_exists('startDate', $related))
            {
                $startDate = new \DateTime($related['startDate']);
                $date = $startDate->format('Y-m-d H:i:s');
                if ($first)
                {
                    $query = $query . "e.startDate >= '$date' ";
                    $first = false;
                } else $query = $query . "AND e.startDate >= '$date' ";
                $startDateAdded = true;
            }
            if (array_key_exists('endDate', $related))
            {
                $endDate = new \DateTime($related['endDate']);
                $date = $endDate->format('Y-m-d H:i:s');
                if ($first)
                {
                    $query = $query . "e.startDate <= '$date' ";
                    $first = false;
                } else $query = $query . "AND e.startDate <= '$date' ";
            }
            if (array_key_exists('location', $related))
            {
                $queryHeader = $queryHeader . ", things pt, places p, openDataCities o";
                $city = $related['location'];
                if ($first)
                {
                    $query = $query . "e.location = p.id AND p.id = pt.id AND pt.name = o.name AND o.id = $city ";
                    $first = false;
                } else $query = $query . "AND e.location = p.id AND p.id = pt.id AND pt.name = o.name AND o.id = $city ";
            }
            if ( ! $startDateAdded)
            {
                $now = new \DateTime('now');
                $date = $now->format('Y-m-d H:i:s');
                $query = $query . "AND (e.startDate > '$date' or e.startDate IS NULL) ";
            }

            $query = $queryHeader . $query;
            //dd($query . "ORDER BY e.startDate ASC LIMIT " . $limit);
            /*$result = array();
            $eloquentFilter = array();
            $manualFilter = array();
            foreach ($related as $key => $value)
            {
                if ($key == 'name' or 'location') $manualFilter[$key] = $value;
                else $eloquentFilter[$key] = $value;
            }

            if (empty($eloquentFilter)) $eloquentResult = OpenEvent::all()->paginate(20);
            else $eloquentResult = OpenEvent::where($eloquentFilter)->get();

            if ( ! empty($eloquentResult) and ! empty($manualFilter))
            {
                foreach ($manualFilter as $manualKey => $manualValue)
                {


                }
            }
            else $result = $eloquentResult;*/
            $result = DB::select( DB::raw($query . "ORDER BY e.startDate ASC LIMIT " . $limit) );

            $events = array();
            if ( ! empty($result))
            {
                foreach ($result as $eventInformation)
                {
                    $events[] = with(new OpenEvent)->newFromStd($eventInformation);
                }
            }
            //dd($result);
            //dd(DB::getQueryLog());
            return $events;
        }
        else if (array_key_exists('clean', $related))
        {
            return OpenEvent::all();
        }
        else
        {
            return OpenEvent::take(50)->get();
        }
    }

    public function create(array $data)
    {

    }

    public function read($id, array $related = null)
    {
        return OpenEvent::find($id);
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        $event = $this->read($id);

        $event->delete();
    }
}
