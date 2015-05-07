<?php


class Offer extends Intangible {

    protected $fillable = array('id');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'offers';

    public $timestamps = false;

    public function intangible()
    {
        return $this->belongsTo('Intangible', 'id', 'id');
    }
}
