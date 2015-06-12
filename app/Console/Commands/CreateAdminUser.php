<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Hash;

class CreateAdminUser extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'user:new-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user with admin privileges.';
    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $email = $this->ask('What is the email for the new super user: ');
        $password = $this->secret('What is the new super user\'s password: ');
        $attrs = [
            'email' => $email,
            'password' => Hash::make($password),
        ];

        if ($this->confirm("Are you sure you want to create a new user for {$email}? [yes|no]", false)) {
            $user = $this->user->create($attrs);

            $user->ensureRole('admin');

            $this->info("User created for email {$email} with id {$user->id}");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }

}
