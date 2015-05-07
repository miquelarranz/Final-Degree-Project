<?php


class ContactPoint extends Intangible {

    protected $fillable = array('id');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contactPoints';

    public $timestamps = false;

    public function structuredValue()
    {
        return $this->belongsTo('StructuredValue', 'id', 'id');
    }
}
