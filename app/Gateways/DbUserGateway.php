<?php  namespace App\Gateways;

use App\Models\User;
use App\Services\AssertsPermission;
use Illuminate\Contracts\Auth\PasswordBroker;
use Hash;

class DbUserGateway
{
    use AssertsPermission;

    protected $resourceType = 'users';

    /**
     * @var \App\Models\User
     */
    protected $user;
    /**
     * @var \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected $passwordBroker;

    protected $passwordResetDefaultSubject = 'Your Password Reset';

    public function __construct(User $user, PasswordBroker $passwordBroker)
    {
        $this->user = $user;
        $this->passwordBroker = $passwordBroker;
    }

    public function newInstance($attributes = [])
    {
        return $this->user->newInstance($attributes = []);
    }

    public function all()
    {
        return $this->user->newQuery()
            ->get();
    }

    public function find($id)
    {
        return $this->user->newQuery()
            ->where('id', $id)
            ->first();
    }

    public function update($id, array $attributes = [])
    {
        $this->assertPermission('update', $id);

        $user = $this->find($id);

        $user->update($attributes);

        return $user;
    }

    public function createWithRandomPassword($attributes = [])
    {
        $attributes['password'] = Hash::make(str_random());

        $user = $this->user->create($attributes);

        $this->emailPasswordReset($user->email, function($message) {
            $message->newUser = true;
        });

        return $user;
    }

    public function emailPasswordReset($email, $callback = null)
    {
        $callback = $callback ?: function ($message) {
            $message->subject($this->passwordResetDefaultSubject);
        };

        switch ($this->passwordBroker->sendResetLink(compact('email'), $callback)) {
            case PasswordBroker::RESET_LINK_SENT:
                return true;
            case PasswordBroker::INVALID_USER:
                return false;
        }
    }

    public function resetPassword($credentials)
    {
        $response = $this->passwordBroker->reset($credentials, function($user, $password)
        {
            $user->password = bcrypt($password);

            $user->save();
        });

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                return true;

            default:
                return $response;
        }
    }

    public function ensureRoles(User $user, array $roles)
    {
        foreach($roles as $role => $value)
        {
            if ($value) {
                $user->ensureRole($role);
            } else {
                $user->detachRole($role);
            }
        }
    }

    public function delete($id)
    {
        if ($user = $this->find($id)) {
            $user->delete();

            return $user;
        }

        return false;
    }

}
