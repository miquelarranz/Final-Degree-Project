<?php


class Organization extends Thing {

    protected $fillable = array('id', 'email');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'organizations';

    public $timestamps = false;

    public function thing()
    {
        return $this->belongsTo('Thing', 'id', 'id');
    }
}
