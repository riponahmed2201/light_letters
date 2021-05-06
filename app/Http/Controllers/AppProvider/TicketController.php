<?php

namespace App\Http\Controllers\AppProvider;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function createTicket(Request $request)
    {
//        if($request->type == 'Admin'){
//            $ticket = new Ticket;
//            $ticket->ticket_id = $request->ticket_id;
//            $ticket->title = $request->title;
//            $ticket->client_id = $request->id;
//            $ticket->email = $request->email;
//            $ticket->description = $request->description;
//            $ticket->date = $request->date;
//            $ticket->status = $request->status;
//            $ticket->type = 'Admin';
//            $ticket->save();
//            return response()->json(['messege'=>'Ticket Created for Admin', 'data'=>$ticket],201);
//        }
//        elseif($request->type == 'Client'){
//            $ticket = new Ticket;
//            $ticket->ticket_id = $request->ticket_id;
//            $ticket->title = $request->title;
//            $ticket->client_id = $request->id;
//            $ticket->email = $request->email;
//            $ticket->description = $request->description;
//            $ticket->date = $request->date;
//            $ticket->status = $request->status;
//            $ticket->type = 'Client';
//            $ticket->save();
//            return response()->json(['messege'=>'Ticket Created for Client', 'data'=>$ticket],201);
//        }
//        else{
//            return response()->json(['messege'=>'Ticket Creation Failed'],400);
//        }
        $ticket = new Ticket;
//        $ticket->ticket_id = $request->ticket_id;
        $ticket->title = $request->title;
        $ticket->client_id = $request->client_id;
        $ticket->email = $request->email;
        $ticket->description = $request->description;
        $ticket->date = $request->date;
        $ticket->cc = $request->cc;
        $ticket->status = 'Pending';
        $ticket->subject = $request->subject;
        $ticket->type = 'Client';
        $ticket->comment = null;
        $ticket->save();
        return response()->json(['messege'=>'Ticket Created for Client', 'data'=>$ticket],201);
    }
    public function getTicket(){
        $ticket = Ticket::all();
        return response()->json($ticket,200);
    }
    public function clientsTicket($client_id){
        $tickets = Ticket::where('client_id',$client_id)->get();
        return response()->json($tickets,200);
    }
    public function changeTicketStatus(Request $request,$ticket_id){
        Ticket::where('ticket_id',$ticket_id)->update([
            'status'=>$request->status,
        ]);
        return response()->json(['status'=>'Ticket status changed'],201);
    }
    public function commentTicket(Request $request,$ticket_id){
        Ticket::where('ticket_id',$ticket_id)->update([
            'comment'=>$request->comment,
        ]);
        return response()->json(['status'=>'Commented successfully'],201);
    }
}



