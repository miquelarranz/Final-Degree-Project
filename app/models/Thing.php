<?php


class Thing extends Eloquent {

    protected $fillable = array('additionalType', 'alternateName', 'description', 'name', 'image', 'sameAs', 'url');

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'things';

    public static function createAThing($additionalType = null, $alternateName = null, $description = null, $name = null, $image = null, $sameAs = null, $url = null)
    {
        $thing = new static(compact('additionalType', 'alternateName', 'description', 'name', 'image', 'sameAs', 'url'));

        return $thing;
    }
}
