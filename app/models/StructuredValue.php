<?php


class StructuredValue extends Intangible {

    protected $fillable = array('id');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'structuredValues';

    public $timestamps = false;

    public function intangible()
    {
        return $this->belongsTo('Intangible', 'id', 'id');
    }
}
