<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Mail\BelajarEmailLaravel;

class KirimEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:massal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim 500 email sekaligus';

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
     * @return int
     */
    public function handle()
    {
        for ($i=0; $i < 500 ; $i++) { 
            Mail::to('rolar77724@chambile.com')
            ->send(new BelajarEmailLaravel($i + 1));
            $this->info("Email #$i berhasil dikirim");
        }
    }
}
