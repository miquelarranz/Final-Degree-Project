<?php


class PostalAddress extends Intangible {

    protected $fillable = array('id');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'postalAddresses';

    public $timestamps = false;

    public function contactPoint()
    {
        return $this->belongsTo('ContactPoint', 'id', 'id');
    }
}
