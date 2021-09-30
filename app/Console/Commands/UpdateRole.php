<?php

namespace App\Console\Commands;

use App\Enums\UserType;
use App\Role;
use Illuminate\Console\Command;

class UpdateRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roles = UserType::getValues();
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
