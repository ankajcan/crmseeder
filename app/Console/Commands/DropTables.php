<?php namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DropTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'droptables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop existing tables';

    /**
     * Create a new command instance.
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

        $colname = 'Tables_in_' . env('DB_DATABASE');

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = DB::select('SHOW TABLES');

        $droplist = [];

        foreach($tables as $table) {

            $droplist[] = $table->$colname;

        }
        $droplist = implode(',', $droplist);

        DB::beginTransaction();

        DB::statement("DROP TABLE $droplist");

        DB::commit();

        $this->comment(PHP_EOL."If no errors showed up, all tables were dropped".PHP_EOL);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}