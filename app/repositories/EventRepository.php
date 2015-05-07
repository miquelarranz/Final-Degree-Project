<?php namespace repositories;

use OpenEvent;
use Illuminate\Support\Facades\DB;

class EventRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        if ( ! is_null($related))
        {
            $query = "SELECT e.* FROM events e, things t, things pt, places p, openDataCities o WHERE ";
            $first = true;
            $startDateAdded = false;

            if (array_key_exists('name', $related))
            {
                $name = $related['name'];
                $query = $query . "e.id = t.id AND t.name LIKE '%$name%' ";
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
                $startDate = $related['startDate'];
                if ($first)
                {
                    $query = $query . "e.startDate >= '$startDate' ";
                    $first = false;
                } else $query = $query . "AND e.startDate >= '$startDate' ";
                $startDateAdded = true;
            }
            if (array_key_exists('endDate', $related))
            {
                $endDate = $related['endDate'];
                if ($first)
                {
                    $query = $query . "e.endDate <= '$endDate' ";
                    $first = false;
                } else $query = $query . "AND e.endDate <= '$endDate' ";
            }
            if (array_key_exists('city', $related))
            {
                $city = $related['city'];
                if ($first)
                {
                    $query = $query . "e.location = p.id AND p.id = pt.id AND pt.name = o.name AND o.id = $city ";
                    $first = false;
                } else $query = $query . "AND e.location = p.id AND p.id = pt.id AND pt.name = o.name AND o.id = $city ";
            }
            if ( ! $startDateAdded)
            {
                $now = date_create()->format('Y-m-d H:i:s');
                $query = $query . "AND (e.startDate > '$now' or e.startDate = NULL) ";
            }
            dd($query . "ORDER BY e.startDate ASC LIMIT 50");
            $result = DB::select($query . " ORDER BY e.startDate ASC LIMIT 50");

            //dd(DB::getQueryLog());

            return $result;
        }
        else
        {
            return OpenEvent::all();
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
