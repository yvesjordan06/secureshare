<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecretStoreRequest;
use App\Models\Secret;
use App\Models\Receiver;
use App\Notification\NewSecretNotification;
use App\Notifications\SecretAccessNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class SecretController extends Controller
{
    public function create(Request $request): View
    {
        //Get the emails from the request query ?receivers=email1,email2
        $emails = $request->query('receivers');

        //Replace the , with \n
        $emails = str_replace(',', "\n", $emails);
        return view('secret.create', compact('emails'));
    }

    public function store(SecretStoreRequest $request)
    {
        $validatedData = $request->validated();
        $secret = Secret::create([
            'content' => $validatedData['content'],
            'delete_when_viewed' => $validatedData['delete_when_viewed'] ?? false,
        ]);

        $emails = array_filter(
            array_map('trim', explode("\n", $validatedData['receivers'])),
            function ($email) use (&$error) {
                $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
                if ($validEmail === false) {
                    $error = "Email '$email' is not formatted correctly";
                }
                return $validEmail;
            }
        );
        if (isset($error)) {
            return redirect()->back()->withErrors(['receivers' => $error]);
        }

        $receivers = array_map(function ($email) use ($secret) {
            return [
                'secret_id' => $secret->id,
                'email' => $email,
            ];
        }, $emails);

        $secret->receivers()->createMany($receivers);

        $secret->receivers->each(function ($receiver) {
            Notification::route('mail', $receiver->email)
                ->notify(new NewSecretNotification($receiver));
        });

        $request->session()->flash('secret.id', $secret->id);

        return redirect()->back()->with('success', 'Secret created, and sent to ' . count($emails) . ' receivers');
    }


    public function view(Request $request, $id)
    {
        $receiver = Receiver::findOrFail($id);
        $secret = $receiver->secret;

       if($receiver->viewed_at) {
        //Return 404
        abort(404);
       }

       $hasCode = $receiver->access_code !== null;
       $resendQuery = $request->query('resend');
       if (!$hasCode || $resendQuery) {
        $receiver->access_code = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $receiver->save();

            Notification::route('mail', $receiver->email)->notify(new SecretAccessNotification($receiver));

            return redirect()->route("secret.view", $id)->with('success', 'New unlock code sent to ' . $receiver->email);
       }

        return view('secret.view', compact('receiver', 'secret'));
    }

    public function unlock(Request $request, $id)
    {
        $receiver = Receiver::findOrFail($id);
        $secret = $receiver->secret;
        $code = $request->input('code');


        if ($receiver->access_code !== $code) {

            return redirect()->back()->withErrors(['code' =>'Invalid unlock code, a code has been sent to ' . $receiver->email . '. If you did not receive it, please click on "Resend" below.']);
        }

        $receiver->viewed_at = now();
        $receiver->save();

        return view('secret.unlock', compact('receiver', 'secret'));
    }


}
