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
        $date = new DateTime();
        $lastUpdateDate = $date->format('Y-m-d H:i:s');
        $source = new static(compact('url', 'description', 'city', 'extension', 'updateInterval', 'configurationFilePath', 'lastUpdateDate'));

        return $source;
    }

    public function updateAnOpenDataSource($url, $description, $city, $extension, $updateInterval, $configurationFilePath, $lastUpdateDate)
    {
        if ( ! is_null($url)) $this->attributes['url'] = $url;
        if ( ! is_null($description)) $this->attributes['description'] = $description;
        if ( ! is_null($city)) $this->attributes['city'] = $city;
        if ( ! is_null($extension)) $this->attributes['extension'] = $extension;
        if ( ! is_null($updateInterval)) $this->attributes['updateInterval'] = $updateInterval;
        if (($configurationFilePath != "") and  ! is_null($configurationFilePath)) $this->attributes['configurationFilePath'] = $configurationFilePath;
    }
}
