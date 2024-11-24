<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetAntrianNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antrian:reset-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset antrian number to 1 daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('antrians')
            ->where('status', 'waiting')
            ->update(['nomor_antrian' => DB::raw('(SELECT 1 + MAX(id) FROM antrians)')]);

        $this->info('Antrian numbers reset successfully');
    }
}
