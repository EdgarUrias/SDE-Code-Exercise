<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\OperationController;

class AssignShipments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipments:assign {addressesFile} {driversFile}';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign shipment destinations to drivers to maximize the total suitability score (SS)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $addressesFile = $this->argument('addressesFile');
        $driversFile = $this->argument('driversFile');

        //create an array of every line in the addresses file
        $addresses = file($addressesFile, FILE_IGNORE_NEW_LINES);

        //create an array of every line in the drivers file
        $drivers = file($driversFile, FILE_IGNORE_NEW_LINES);

        //Create an instance of OperationController
        $operation = new OperationController();

        // Process the SS and return the result
        $ss = $operation->processSS($addresses, $drivers);

        //format the output
        $this->info("Total Suitability Score:". $ss->get('totalSS'));
        $this->info("Shipment Assignments:");
        foreach ($ss->get('shipmentAssignments') as $address => $driver) {
            $this->line("$address => $driver");
        }

    }
}
