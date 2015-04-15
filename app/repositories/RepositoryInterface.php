<?php namespace repositories;

interface RepositoryInterface
{
    public function all(array $related = null);

    public function create(array $data);

    public function read($id, array $related = null);

    public function update(array $data);

    public function delete($id);
}
