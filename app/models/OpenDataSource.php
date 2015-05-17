<?php


class OpenDataSource extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'openDataSources';

    protected $fillable = array('id', 'url', 'description', 'city', 'extension', 'lastUpdateDate', 'updateInterval', 'configurationFilePath');

    public $timestamps = false;

    public function relatedCity()
    {
        return $this->belongsTo('OpenDataCity', 'city');
    }

    public static function createAnOpenDataSource($url, $description, $city, $extension, $updateInterval, $configurationFilePath)
    {
        $source = new static(compact('url', 'description', 'city', 'extension', 'updateInterval', 'configurationFilePath'));

        return $source;
    }

    public function updateAnOpenDataSource($url, $description, $city, $extension, $updateInterval, $configurationFilePath)
    {
        $this->attributes['url'] = $url;
        $this->attributes['description'] = $description;
        $this->attributes['city'] = $city;
        $this->attributes['extension'] = $extension;
        $this->attributes['updateInterval'] = $updateInterval;
        $this->attributes['configurationFilePath'] = $configurationFilePath;
    }
}
