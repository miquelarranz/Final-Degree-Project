<?php


class OpenEvent extends Thing {

    protected $fillable = array('id', 'doorTime', 'duration', 'startDate', 'endDate', 'type', 'typicalAgeRange', 'eventStatus', 'location');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

    public $timestamps = false;

    public function thing()
    {
        return $this->belongsTo('Thing', 'id', 'id');
    }

    public function eventLocation()
    {
        return $this->belongsTo('Place', 'location');
    }

    public function offers()
    {
        return $this->hasMany('Offer', 'event');
    }

    public function performers()
    {
        return $this->hasMany('Organization', 'event');
    }

    public function newFromStd(stdClass $std)
    {
        // backup fillable
        $fillable = $this->getFillable();

        // set id and other fields you want to be filled
        $this->fillable(['id', 'doorTime', 'duration', 'startDate', 'endDate', 'type', 'typicalAgeRange', 'eventStatus', 'location']);

        // fill $this->attributes array
        $this->fill((array) $std);

        // restore fillable
        $this->fillable($fillable);

        return $this;
    }
}
