<?php namespace repositories;

use OpenDataSource;

class OpenDataSourceRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        return OpenDataSource::all();
    }

    public function create(array $data)
    {
        $source = OpenDataSource::createAnOpenDataSource($data['url'], $data['description'], $data['city'], $data['extension'], $data['updateInterval'], $data['configurationFilePath']);

        $source->save();

        return $source;
    }

    public function read($id, array $related = null)
    {
        return OpenDataSource::find($id);
    }

    public function update(array $data)
    {
        $source = $this->read($data['id']);

        if (($source->configurationFilePath != $data['configurationFilePath']) and ($data['configurationFilePath'] != ""))
        {
            unlink(public_path() . $source->configurationFilePath);
        }

        $source->updateAnOpenDataSource($data['url'], $data['description'], $data['city'], $data['extension'], $data['updateInterval'], $data['configurationFilePath']);

        $source->save();

        return $source;
    }

    public function delete($id)
    {
        $source = $this->read($id);

        unlink(public_path() . $source->configurationFilePath);

        $source->delete();
    }
}
