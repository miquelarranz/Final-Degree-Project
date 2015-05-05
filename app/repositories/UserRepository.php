<?php namespace repositories;

use User;

class UserRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        $user = User::registerAUser($data['email'], $data['password'], $data['person']);

        $user->save();

        return $user;
    }

    public function read($id, array $related = null)
    {
        return User::find($id);
    }

    public function update(array $data)
    {
        $user = $this->read($data['id']);

        if ($data['password'] !== "")
        {
            $user->updateAUser($data['password']);

            $user->save();
        }

        return $user;
    }

    public function delete($id)
    {
        $user = $this->read($id);

        $user->delete();
    }
}
