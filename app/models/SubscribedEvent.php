<?php


class SubscribedEvent extends Eloquent {

    protected $fillable = array('id', 'name', 'url', 'description', 'startDate', 'address', 'city', 'user', 'associatedEvent');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'subscribedEvents';

    public static function createASubscribedEvent($name, $url = null, $description = null, $startDate = null, $address = null, $type = null, $city = null, $user, $associatedEvent)
    {
        $subscribedEvent = new static(compact('name', 'url', 'description', 'startDate', 'address', 'type', 'city', 'user', 'associatedEvent'));

        return $subscribedEvent;
    }
}
