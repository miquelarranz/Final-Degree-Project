<?php


class Intangible extends Thing {

    protected $fillable = array('id');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'intangibles';

    public $timestamps = false;

    public function thing()
    {
        return $this->belongsTo('Thing', 'id', 'id');
    }
}
