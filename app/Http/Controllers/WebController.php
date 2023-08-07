<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\OperationController;

class WebController extends Controller
{
    /**
     *@param Request $request
     *
     * This function is used to process the SS request.
     *
     * return json
     */
    public function requestSS(Request $request){

        // Validate the input file field to ensure it's a valid file.
        $request->validate([
            'drivers' => ['required', 'file', 'mimetypes:text/plain'],
            'addresses' => ['required', 'file']
        ]);

        //validate the file extension of the addresses file because the file have something strange
        if( $request->addresses->getClientOriginalExtension() !== 'txt'){
            return response()->json(["message" => "The addresses field must be a file of type: text\/plain."], 400);
        }

        //create an array of every line in the addresses file
        $addresses = file($request->addresses, FILE_IGNORE_NEW_LINES);

        //create an array of every line in the drivers file
        $drivers = file($request->drivers, FILE_IGNORE_NEW_LINES);

        //Create an instance of OperationController
        $operation = new OperationController();

        // Process the SS and return the result
        $ss = $operation->processSS($addresses, $drivers);

        return response()->json($ss, 200);

    }
}
