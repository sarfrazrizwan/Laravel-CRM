<?php

namespace App\Console\Commands;

use App\Services\Laratrust\Importer;
use Illuminate\Console\Command;

class UpdateRoleAndPermission extends Command
{
    private $csvFilePath = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles-and-permissions:update {csvFilePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update roles and permissions from CSV to database';

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
        $this->csvFilePath = $this->argument("csvFilePath");
        Importer::getInstance($this->csvFilePath)->importRoleAndPermissions();
    }
}
