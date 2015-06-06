<?php namespace repositories;

use User;

class UserRepository implements RepositoryInterface {

    public function all(array $related = null)
    {
        return User::where($related)->get();
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
        if (array_key_exists('password', $data))
        {
            if ($data['password'] != "")
            {
                $user->updateAUser($data['password']);

                $user->save();
            }
        }
        if (array_key_exists('city', $data))
        {
            if ($data['city'] !== "")
            {
                $user->updateTheDefaultCity($data['city']);

                $user->save();
            }
        }
        return $user;
    }

    public function delete($id)
    {
        $user = $this->read($id);

        $user->delete();
    }
}
