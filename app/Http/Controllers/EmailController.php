<?php

namespace App\Http\Controllers;
use App\Order;
use View;
use Illuminate\Http\Request;
use Mail;
use Config;
use App\User;
use App\Http\Requests;
use Exception;
use Cart;
use Auth;

class EmailController extends Controller
{
    public static function send_confirmation_email($recipient_email){
        if(! $recipient_email){
            return \Response::make('Specify email address', 400);
        }

        $user = User::where('email', $recipient_email)->first();

        $activation_code = $user->activation_code;
        $recipient_email = $recipient_email;
        $recipient_name = $user->name;

        $data = [
            'verify_email_text' => trans('text.verify_email_address'),
            'body' => trans('text.email_confirmation_text', ['name' => $recipient_name, 'email' => $recipient_email, 'confirmation_url'=> env('HOST_ADDRESS') . "/register/verify/{$activation_code}" ] )
        ];

        $response = Mail::send('confirmation_email', $data, function($message) use($activation_code, $recipient_email, $recipient_name) {
            $message->to($recipient_email, $recipient_name )
                ->from( env('MAIL_USERNAME') )
                ->subject(  trans('text.email_message_subject', ['name'=>$recipient_name])   );
        });
        return \Response::make('Email sent successfully', 200);
    }

    public static function send_order_email($data){
        return View::make('order_confirmation', $data);
    }

    public static function password_change(){
        $response = Mail::send('password_change_email', 
            ['password_change_message' => trans('text.password_change_email_body', ['name' => Auth::user()->name] )], 

            function($message){
                $message->to( Auth::user()->email , Auth::user()->name )
                    ->from( env('MAIL_USERNAME') )
                    ->subject( trans('text.password_change_email_title') );
                }
        );
    }

    public static function send_contact_email($data){

        $response = Mail::send('contact_email', $data, function($message){
            $message->to( env('MAIL_USERNAME') , env('MAIL_NAME') )
                ->from( env('MAIL_USERNAME') )
                ->subject( 'New stockist received' );
        });
    }

}
