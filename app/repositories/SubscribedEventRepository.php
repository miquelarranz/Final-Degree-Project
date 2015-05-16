<?php namespace repositories;

use SubscribedEvent;

class SubscribedEventRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        $subscribedEvent = SubscribedEvent::createASubscribedEvent($data['name'], $data['url'], $data['description'], $data['startDate'], $data['address'], $data['type'], $data['city'], $data['user'], $data['associatedEvent']);

        $subscribedEvent->save();

        return $subscribedEvent;
    }

    public function read($id, array $related = null)
    {
        if (is_null($related))
        {
            return SubscribedEvent::find($id);
        }
        else
        {
            return SubscribedEvent::where($related)->first();
        }
    }

    public function update(array $data)
    {

    }

    public function delete($id)
    {
        $subscribedEvent = $this->read($id);

        $subscribedEvent->delete();
    }
}
