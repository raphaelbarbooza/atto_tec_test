<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Services\ProducerServices;
use Illuminate\Http\Request;

class ProducersController extends Controller
{
    /**
     * @param Producer $producer
     * We are using this controller only to bind the route producer id to a producer.
     * We can do it on RouteServices Provider, and call the view directly on route.
     * What's the problem?
     * In the manage-farms page, you can ask for the producer remove.
     * Once removed, the route lost its reference, so you can't bind directly, not with routes page.
     */
    public function manage(Request $request){
        // Try to get the producer or return to the list
        try{
            $producer = ProducerServices::build()->get($request->route()->parameter('producer'));
            return view('pages.manage-farms',['producerId' => $producer->getAttribute('id')]);
        }catch (\Throwable $throwable){
            // Return to the list
            return redirect()->route('manage.producers');
        }
    }
}
